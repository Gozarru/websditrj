<?php

namespace App\Support;

use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

/**
 * Alur publikasi: Draf → Diajukan → Diperiksa → Disetujui → Tayang/Terjadwal.
 * Setiap langkah dibatasi hak akses dan dicatat di log aktivitas.
 */
class PostWorkflow
{
    public const ACTIONS = [
        'submit' => ['Ajukan untuk diperiksa', 'btn'],
        'check' => ['Tandai sudah diperiksa', 'btn'],
        'approve' => ['Setujui', 'btn'],
        'return' => ['Kembalikan ke penulis', 'btn del'],
        'publish' => ['Terbitkan', 'btn gold'],
        'unpublish' => ['Tarik dari website', 'btn sec'],
    ];

    /** Tahap yang ditampilkan di stepper (urutan alur). */
    public const STEPS = ['draft' => 'Dibuat', 'submitted' => 'Diajukan', 'checked' => 'Diperiksa', 'approved' => 'Disetujui', 'published' => 'Terbit'];

    /** @return string[] aksi yang boleh dilakukan $u pada $p */
    public static function allowed(Post $p, User $u): array
    {
        $a = [];
        $own = $p->author_id === $u->id || $u->hasPermission('posts.manage');
        // Pemeriksa/penyetuju tidak boleh menilai tulisannya sendiri (kecuali Admin).
        $notSelf = $p->author_id !== $u->id || $u->isAdmin();

        if ($p->status === 'draft' && $u->hasPermission('posts.write') && $own) {
            $a[] = 'submit';
        }
        if ($p->status === 'submitted' && $u->hasPermission('posts.check') && $notSelf) {
            array_push($a, 'check', 'return');
        }
        if ($p->status === 'checked' && $u->hasPermission('posts.approve') && $notSelf) {
            array_push($a, 'approve', 'return');
        }
        if ($p->status === 'approved' && $u->hasPermission('posts.publish')) {
            array_push($a, 'publish', 'return');
        }
        if (in_array($p->status, ['published', 'scheduled'], true) && $u->hasPermission('posts.publish')) {
            $a[] = 'unpublish';
        }

        return $a;
    }

    public static function canEdit(Post $p, User $u): bool
    {
        if ($u->hasPermission('posts.manage')) {
            return true;
        }

        return $u->hasPermission('posts.write') && $p->author_id === $u->id && $p->status === 'draft';
    }

    public static function canDelete(Post $p, User $u): bool
    {
        return self::canEdit($p, $u);
    }

    /** @throws \DomainException bila aksi tidak diizinkan atau data tidak valid */
    public static function apply(Post $p, string $action, User $u, ?string $note = null, ?string $publishAt = null): string
    {
        if (! in_array($action, self::allowed($p, $u), true)) {
            throw new \DomainException('Aksi ini tidak tersedia untuk Anda atau tidak sesuai tahap tulisan saat ini.');
        }

        $label = "{$p->typeLabel()}: {$p->title}";
        $note = trim((string) $note);
        $msg = '';

        switch ($action) {
            case 'submit':
                $p->status = 'submitted';
                $p->submitted_at = now();
                $p->review_note = null;
                $log = "Mengajukan $label untuk diperiksa";
                $msg = 'Tulisan diajukan untuk diperiksa.';
                break;

            case 'check':
                $p->status = 'checked';
                $p->checked_by = $u->id;
                $p->checked_at = now();
                $log = "Memeriksa $label dan meneruskannya ke Kepala Sekolah";
                $msg = 'Tulisan ditandai sudah diperiksa dan menunggu persetujuan.';
                break;

            case 'approve':
                $p->status = 'approved';
                $p->approved_by = $u->id;
                $p->approved_at = now();
                $log = "Menyetujui $label";
                $msg = 'Tulisan disetujui dan siap diterbitkan.';
                break;

            case 'return':
                if ($note === '') {
                    throw new \DomainException('Tulis alasan pengembalian agar penulis tahu apa yang perlu diperbaiki.');
                }
                $p->status = 'draft';
                $p->review_note = $note;
                $log = "Mengembalikan $label ke penulis — catatan: $note";
                $msg = 'Tulisan dikembalikan ke penulis.';
                break;

            case 'publish':
                $when = $publishAt ? Carbon::parse($publishAt) : ($p->published_at && $p->published_at->isFuture() ? $p->published_at : now());
                $p->published_by = $u->id;
                if ($when->isFuture()) {
                    $p->status = 'scheduled';
                    $p->published_at = $when;
                    $log = "Menjadwalkan $label tayang pada ".$when->translatedFormat('j F Y H:i');
                    $msg = 'Dijadwalkan tayang otomatis pada '.$when->translatedFormat('j F Y, H:i').' WIB.';
                } else {
                    $p->status = 'published';
                    $p->published_at = now();
                    $log = "Menerbitkan $label";
                    $msg = 'Tulisan sudah tayang di website.';
                }
                break;

            case 'unpublish':
                $p->status = 'approved';
                $log = "Menarik $label dari website";
                $msg = 'Tulisan ditarik dari website dan kembali berstatus disetujui.';
                break;
        }

        Post::withoutEvents(fn () => $p->save());
        ActivityLog::record($action, $log, $p);

        return $msg;
    }
}

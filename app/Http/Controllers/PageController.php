<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\GalleryPhoto;
use App\Models\LearningMedia;
use App\Models\Post;

class PageController extends Controller
{
    public function profil(string $slug)
    {
        $pages = config('site.profil_pages');
        abort_unless(isset($pages[$slug]), 404);

        return view('pages.profil', [
            'slug' => $slug,
            'pages' => $pages,
            'title' => $pages[$slug][0],
            'intro' => $pages[$slug][1],
            'body' => site('profil_'.str_replace('-', '_', $slug)),
        ]);
    }

    public function pengumuman()
    {
        return view('pages.pengumuman', [
            'posts' => Post::published()->ofType('pengumuman')->latest('published_at')->latest('id')->paginate(12),
        ]);
    }

    public function agenda()
    {
        return view('pages.agenda', [
            'upcoming' => Agenda::upcoming()->get(),
            'past' => Agenda::where('starts_on', '<', today())->whereRaw('COALESCE(ends_on, starts_on) < ?', [today()->toDateString()])
                ->orderByDesc('starts_on')->take(12)->get(),
        ]);
    }

    public function prestasi()
    {
        return view('pages.prestasi', [
            'achievements' => Achievement::orderByDesc('year')->orderByDesc('id')->get(),
        ]);
    }

    public function media(?string $grade = null)
    {
        $grades = config('site.grades');
        $current = $grade
            ? collect($grades)->first(fn ($g) => grade_slug($g) === $grade)
            : $grades[0];
        abort_unless($current, 404);

        $all = LearningMedia::orderBy('title')->get()->groupBy('grade');

        return view('pages.media', [
            'grades' => $grades,
            'current' => $current,
            'counts' => $all->map->count(),
            'items' => $all->get($current, collect()),
        ]);
    }

    public function galeri()
    {
        return view('pages.galeri', [
            'photos' => GalleryPhoto::latest()->latest('id')->paginate(24),
        ]);
    }

    public function kontak()
    {
        return view('pages.kontak');
    }
}

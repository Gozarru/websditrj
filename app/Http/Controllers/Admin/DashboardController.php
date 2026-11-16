<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Post;
use App\Models\Visit;
use App\Support\PostWorkflow;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $r)
    {
        $u = $r->user();
        Post::promoteDue();

        // Pengunjung (unik per hari)
        $from = today()->subDays(13);
        $perDay = Visit::where('visited_on', '>=', $from->toDateString())
            ->selectRaw('visited_on, count(*) as n')->groupBy('visited_on')->pluck('n', 'visited_on')
            ->mapWithKeys(fn ($n, $d) => [substr((string) $d, 0, 10) => $n]);
        $chart = [];
        for ($i = 0; $i < 14; $i++) {
            $d = $from->copy()->addDays($i);
            $chart[] = ['label' => $d->translatedFormat('j M'), 'short' => $d->format('j'), 'n' => (int) ($perDay[$d->toDateString()] ?? 0)];
        }
        $visits = [
            'today' => Visit::where('visited_on', today()->toDateString())->count(),
            'week' => Visit::where('visited_on', '>=', today()->subDays(6)->toDateString())->count(),
            'month' => Visit::where('visited_on', '>=', today()->subDays(29)->toDateString())->count(),
            'total' => Visit::count(),
            'views30' => (int) Visit::where('visited_on', '>=', today()->subDays(29)->toDateString())->sum('hits'),
        ];

        // Konten
        $scope = fn (string $type) => Post::visibleTo($u)->ofType($type);
        $content = [
            'berita' => ['live' => $scope('berita')->published()->count(), 'all' => $scope('berita')->count()],
            'pengumuman' => ['live' => $scope('pengumuman')->published()->count(), 'all' => $scope('pengumuman')->count()],
            'agenda' => ['upcoming' => Agenda::upcoming()->count(), 'all' => Agenda::count()],
        ];

        // Alur publikasi & antrean tindakan untuk pengguna ini
        $status = Post::visibleTo($u)->selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');
        $queue = Post::visibleTo($u)->with('author')->latest('updated_at')->limit(60)->get()
            ->filter(fn ($p) => array_intersect(PostWorkflow::allowed($p, $u), ['check', 'approve', 'publish']) || ($p->status === 'draft' && $p->review_note && $p->author_id === $u->id))
            ->take(6);

        $logs = $u->can('audit.view')
            ? ActivityLog::latest()->latest('id')->take(8)->get()
            : ActivityLog::where('user_id', $u->id)->latest()->latest('id')->take(8)->get();

        return view('admin.dashboard', compact('visits', 'chart', 'content', 'status', 'queue', 'logs') + ['user' => $u]);
    }
}

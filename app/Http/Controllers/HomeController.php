<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\GalleryPhoto;
use App\Models\LearningMedia;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $captions = config('site.slide_captions');
        $slides = [];

        // 1) Foto slider yang diunggah admin
        foreach ($captions as $i => $default) {
            $n = $i + 1;
            if (site("slide_{$n}_image")) {
                $slides[] = ['image' => upload_url(site("slide_{$n}_image")), 'caption' => site("slide_{$n}_caption") ?: $default];
            }
        }

        // 2) Bila belum ada, pakai foto terbaru dari galeri
        if (! $slides) {
            foreach (GalleryPhoto::latest()->latest('id')->take(4)->get() as $i => $ph) {
                $slides[] = ['image' => upload_url($ph->image), 'caption' => $ph->caption ?: ($captions[$i] ?? '')];
            }
        }

        return view('home', [
            'slides' => $slides,
            'posts' => Post::published()->ofType('berita')->latest('published_at')->latest('id')->take(3)->get(),
            'announcements' => Post::published()->ofType('pengumuman')->latest('published_at')->latest('id')->take(4)->get(),
            'agendas' => Agenda::upcoming()->take(4)->get(),
            'achievements' => Achievement::orderByDesc('year')->orderByDesc('id')->take(6)->get(),
            'media' => LearningMedia::orderBy('title')->get()->groupBy('grade'),
            'photos' => GalleryPhoto::latest()->latest('id')->take(8)->get(),
        ]);
    }
}

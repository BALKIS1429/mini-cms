<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PageController extends Controller
{
    public function home()
    {
        return view('home', [
            'latestPosts' => Post::published()
                ->with('user', 'category', 'tags')
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function about()
    {
        return view('a-propos', [
            'auteur' => 'Balkis Riahi',
            'groupe' => 'MDW33',
        ]);
    }

    public function time()
    {
        return view('heure', [
            'heure' => now()->format('H:i'),
            'date' => now()->format('d/m/Y'),
        ]);
    }
}

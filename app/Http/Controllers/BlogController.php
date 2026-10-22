<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(9)->withQueryString();
        $categories = Post::published()->distinct()->pluck('category')->filter();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $recentPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        $whatsappPrefill = "Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I read your article on Covilakam Astrology: \"" . $post->title . "\". I would like to consult with you.";
        $whatsappUrl = 'https://wa.me/917907052160?text=' . rawurlencode($whatsappPrefill);

        return view('blog.show', compact('post', 'recentPosts', 'whatsappUrl'));
    }
}

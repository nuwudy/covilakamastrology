<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->whereNotNull('published_at')->where('published_at', '<=', now());
            } elseif ($request->status === 'draft') {
                $query->where(function ($q) {
                    $q->whereNull('published_at')->orWhere('published_at', '>', now());
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $categories = Post::select('category')->distinct()->pluck('category');

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = [
            'Vedic Philosophy',
            'Marriage Compatibility',
            'Gemology',
            'Temple Remedies',
            'Online Counselling',
            'Planetary Transits',
            'Vaastu Shastra',
        ];

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category' => 'required|string|max:100',
            'reading_time' => 'nullable|string|max:50',
            'featured_image_file' => 'nullable|image|max:10240', // max 10MB
            'featured_image_url' => 'nullable|string|max:500',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'author_name' => 'nullable|string|max:200',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            if (empty($baseSlug)) {
                // If Malayalam title has no ASCII slug, use timestamp or fallback
                $baseSlug = 'article-' . time();
            }
            $slug = $baseSlug;
            $counter = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Handle Image upload or URL
        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('posts', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        } elseif (!empty($validated['featured_image_url'])) {
            $validated['featured_image'] = $validated['featured_image_url'];
        }

        // Published status
        if ($request->boolean('is_published')) {
            $validated['published_at'] = !empty($validated['published_at']) 
                ? Carbon::parse($validated['published_at']) 
                : now();
        } else {
            $validated['published_at'] = null;
        }

        // Default author
        if (empty($validated['author_name'])) {
            $validated['author_name'] = 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)';
        }

        if (empty($validated['reading_time'])) {
            $validated['reading_time'] = '5 min read';
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'New article published to Vedic Wisdom Repository successfully!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $categories = [
            'Vedic Philosophy',
            'Marriage Compatibility',
            'Gemology',
            'Temple Remedies',
            'Online Counselling',
            'Planetary Transits',
            'Vaastu Shastra',
        ];

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category' => 'required|string|max:100',
            'reading_time' => 'nullable|string|max:50',
            'featured_image_file' => 'nullable|image|max:10240',
            'featured_image_url' => 'nullable|string|max:500',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'author_name' => 'nullable|string|max:200',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        // Handle Image upload or URL
        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('posts', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        } elseif (!empty($validated['featured_image_url'])) {
            $validated['featured_image'] = $validated['featured_image_url'];
        }

        // Published status
        if ($request->boolean('is_published')) {
            $validated['published_at'] = !empty($validated['published_at']) 
                ? Carbon::parse($validated['published_at']) 
                : ($post->published_at ?? now());
        } else {
            $validated['published_at'] = null;
        }

        if (empty($validated['author_name'])) {
            $validated['author_name'] = 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)';
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $title = $post->title;
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', "Article '{$title}' deleted successfully.");
    }
}

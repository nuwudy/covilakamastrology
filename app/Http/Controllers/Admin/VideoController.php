<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of videos.
     */
    public function index(Request $request)
    {
        $query = Video::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('youtube_id', 'like', "%{$search}%");
            });
        }

        $videos = $query->orderBy('sort_order', 'asc')->get();

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create()
    {
        $nextSortOrder = (Video::max('sort_order') ?? 0) + 1;
        return view('admin.videos.create', compact('nextSortOrder'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|string',
            'youtube_id' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:20',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        // Smart YouTube Parser
        $youtubeId = Video::parseYoutubeId($validated['youtube_url']);
        if (!$youtubeId && !empty($validated['youtube_id'])) {
            $youtubeId = Video::parseYoutubeId($validated['youtube_id']);
        }

        if (!$youtubeId) {
            return back()->withInput()->withErrors([
                'youtube_url' => 'Could not extract valid 11-character YouTube video ID from the provided URL or ID. Please check the URL format.',
            ]);
        }

        $validated['youtube_id'] = $youtubeId;
        $validated['is_active'] = $request->boolean('is_active', true);

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video successfully added to the Vedic Astrology Video Gallery!');
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|string',
            'youtube_id' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:20',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        // Smart YouTube Parser
        $youtubeId = Video::parseYoutubeId($validated['youtube_url']);
        if (!$youtubeId && !empty($validated['youtube_id'])) {
            $youtubeId = Video::parseYoutubeId($validated['youtube_id']);
        }

        if (!$youtubeId) {
            $youtubeId = $video->youtube_id; // Keep existing if cannot parse
        }

        $validated['youtube_id'] = $youtubeId;
        $validated['is_active'] = $request->boolean('is_active');

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video details updated successfully!');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(Video $video)
    {
        $video->update(['is_active' => !$video->is_active]);

        return back()->with('success', 'Video active status changed to ' . ($video->is_active ? 'Active' : 'Hidden') . '.');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video)
    {
        $title = $video->title;
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', "Video '{$title}' removed successfully.");
    }
}

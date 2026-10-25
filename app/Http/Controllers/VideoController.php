<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display the exclusive Vedic Astrology Video Gallery (Cinema / Movie Showcase Style).
     */
    public function index(Request $request)
    {
        $videos = Video::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Featured spotlight video (strictly sort_order 1 or newest)
        $featuredVideo = $videos->firstWhere('sort_order', 1) ?? $videos->first();

        // Video to auto-open if ?watch=youtube_id or ?watch=id is passed
        $initialWatchVideo = null;
        if ($request->filled('watch')) {
            $watchTarget = $request->watch;
            $initialWatchVideo = $videos->first(function ($v) use ($watchTarget) {
                return $v->id == $watchTarget || $v->youtube_id == $watchTarget;
            });
        }

        return view('videos.index', compact('videos', 'featuredVideo', 'initialWatchVideo'));
    }

    /**
     * Display an individual video showcase page (Direct Cinema View with SEO VideoObject).
     */
    public function show($id)
    {
        $video = Video::where('is_active', true)
            ->where(function ($q) use ($id) {
                $q->where('id', $id)
                  ->orWhere('youtube_id', $id);
            })
            ->firstOrFail();

        $otherVideos = Video::where('is_active', true)
            ->where('id', '!=', $video->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('videos.show', compact('video', 'otherVideos'));
    }
}

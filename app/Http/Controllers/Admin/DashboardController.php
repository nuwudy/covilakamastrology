<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\MediaItem;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard Overview.
     */
    public function index()
    {
        $stats = [
            'total_videos' => Video::count(),
            'active_videos' => Video::where('is_active', true)->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'total_consultations' => Consultation::count(),
            'pending_consultations' => Consultation::where('status', 'pending')->count(),
            'total_media' => MediaItem::count(),
        ];

        $recentVideos = Video::orderBy('sort_order', 'asc')->take(5)->get();
        $recentPosts = Post::orderBy('created_at', 'desc')->take(5)->get();
        $recentConsultations = Consultation::orderBy('created_at', 'desc')->take(6)->get();

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.dashboard.index', compact('stats', 'recentVideos', 'recentPosts', 'recentConsultations', 'settings'));
    }
}

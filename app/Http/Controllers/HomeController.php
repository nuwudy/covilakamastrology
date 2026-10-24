<?php

namespace App\Http\Controllers;

use App\Models\AstrologyTranslation;
use App\Models\Book;
use App\Models\Post;
use App\Models\Qualification;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $qualifications = Qualification::orderBy('sort_order', 'asc')->get();
        $services = Service::orderBy('sort_order', 'asc')->get();
        $videos = Video::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $translations = AstrologyTranslation::orderBy('sort_order', 'asc')->get()->keyBy('language_code');
        $posts = Post::published()->orderBy('published_at', 'desc')->take(6)->get();
        $books = Book::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('home', compact(
            'settings',
            'qualifications',
            'services',
            'videos',
            'translations',
            'posts',
            'books'
        ));
    }
}

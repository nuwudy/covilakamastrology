<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaLibraryController extends Controller
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Display media library items.
     */
    public function index(Request $request)
    {
        $query = MediaItem::query();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('file_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $mediaItems = $query->orderBy('created_at', 'desc')->paginate(18)->withQueryString();

        // Statistics
        $counts = [
            'all' => MediaItem::count(),
            'image' => MediaItem::where('file_type', 'image')->count(),
            'audio' => MediaItem::where('file_type', 'audio')->count(),
            'video' => MediaItem::where('file_type', 'video')->count(),
            'pdf' => MediaItem::where('file_type', 'pdf')->count(),
        ];

        $totalBytes = MediaItem::sum('file_size');
        $units = ['B', 'KB', 'MB', 'GB'];
        $formattedTotalSize = '0 B';
        if ($totalBytes > 0) {
            $b = $totalBytes;
            for ($i = 0; $b > 1024 && $i < count($units) - 1; $i++) {
                $b /= 1024;
            }
            $formattedTotalSize = round($b, 2) . ' ' . $units[$i];
        }

        return view('admin.media.index', compact('mediaItems', 'counts', 'formattedTotalSize'));
    }

    /**
     * Handle media file upload.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // max 50MB
            'title' => 'nullable|string|max:150',
            'alt_text' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:1000',
        ]);

        $mediaItem = $this->mediaService->processUpload($request->file('file'), [
            'title' => $request->input('title'),
            'alt_text' => $request->input('alt_text'),
            'description' => $request->input('description'),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $mediaItem->is_webp ? 'File uploaded and optimized to WebP successfully!' : 'File uploaded successfully!',
                'data' => $mediaItem,
            ]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', $mediaItem->is_webp ? 'Image uploaded and converted to WebP successfully!' : 'Media item uploaded successfully!');
    }

    /**
     * Update media details.
     */
    public function update(Request $request, int $id)
    {
        $mediaItem = MediaItem::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'alt_text' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:1000',
        ]);

        $mediaItem->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media metadata updated.',
                'data' => $mediaItem,
            ]);
        }

        return back()->with('success', 'Media metadata updated successfully.');
    }

    /**
     * Delete media item.
     */
    public function destroy(int $id)
    {
        $mediaItem = MediaItem::findOrFail($id);
        $this->mediaService->deleteMedia($mediaItem);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media item deleted successfully.',
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Media item deleted successfully.');
    }
}

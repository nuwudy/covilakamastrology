<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('malayalam_title', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $books = $query->orderBy('sort_order', 'asc')->get();

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $nextSortOrder = (Book::max('sort_order') ?? 0) + 1;
        return view('admin.books.create', compact('nextSortOrder'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'malayalam_title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'cover_image' => 'nullable|string|max:255',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ebook_url' => 'nullable|url|max:1000',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle uploaded cover image file if provided
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/books'), $fileName);
            $validated['cover_image'] = 'images/books/' . $fileName;
        }

        if (empty($validated['cover_image'])) {
            $validated['cover_image'] = 'images/books/manoratham.jpg';
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'malayalam_title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'cover_image' => 'nullable|string|max:255',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ebook_url' => 'nullable|url|max:1000',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle uploaded cover image file if provided
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/books'), $fileName);
            $validated['cover_image'] = 'images/books/' . $fileName;
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}

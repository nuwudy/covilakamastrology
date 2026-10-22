<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AstrologyTranslation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display all 4 astrology translations for editing.
     */
    public function index()
    {
        $translations = AstrologyTranslation::orderBy('sort_order', 'asc')->get();
        return view('admin.translations.index', compact('translations'));
    }

    /**
     * Update specified translation.
     */
    public function update(Request $request, AstrologyTranslation $translation)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'content' => 'required|string',
        ]);

        $translation->update($validated);

        return back()->with('success', "Updated {$translation->language_name} astrology content successfully.");
    }
}

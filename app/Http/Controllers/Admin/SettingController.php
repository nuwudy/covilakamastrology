<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show settings and profile credentials form.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $qualifications = Qualification::orderBy('sort_order', 'asc')->get();

        return view('admin.settings.index', compact('settings', 'qualifications'));
    }

    /**
     * Update settings in storage.
     */
    public function update(Request $request)
    {
        $fields = [
            'astrologer_name',
            'astrologer_subtitle',
            'brand_name',
            'tagline',
            'whatsapp_number',
            'whatsapp_raw',
            'phone_primary',
            'phone_raw',
            'gpay_number',
            'email_primary',
            'email_secondary',
            'website',
            'iaf_member_id',
            'experience_year',
            'convocation_date',
            'about_bio',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field), 'group' => 'general']
                );
            }
        }

        // Handle profile photo upload if provided
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile', 'public');
            Setting::updateOrCreate(
                ['key' => 'profile_photo'],
                ['value' => 'storage/' . $path, 'group' => 'general']
            );
        }

        return back()->with('success', 'Portal settings, credentials, and contact details updated successfully!');
    }
}

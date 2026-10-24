<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    private function getSettings(): array
    {
        return Setting::all()->pluck('value', 'key')->toArray();
    }

    public function terms()
    {
        $settings = $this->getSettings();
        return view('policies.terms', compact('settings'));
    }

    public function privacy()
    {
        $settings = $this->getSettings();
        return view('policies.privacy', compact('settings'));
    }

    public function refund()
    {
        $settings = $this->getSettings();
        return view('policies.refund', compact('settings'));
    }

    public function shipping()
    {
        $settings = $this->getSettings();
        return view('policies.shipping', compact('settings'));
    }

    public function contact()
    {
        $settings = $this->getSettings();
        return view('policies.contact', compact('settings'));
    }

    public function about()
    {
        $settings = $this->getSettings();
        return view('policies.about', compact('settings'));
    }
}

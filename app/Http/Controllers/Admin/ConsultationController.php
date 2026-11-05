<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AstrologyReading;
use App\Models\Consultation;
use App\Services\AntiSpamService;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display listing of consultations and DOB leads.
     */
    public function index(Request $request)
    {
        $query = Consultation::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service')) {
            $query->where('service_requested', $request->service);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('birth_place', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $consultations = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'all' => Consultation::count(),
            'pending' => Consultation::where('status', 'pending')->count(),
            'completed' => Consultation::where('status', 'completed')->count(),
            'spam' => AntiSpamService::applySpamQuery(Consultation::query())->count(),
        ];

        return view('admin.consultations.index', compact('consultations', 'stats'));
    }

    /**
     * Update consultation status.
     */
    public function updateStatus(Request $request, Consultation $consultation)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,archived',
        ]);

        $consultation->update(['status' => $request->status]);

        return back()->with('success', 'Lead status updated to ' . ucfirst($request->status));
    }

    /**
     * Delete consultation entry.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return back()->with('success', 'Consultation lead deleted successfully.');
    }

    /**
     * Purge all spam / bot leads in 1-click.
     */
    public function purgeSpam()
    {
        $deletedConsultations = AntiSpamService::applySpamQuery(Consultation::query())->delete();

        // Also clean up any unlinked free spam entries in astrology_readings table
        $deletedReadings = AstrologyReading::where('paid_tier', 'free')
            ->where(function ($q) {
                $q->where('full_name', 'like', '1win%')
                  ->orWhere('full_name', 'like', 'mostbet%')
                  ->orWhere('full_name', 'like', 'pinco%')
                  ->orWhere('full_name', 'like', 'chicken-road%')
                  ->orWhere('full_name', 'like', 'chicken_road%')
                  ->orWhere('full_name', 'like', '%GeorgeHex%');
            })->delete();

        return back()->with('success', "Spam leads purged successfully! Removed {$deletedConsultations} spam consultation leads and {$deletedReadings} bot calculation records.");
    }
}

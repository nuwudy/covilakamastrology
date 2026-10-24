<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $type = $request->query('type');

        $query = Order::with('product')->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('payment_status', $status);
        }

        if ($type) {
            $query->where('product_type', $type);
        }

        $orders = $query->paginate(15);

        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');
        $paidCount = Order::where('payment_status', 'paid')->count();
        $pendingCount = Order::where('payment_status', 'pending')->count();
        $booksCount = Order::where('product_type', 'book')->where('payment_status', 'paid')->count();

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.orders.index', compact(
            'orders',
            'status',
            'type',
            'totalRevenue',
            'paidCount',
            'pendingCount',
            'booksCount',
            'settings'
        ));
    }

    public function updateDeliveryStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'delivery_status' => 'required|string|in:pending,processing_shipment,shipped,delivered,ready_for_download,scheduled',
            'notes' => 'nullable|string|max:500',
        ]);

        $order->update($validated);

        return back()->with('success', "Order #{$order->order_number} delivery status updated to {$order->delivery_status}!");
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', "Order deleted successfully.");
    }
}

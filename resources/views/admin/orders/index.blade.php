@extends('layouts.admin')

@section('title', 'Book Orders & Service Payments | Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-cinzel font-bold text-amber-300">
                Book Orders & Razorpay Payments
            </h1>
            <p class="text-xs text-amber-200/60 mt-1">
                Manage physical book shipments, digital Jathakam downloads, and paid consultation appointments.
            </p>
        </div>

        <a href="{{ route('shop.index') }}" target="_blank"
           class="px-4 py-2 rounded-xl text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30 hover:bg-amber-500/25 transition-all inline-flex items-center space-x-1.5 self-start">
            <span>🛒</span>
            <span>View Public Bookstore</span>
        </a>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/25 shadow-xl">
            <span class="text-xs text-amber-400 font-semibold uppercase block">Total Verified Revenue</span>
            <p class="text-2xl font-cinzel font-extrabold text-amber-300 mt-1">
                ₹{{ number_format($totalRevenue, 2) }}
            </p>
            <span class="text-[10px] text-emerald-400">Processed via Razorpay</span>
        </div>

        <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/25 shadow-xl">
            <span class="text-xs text-amber-400 font-semibold uppercase block">Paid Transactions</span>
            <p class="text-2xl font-cinzel font-extrabold text-emerald-400 mt-1">
                {{ $paidCount }}
            </p>
            <span class="text-[10px] text-amber-200/60">Successful checkouts</span>
        </div>

        <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/25 shadow-xl">
            <span class="text-xs text-amber-400 font-semibold uppercase block">Pending Book Orders</span>
            <p class="text-2xl font-cinzel font-extrabold text-amber-200 mt-1">
                {{ $booksCount }}
            </p>
            <span class="text-[10px] text-amber-200/60">For courier dispatch</span>
        </div>

        <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/25 shadow-xl">
            <span class="text-xs text-amber-400 font-semibold uppercase block">Pending / Incomplete</span>
            <p class="text-2xl font-cinzel font-extrabold text-amber-400/80 mt-1">
                {{ $pendingCount }}
            </p>
            <span class="text-[10px] text-amber-200/60">Awaiting payment</span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-[#140b22] border border-amber-500/25 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-amber-500/20 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-amber-300">Filter By Status:</span>
                <a href="{{ route('admin.orders.index') }}" class="px-2.5 py-1 rounded-lg {{ empty($status) ? 'bg-amber-400 text-[#1a1128] font-bold' : 'text-amber-200 hover:bg-amber-500/10' }}">All</a>
                <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="px-2.5 py-1 rounded-lg {{ $status === 'paid' ? 'bg-amber-400 text-[#1a1128] font-bold' : 'text-amber-200 hover:bg-amber-500/10' }}">Paid</a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-2.5 py-1 rounded-lg {{ $status === 'pending' ? 'bg-amber-400 text-[#1a1128] font-bold' : 'text-amber-200 hover:bg-amber-500/10' }}">Pending</a>
            </div>

            <div class="flex items-center space-x-2">
                <span class="font-bold text-amber-300">Product:</span>
                <a href="{{ route('admin.orders.index', ['type' => 'book']) }}" class="px-2 py-0.5 rounded text-[11px] {{ $type === 'book' ? 'bg-amber-500/30 text-amber-200' : 'text-amber-200/70 hover:text-amber-100' }}">Books</a>
                <a href="{{ route('admin.orders.index', ['type' => 'digital_pdf']) }}" class="px-2 py-0.5 rounded text-[11px] {{ $type === 'digital_pdf' ? 'bg-amber-500/30 text-amber-200' : 'text-amber-200/70 hover:text-amber-100' }}">Jathakam PDFs</a>
                <a href="{{ route('admin.orders.index', ['type' => 'consultation']) }}" class="px-2 py-0.5 rounded text-[11px] {{ $type === 'consultation' ? 'bg-amber-500/30 text-amber-200' : 'text-amber-200/70 hover:text-amber-100' }}">Consultations</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-amber-100/90">
                <thead class="bg-[#1a1128] text-amber-400 uppercase text-[10px] border-b border-amber-500/20">
                    <tr>
                        <th class="py-3 px-4">Order Ref</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Item & Type</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Payment</th>
                        <th class="py-3 px-4">Delivery & Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/10">
                    @forelse($orders as $order)
                        <tr class="hover:bg-amber-500/5 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-medium text-amber-300">
                                {{ $order->order_number }}
                                <span class="block text-[10px] text-amber-200/50">{{ $order->created_at->format('d M, h:i A') }}</span>
                            </td>

                            <td class="py-3.5 px-4">
                                <strong class="text-amber-200 block">{{ $order->customer_name }}</strong>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank"
                                   class="text-emerald-400 hover:underline flex items-center space-x-1 mt-0.5">
                                    <span>💬</span>
                                    <span>{{ $order->customer_phone }}</span>
                                </a>
                                @if($order->shipping_address)
                                    <div class="mt-1 p-1.5 bg-[#0d0716] rounded border border-amber-500/20 text-[10px] text-amber-200/80 max-w-xs">
                                        📍 {{ $order->shipping_address }}
                                    </div>
                                @endif
                                @if($order->birth_details)
                                    <div class="mt-1 text-[10px] text-amber-400/80">
                                        DOB: {{ $order->birth_details['birth_date'] ?? 'N/A' }} | Time: {{ $order->birth_details['birth_time'] ?? 'N/A' }}
                                    </div>
                                @endif
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-medium text-amber-100 block">{{ $order->product_title }}</span>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[9px] uppercase font-bold {{ $order->product_type === 'book' ? 'bg-blue-500/15 text-blue-300' : ($order->product_type === 'digital_pdf' ? 'bg-purple-500/15 text-purple-300' : 'bg-amber-500/15 text-amber-300') }}">
                                    {{ $order->product_type }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 font-bold text-amber-300 text-sm">
                                {{ $order->formatted_amount }}
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-amber-500/15 text-amber-300' }}">
                                    {{ $order->payment_status }}
                                </span>
                                @if($order->razorpay_payment_id)
                                    <span class="block font-mono text-[9px] text-amber-200/50 mt-1 truncate max-w-[120px]">
                                        {{ $order->razorpay_payment_id }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 space-y-2">
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex items-center space-x-1.5">
                                    @csrf
                                    <select name="delivery_status" class="bg-[#0f0819] border border-amber-500/30 rounded px-2 py-1 text-[11px] text-amber-200">
                                        <option value="pending" {{ $order->delivery_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing_shipment" {{ $order->delivery_status === 'processing_shipment' ? 'selected' : '' }}>Processing Shipment</option>
                                        <option value="shipped" {{ $order->delivery_status === 'shipped' ? 'selected' : '' }}>Shipped (Speed Post)</option>
                                        <option value="delivered" {{ $order->delivery_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="ready_for_download" {{ $order->delivery_status === 'ready_for_download' ? 'selected' : '' }}>PDF Ready</option>
                                        <option value="scheduled" {{ $order->delivery_status === 'scheduled' ? 'selected' : '' }}>Consultation Scheduled</option>
                                    </select>
                                    <button type="submit" class="px-2 py-1 rounded bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 text-[10px] font-semibold">
                                        Save
                                    </button>
                                </form>

                                @if($order->product_type === 'digital_pdf' && $order->payment_status === 'paid')
                                    <a href="{{ route('shop.download-jathakam', $order->order_number) }}" target="_blank"
                                       class="inline-flex items-center space-x-1 text-[11px] text-amber-300 hover:text-amber-100 underline">
                                        <span>📜</span>
                                        <span>Preview Generated Jathakam PDF</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-amber-200/60">
                                No customer orders recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-amber-500/20">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

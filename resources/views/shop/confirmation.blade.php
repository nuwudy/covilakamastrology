@extends('layouts.app')

@section('title', 'Order Confirmation #' . $order->order_number . ' | Covilakam Astrology')
@section('meta_description', 'Order confirmation and receipt for Covilakam Astrology.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Success Banner -->
        <div class="bg-[#140b22] border border-emerald-500/40 rounded-3xl p-6 sm:p-10 shadow-2xl text-center space-y-4 mb-8">
            <div class="w-16 h-16 mx-auto rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-3xl">
                ✓
            </div>
            <div>
                <span class="text-xs uppercase font-bold tracking-wider text-emerald-400">Payment Verified via Razorpay</span>
                <h1 class="font-cinzel text-2xl sm:text-4xl font-extrabold text-amber-300 mt-1">
                    Thank You, {{ $order->customer_name }}!
                </h1>
                <p class="text-xs text-amber-200/70 mt-1">
                    Your order has been confirmed. Order Reference: <strong class="text-amber-300 font-mono">{{ $order->order_number }}</strong>
                </p>
            </div>

            <!-- Instant Digital Download Button for Jathakam PDF -->
            @if($order->product_type === 'digital_pdf')
                <div class="p-6 rounded-2xl bg-gradient-to-br from-amber-950/60 to-purple-950/60 border border-amber-500/40 shadow-inner space-y-3 mt-4">
                    <span class="text-2xl block">📜</span>
                    <h2 class="font-cinzel text-xl font-bold text-amber-200">
                        Your Deluxe Vedic Jathakam (PDF Report) is Ready!
                    </h2>
                    <p class="text-xs text-amber-100/80 max-w-lg mx-auto">
                        Your personalized astrological birth chart, Dasa-Bhukthi calculations, and life predictions have been processed. You can download or print your report immediately below.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('shop.download-jathakam', $order->order_number) }}"
                           target="_blank"
                           class="inline-flex items-center space-x-2 px-8 py-4 rounded-xl font-cinzel font-bold text-sm uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all transform hover:-translate-y-0.5">
                            <span>📥</span>
                            <span>Download Deluxe Jathakam PDF Now</span>
                        </a>
                    </div>
                </div>
            @elseif($order->product_type === 'book')
                <!-- Book Dispatch Status Banner -->
                <div class="p-5 rounded-2xl bg-[#1a1128] border border-amber-500/30 text-left space-y-2 mt-4 text-xs">
                    <span class="font-bold text-amber-300 flex items-center space-x-1.5">
                        <span>📦</span>
                        <span>Courier Dispatch Notice:</span>
                    </span>
                    <p class="text-amber-100/80 leading-relaxed">
                        Your book <strong>"{{ $order->product_title }}"</strong> is being prepared for dispatch at Covilakam Vedic Publications. It will be dispatched within 24 to 48 hours via <strong>India Post Speed Post (Free Delivery)</strong>.
                    </p>
                    <p class="text-amber-400">
                        <strong>Shipping Destination:</strong> {{ $order->shipping_address }}
                    </p>
                    <p class="text-[11px] text-amber-200/60">
                        Consignment tracking details will be sent directly to WhatsApp ({{ $order->customer_phone }}).
                    </p>
                </div>
            @else
                <!-- Consultation Next Steps -->
                <div class="p-5 rounded-2xl bg-[#1a1128] border border-amber-500/30 text-left space-y-2 mt-4 text-xs">
                    <span class="font-bold text-amber-300 flex items-center space-x-1.5">
                        <span>🔮</span>
                        <span>Consultation Appointment Confirmation:</span>
                    </span>
                    <p class="text-amber-100/80 leading-relaxed">
                        Your consultation with <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong> has been recorded. Our team will contact you on WhatsApp to confirm your preferred time slot.
                    </p>
                    <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma, I have completed payment for my consultation (Order #' . $order->order_number . '). Looking forward to my session.') }}"
                       target="_blank"
                       class="inline-flex items-center space-x-1.5 text-emerald-400 font-semibold hover:underline mt-1">
                        <span>💬 Message DR. E. K. Raja Varma on WhatsApp</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Printable Invoice Summary (Razorpay & GST Compliant) -->
        <div class="bg-[#140b22] border border-amber-500/25 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
            <div class="flex items-center justify-between border-b border-amber-500/20 pb-4">
                <div>
                    <h3 class="font-cinzel text-lg font-bold text-amber-300">TAX INVOICE & RECEIPT</h3>
                    <p class="text-[11px] text-amber-200/60">Covilakam Astrology • Kerala, India</p>
                </div>
                <button onclick="window.print()"
                        class="px-3.5 py-1.5 rounded-lg border border-amber-500/30 text-xs text-amber-300 hover:bg-amber-500/10 transition-colors flex items-center space-x-1">
                    <span>🖨️</span>
                    <span>Print Invoice</span>
                </button>
            </div>

            <!-- Metadata Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div>
                    <span class="text-[10px] text-amber-400 uppercase font-semibold block">Order Number</span>
                    <span class="font-mono text-amber-100 font-medium">{{ $order->order_number }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 uppercase font-semibold block">Date</span>
                    <span class="text-amber-100">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 uppercase font-semibold block">Razorpay Payment ID</span>
                    <span class="font-mono text-amber-100 truncate block">{{ $order->razorpay_payment_id ?: 'Verified' }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 uppercase font-semibold block">Payment Status</span>
                    <span class="text-emerald-400 font-bold uppercase">{{ $order->payment_status }}</span>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="p-4 rounded-xl bg-[#1a1128] border border-amber-500/15 text-xs grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <strong class="text-amber-300 block mb-0.5">Billed To:</strong>
                    <p class="text-amber-100 font-medium">{{ $order->customer_name }}</p>
                    <p class="text-amber-200/70">{{ $order->customer_phone }}</p>
                    @if($order->customer_email)
                        <p class="text-amber-200/70">{{ $order->customer_email }}</p>
                    @endif
                </div>

                @if($order->shipping_address)
                    <div>
                        <strong class="text-amber-300 block mb-0.5">Shipping Address:</strong>
                        <p class="text-amber-200/80 leading-relaxed">{{ $order->shipping_address }}</p>
                    </div>
                @endif
            </div>

            <!-- Order Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-amber-500/20 text-amber-400 uppercase text-[10px]">
                            <th class="py-2.5">Item Description</th>
                            <th class="py-2.5">Type</th>
                            <th class="py-2.5 text-right">Qty</th>
                            <th class="py-2.5 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/10 text-amber-100/90">
                        <tr>
                            <td class="py-3 font-medium">{{ $order->product_title }}</td>
                            <td class="py-3 uppercase text-[10px] text-amber-300/80">{{ $order->product_type }}</td>
                            <td class="py-3 text-right">1</td>
                            <td class="py-3 text-right font-bold text-amber-300">{{ $order->formatted_amount }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-amber-500/20 text-xs">
                            <td colspan="3" class="pt-3 text-right text-amber-200/70">Shipping & Taxes:</td>
                            <td class="pt-3 text-right text-emerald-400 font-medium">FREE / Included</td>
                        </tr>
                        <tr class="text-sm font-bold">
                            <td colspan="3" class="pt-2 text-right text-amber-300 font-cinzel">Total Paid via Razorpay:</td>
                            <td class="pt-2 text-right text-amber-300 font-cinzel text-lg">{{ $order->formatted_amount }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Help Contact -->
            <div class="pt-4 border-t border-amber-500/15 flex flex-col sm:flex-row items-center justify-between text-[11px] text-amber-200/60 gap-3">
                <p>Questions about your order? WhatsApp us: <strong class="text-amber-300">+91 7907052160</strong></p>
                <a href="{{ route('shop.index') }}" class="text-amber-400 hover:text-amber-200 font-semibold underline">
                    ← Back to Bookstore & Services
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ is_array($order) ? $order['order_number'] : $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f3f4f6;
        }
        .receipt-mono {
            font-family: 'Courier Prime', monospace;
        }
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="py-8 px-4 flex flex-col items-center min-h-screen justify-center">

    <!-- Action Bar (Hidden on print) -->
    <div class="no-print w-full max-w-md mb-4 flex items-center justify-between">
        <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-blue-600 transition">
            ← Back to Orders
        </a>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print Receipt
            </button>
        </div>
    </div>

    <!-- Receipt Container -->
    @php
        $ordNum = is_array($order) ? $order['order_number'] : $order->order_number;
        $custName = is_array($order) ? $order['customer_name'] : $order->customer_name;
        $custPhone = is_array($order) ? ($order['customer_phone'] ?? 'N/A') : ($order->customer_phone ?? 'N/A');
        $custAddress = is_array($order) ? ($order['customer_address'] ?? 'Siem Reap, Cambodia') : ($order->customer_address ?? 'Siem Reap, Cambodia');
        $servType = is_array($order) ? $order['service_type'] : $order->service_type;
        $weight = is_array($order) ? $order['weight'] : $order->weight;
        $itemsCount = is_array($order) ? $order['items_count'] : $order->items_count;
        $orderDate = is_array($order) ? $order['order_date'] : $order->order_date;
        $pickupDate = is_array($order) ? $order['pickup_date'] : $order->pickup_date;
        $delivDate = is_array($order) ? $order['delivery_date'] : $order->delivery_date;
        $totalPrice = is_array($order) ? $order['total_price'] : $order->total_price;
        $status = is_array($order) ? $order['status'] : $order->status;
    @endphp

    <div class="receipt-container bg-white w-full max-w-md p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-200 text-gray-800">
        <!-- Store Header -->
        <div class="text-center pb-5 border-b border-dashed border-gray-300">
            <div class="w-14 h-14 mx-auto mb-2 rounded-2xl bg-blue-900 text-white flex items-center justify-center font-extrabold text-2xl tracking-wider shadow">
                L6+
            </div>
            <h1 class="text-xl font-extrabold text-gray-900 tracking-tight">LAUNDRY 6 PLUS</h1>
            <p class="text-xs text-gray-500 font-medium mt-0.5">Professional Laundry & Dry Cleaning</p>
            <p class="text-xs text-gray-400 mt-1">Svay Dangkum, Siem Reap, Cambodia</p>
            <p class="text-xs text-gray-400">Tel: +855 12 345 678 | info@laundry6plus.com</p>
        </div>

        <!-- Receipt Meta -->
        <div class="py-4 border-b border-dashed border-gray-300 text-xs space-y-1.5 receipt-mono">
            <div class="flex justify-between">
                <span class="text-gray-500">Receipt No:</span>
                <span class="font-bold text-gray-900">{{ $ordNum }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Order Date:</span>
                <span class="font-semibold text-gray-800">{{ date('Y-m-d H:i', strtotime($orderDate)) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Pickup Date:</span>
                <span class="font-semibold text-gray-800">{{ $pickupDate ? date('Y-m-d', strtotime($pickupDate)) : 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Delivery Date:</span>
                <span class="font-semibold text-gray-800">{{ $delivDate ? date('Y-m-d', strtotime($delivDate)) : 'N/A' }}</span>
            </div>
            <div class="flex justify-between items-center pt-1">
                <span class="text-gray-500">Current Status:</span>
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-blue-100 text-blue-800">
                    {{ $status }}
                </span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="py-3 border-b border-dashed border-gray-300 text-xs">
            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Customer Details</p>
            <p class="font-bold text-gray-900 text-sm">{{ $custName }}</p>
            <p class="text-gray-600 mt-0.5">Phone: {{ $custPhone }}</p>
            <p class="text-gray-500">{{ $custAddress }}</p>
        </div>

        <!-- Order Summary Specs -->
        <div class="py-3 border-b border-dashed border-gray-300 grid grid-cols-3 gap-2 text-center text-xs">
            <div class="bg-gray-50 p-2 rounded-xl">
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Service</p>
                <p class="font-bold text-gray-800 truncate mt-0.5">{{ $servType }}</p>
            </div>
            <div class="bg-gray-50 p-2 rounded-xl">
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Weight</p>
                <p class="font-bold text-gray-800 mt-0.5">{{ number_format($weight, 1) }} kg</p>
            </div>
            <div class="bg-gray-50 p-2 rounded-xl">
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Items</p>
                <p class="font-bold text-gray-800 mt-0.5">{{ $itemsCount }} pcs</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="py-4 border-b border-dashed border-gray-300">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-gray-400 uppercase text-[10px] font-bold border-b border-gray-100">
                        <th class="text-left pb-2">Item</th>
                        <th class="text-center pb-2">Qty</th>
                        <th class="text-right pb-2">Price</th>
                        <th class="text-right pb-2">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($items as $item)
                        @php
                            $sName = is_array($item) ? $item['service_name'] : $item->service_name;
                            $qty = is_array($item) ? $item['quantity'] : $item->quantity;
                            $uPrice = is_array($item) ? $item['unit_price'] : $item->unit_price;
                            $sTotal = is_array($item) ? $item['subtotal'] : $item->subtotal;
                        @endphp
                        <tr>
                            <td class="py-2 font-medium text-gray-800">{{ $sName }}</td>
                            <td class="py-2 text-center text-gray-600">{{ $qty }}</td>
                            <td class="py-2 text-right text-gray-600">${{ number_format($uPrice, 2) }}</td>
                            <td class="py-2 text-right font-semibold text-gray-900">${{ number_format($sTotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-2 font-medium text-gray-800">{{ $servType }} ({{ $weight }} kg)</td>
                            <td class="py-2 text-center text-gray-600">1</td>
                            <td class="py-2 text-right text-gray-600">${{ number_format($totalPrice, 2) }}</td>
                            <td class="py-2 text-right font-semibold text-gray-900">${{ number_format($totalPrice, 2) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Totals Calculation -->
        <div class="py-4 border-b border-dashed border-gray-300 space-y-1.5 text-xs">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal:</span>
                <span class="font-semibold">${{ number_format($totalPrice, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Tax (0%):</span>
                <span>$0.00</span>
            </div>
            <div class="flex justify-between text-base font-extrabold text-blue-900 pt-2 border-t border-gray-200">
                <span>Total Amount:</span>
                <span>${{ number_format($totalPrice, 2) }}</span>
            </div>
        </div>

        <!-- Barcode & Policy Note -->
        <div class="pt-5 text-center">
            <!-- Simulated Barcode -->
            <div class="inline-block bg-white px-4 py-2 border border-gray-200 rounded-lg">
                <div class="flex items-center justify-center space-x-1 h-10">
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-2 h-full bg-black"></div>
                    <div class="w-0.5 h-full bg-black"></div>
                    <div class="w-1.5 h-full bg-black"></div>
                    <div class="w-3 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-0.5 h-full bg-black"></div>
                    <div class="w-2 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-2.5 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-0.5 h-full bg-black"></div>
                    <div class="w-2 h-full bg-black"></div>
                    <div class="w-1.5 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                </div>
                <p class="text-[11px] font-mono tracking-widest text-gray-600 mt-1 font-bold">{{ $ordNum }}</p>
            </div>

            <p class="text-[11px] text-gray-500 font-medium mt-4">Thank you for choosing Laundry 6 Plus!</p>
            <p class="text-[9px] text-gray-400 mt-1 leading-relaxed">
                Please present this receipt upon pickup. Check items before leaving.<br>
                For questions or urgent deliveries, call +855 12 345 678.
            </p>
        </div>
    </div>

</body>
</html>

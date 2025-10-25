<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Orders</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg mb-2">No orders yet.</p>
                <p class="text-gray-400 text-sm mb-4">Start shopping to create your first order!</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition-colors">
                    Browse Products
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Table Header -->
                <div class="bg-amber-200 grid grid-cols-12 gap-4 p-4 font-semibold text-gray-700">
                    <div class="col-span-2 text-center">Order ID</div>
                    <div class="col-span-3 text-center">Date</div>
                    <div class="col-span-2 text-center">Items</div>
                    <div class="col-span-3 text-center">Total</div>
                    <div class="col-span-2 text-center">Action</div>
                </div>

                <!-- Orders List -->
                <div>
                    @foreach($orders as $order)
                        <div class="grid grid-cols-12 gap-4 p-4 border-b items-center hover:bg-gray-50 transition-colors rounded-md">
                            <div class="col-span-2 text-center font-medium text-gray-800">#{{ $order->id }}</div>

                            <div class="col-span-3 text-center text-gray-700">
                                <div>{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-gray-400 text-xs">{{ $order->created_at->format('H:i') }}</div>
                            </div>

                            <div class="col-span-2 text-center">
                                <span class="inline-flex items-center justify-center bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $order->items->sum('quantity') }} items
                                </span>
                            </div>

                            <div class="col-span-3 text-center text-red-600 font-bold text-lg">{{ number_format($order->total, 0) }} THB</div>

                            <div class="col-span-2 text-center">
                                <a href="{{ route('orders.show', $order->id) }}" 
                                   class="inline-flex items-center justify-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors text-sm font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $summary = [
                        ['label'=>'Total Orders', 'value'=>$orders->count(), 'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color'=>'amber'],
                        ['label'=>'Total Spent', 'value'=>number_format($orders->sum('total'),0).' ฿', 'icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'green'],
                        ['label'=>'Total Items', 'value'=>$orders->sum(fn($o) => $o->items->sum('quantity')),'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4','color'=>'blue']
                    ];
                @endphp

                @foreach($summary as $card)
                    <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">{{ $card['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</p>
                        </div>
                        <div class="bg-{{ $card['color'] }}-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"></path>
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

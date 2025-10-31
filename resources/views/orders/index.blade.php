<x-app-layout>
    
    <div class="min-h-screen bg-white" style="background-color: #FAF6F0;">
        <!-- Main content -->
        <div class="container mx-auto px-4 py-6 pt-16">
            @if($orders->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg mb-2">No orders yet.</p>
                    <p class="text-gray-400 text-sm mb-4">Start shopping to create your first order!</p>
                    <a href="{{ route('products.index') }}" 
                        class="inline-block text-white px-6 py-2 rounded-lg transition-colors hover:bg-[#7A4F33]" 
                        style="background-color: #8B5E3C;">
                        Browse Products
                    </a>
                </div>
            @else 
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-amber-200 grid grid-cols-12 gap-4 p-4 font-semibold text-gray-700"  style="background-color: #C8A98C;">
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
                                    <span class="inline-flex items-center justify-center text-gray-800 px-3 py-1 rounded-full text-sm font-semibold" style="background-color: #F3B97A;">
                                        {{ $order->items->sum('quantity') }} items
                                    </span>
                                </div>

                                <div class="col-span-3 text-center text-red-600 font-bold text-lg">{{ number_format($order->total, 0) }} THB</div>

                                <div class="col-span-2 text-center">
    <a href="{{ route('orders.show', $order->id) }}" 
       class="inline-flex items-center justify-center text-black px-4 py-2 rounded-lg hover:opacity-90 transition-colors text-sm font-semibold"
       style="background-color: #F3B97A;">
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
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

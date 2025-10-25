<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6 space-y-6">

        <!-- Shipping Info -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-4 border-b pb-2">Shipping Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $order->name }}</p>
                    <p class="text-gray-600"><strong>Email:</strong> {{ $order->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Address:</strong> {{ $order->address }}</p>
                    <p class="text-gray-600"><strong>Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="text-gray-600"><strong>Total:</strong> 
                        <span class="text-red-600 font-bold text-lg">฿{{ number_format($order->total, 2) }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-4 border-b pb-2">Order Items</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200 rounded-lg">
                    <thead class="bg-amber-100">
                        <tr>
                            <th class="py-3 px-4">Product</th>
                            <th class="py-3 px-4 text-center">Quantity</th>
                            <th class="py-3 px-4 text-right">Price</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-t hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4">{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full font-semibold">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">฿{{ number_format($item->price, 2) }}</td>
                            <td class="py-3 px-4 text-right font-bold text-red-600">
                                ฿{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back Button -->
        <div>
            <a href="{{ route('orders.index') }}" 
               class="inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
               ← Back to Orders
            </a>
        </div>

    </div>
</x-app-layout>

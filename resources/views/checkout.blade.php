<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Checkout</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8">
        <form action="{{ route('order.place') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf

            <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>

            <div class="mb-3">
                <label class="block mb-1">Full Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-3">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-3">
                <label class="block mb-1">Address</label>
                <textarea name="address" class="w-full border rounded p-2" required></textarea>
            </div>

            <h3 class="text-lg font-semibold mb-4 mt-6">Order Summary</h3>

            <ul>
                @foreach($cart as $id => $item)
                    <li class="flex justify-between mb-1">
                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                        <span>฿{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </li>
                @endforeach
            </ul>

            <p class="mt-4 text-right font-bold">
                Total: ฿{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }}
            </p>

            <button type="submit" class="mt-6 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Place Order
            </button>
        </form>
    </div>
</x-app-layout>

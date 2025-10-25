<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Order Success</h2>
    </x-slot>

    <div class="max-w-xl mx-auto text-center py-12">
        <h3 class="text-2xl font-semibold text-green-600 mb-4">🎉 Order Placed Successfully!</h3>
        <p class="text-gray-600 mb-6">Thank you for your purchase. We'll process your order soon.</p>
        <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
            Back to Shop
        </a>
    </div>
</x-app-layout>

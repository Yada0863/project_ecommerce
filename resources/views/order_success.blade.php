<x-app-layout>
    <div class="min-h-screen" style="background-color: #FAF6F0;">
    <div class="max-w-xl mx-auto text-center py-12">
        <h3 class="text-2xl font-semibold text-green-600 mb-4">🎉 Order Placed Successfully!</h3>
        <p class="text-gray-600 mb-6">Thank you for your purchase. We'll process your order soon.</p>
        <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
            Back to Shop
        </a>
    </div>
    </div>
</x-app-layout>

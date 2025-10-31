<x-app-layout>
    <div class="min-h-screen bg-white" style="background-color: #FAF6F0;">

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-6">
                <!-- Product Image -->
                <div class="flex items-center justify-center">
                    <img src="{{ $product->image }}" 
                         alt="{{ $product->name }}" 
                         class="w-full max-w-md h-auto object-cover rounded-lg shadow-md">
                </div>
                
                <!-- Product Details -->
                <div class="flex flex-col justify-center">
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h3>
                    
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">{{ $product->description }}</p>
                    
                    <div class="mb-6">
                        <span class="text-gray-500 text-sm">Price</span>
                        <p class="text-3xl font-bold text-red-600">฿{{ number_format($product->price, 2) }}</p>
                    </div>
                    
                    <form id="add-to-cart-form" class="space-y-4">
                        @csrf
                        
                        <!-- Quantity Selector -->
                        <div class="flex items-center gap-4">
                            <label class="text-gray-700 font-semibold">Quantity:</label>
                            <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-4 py-2">
                                <button type="button" 
                                        id="decrease-qty" 
                                        class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded hover:bg-gray-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       class="w-16 text-center border-0 bg-transparent text-lg font-semibold focus:ring-0">
                                <button type="button" 
                                        id="increase-qty" 
                                        class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded hover:bg-gray-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        @auth
                            <button type="submit" 
                                    class="w-full bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold text-lg flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Add to Cart
                            </button>
                        @else
                            <button type="button"
                                    onclick="alert('⚠️ Please login to add to cart!')"
                                    class="w-full bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed font-semibold text-lg flex items-center justify-center gap-2" 
                                    disabled>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Add to Cart
                            </button>
                        @endauth
                    </form>
                    
                    <!-- Back Button -->
                    <a href="{{ route('products.index') }}" 
                       class="mt-4 inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        
        // Quantity controls
        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
        });
        
        // Add to cart form
        document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quantity = quantityInput.value;
            
            fetch("{{ route('cart.add', $product->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Added to cart!');
                    
                    // Update cart badge
                    const badge = document.getElementById('cart-count');
                    if (badge && data.cart_count) {
                        badge.textContent = data.cart_count;
                    }
                    
                    // Reset quantity to 1
                    quantityInput.value = 1;
                } else {
                    alert('⚠️ Something went wrong.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('⚠️ Failed to add to cart.');
            });
        });
    });
    </script>
    </div>
</x-app-layout>
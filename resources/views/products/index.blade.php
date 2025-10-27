<x-app-layout>

    <div class="min-h-screen" style="background-color: #FAF6F0;">
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $product)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow">
                    <!-- Product Image -->
                    <div class="relative aspect-square bg-gray-50">
                        <img src="{{ $product->image }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-3">
                        <h3 class="text-center text-base font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                        
                        <!-- Price & Quantity Controls -->
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1">
                                <span class="text-gray-600 text-xs">Total :</span>
                                <span class="text-red-600 font-semibold text-sm">{{ number_format($product->price, 0) }} THB</span>
                            </div>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-1 rounded px-1.5" style="background-color: #C8A98C; py-0.5;">
                                <button type="button" 
                                        class="quantity-minus w-5 h-5 flex items-center justify-center rounded hover:bg-[#B7987A] transition-colors" 
                                        data-product-id="{{ $product->id }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="quantity-display w-5 text-center font-semibold text-xs" 
                                      data-product-id="{{ $product->id }}">1</span>
                                <button type="button" 
                                        class="quantity-plus w-5 h-5 flex items-center justify-center rounded hover:bg-[#B7987A] transition-colors" 
                                        data-product-id="{{ $product->id }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- View Details Button -->
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="block w-full bg-gray-500 text-white text-center py-1.5 rounded-lg hover:bg-gray-600 transition-colors mb-2 text-sm">
                            View Details
                        </a>
                        
                        <!-- Add to Cart Button -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="quantity" class="quantity-input" value="1" data-product-id="{{ $product->id }}">
                            
                            @auth
                                <button type="submit" 
                                            style="background-color: #C8A98C; border: 3px solid #8B5E3C; color: #4A403A;"
                                            class="w-full py-1.5 rounded-lg hover:bg-[#B7987A] transition-colors flex items-center justify-center gap-2 text-sm">
                                        Add To Cart
                                    </button>
                            @else
                                <button type="button" 
                                        onclick="alert('⚠️ Please login to add to cart!')" 
                                        class="w-full bg-gray-400 text-white py-1.5 rounded-lg cursor-not-allowed flex items-center justify-center gap-2 text-sm" 
                                        disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add To Cart
                                </button>
                            @endauth
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Quantity Controls
        const updateQuantity = (productId, change) => {
            const display = document.querySelector(`.quantity-display[data-product-id="${productId}"]`);
            const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
            let current = parseInt(display.textContent);
            let newValue = Math.max(1, current + change);
            display.textContent = newValue;
            input.value = newValue;
        };

        document.querySelectorAll('.quantity-plus').forEach(btn => {
            btn.addEventListener('click', () => {
                updateQuantity(btn.dataset.productId, 1);
            });
        });

        document.querySelectorAll('.quantity-minus').forEach(btn => {
            btn.addEventListener('click', () => {
                updateQuantity(btn.dataset.productId, -1);
            });
        });

        // Add to Cart
        const forms = document.querySelectorAll(".add-to-cart-form");
        
        forms.forEach(form => {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                try {
                    const response = await fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": form.querySelector("[name=_token]").value,
                            "Accept": "application/json"
                        },
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        alert("✅ Added to cart!");
                        
                        // Update cart count
                        const badge = document.getElementById("cart-count");
                        if (badge) {
                            const quantity = parseInt(form.querySelector('.quantity-input').value);
                            let count = parseInt(badge.textContent || "0");
                            badge.textContent = count + quantity;
                        }
                        
                        // Reset quantity to 1
                        const productId = form.querySelector('.quantity-input').dataset.productId;
                        const display = document.querySelector(`.quantity-display[data-product-id="${productId}"]`);
                        const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                        display.textContent = "1";
                        input.value = "1";
                    } else {
                        alert("⚠️ Something went wrong.");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    alert("⚠️ Failed to add to cart.");
                }
            });
        });
    });
    </script>
</x-app-layout>
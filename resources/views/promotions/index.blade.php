<x-app-layout>
    <div class="min-h-screen" style="background-color: #FAF6F0;">
        <div class="container mx-auto px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ml-6">
                @foreach($promotions as $promotion)
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow w-full max-w-md">
                        <!-- Promotion Image -->
                        <div class="relative aspect-square bg-gray-50">
                            <img src="{{ $promotion->image }}" 
                                 alt="{{ $promotion->name }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Promotion Info --> 
                        <div class="p-3">
                            <h3 class="text-center text-base font-semibold text-gray-800 mb-2">{{ $promotion->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $promotion->description }}</p>
                            
                            <!-- Price & Quantity Controls -->
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1">
                                        <span class="text-gray-600 text-xs">Price :</span>
                                        <span class="text-red-600 font-semibold text-sm">{{ number_format($promotion->promo_price, 0) }} THB / set</span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        ({{ $promotion->buy_quantity }} pcs per set)
                                    </div>
                                </div>

                                <div class="flex items-center gap-1 rounded px-1.5" style="background-color: #C8A98C; py-0.5;">
                                    <button type="button" 
                                        class="quantity-minus w-5 h-5 flex items-center justify-center rounded hover:bg-[#B7987A] transition-colors" 
                                        data-promotion-id="{{ $promotion->id }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="quantity-display w-5 text-center font-semibold text-xs"
                                          data-promotion-id="{{ $promotion->id }}" data-buy-qty="{{ $promotion->buy_quantity }}">1</span>
                                    <button type="button" 
                                            class="quantity-plus w-5 h-5 flex items-center justify-center rounded hover:bg-[#B7987A] transition-colors"
                                            data-promotion-id="{{ $promotion->id }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- View Details Button -->
                            <a href="{{ route('promotions.show', $promotion->id) }}" 
                               class="block w-full bg-gray-500 text-white text-center py-1.5 rounded-lg hover:bg-gray-600 transition-colors mb-2 text-sm">
                                View Details
                            </a>

                            <!-- Add to Cart Button -->
                            <form action="{{ route('cart.addPromotion', $promotion->id) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" class="quantity-input" value="1" data-promotion-id="{{ $promotion->id }}" data-buy-qty="{{ $promotion->buy_quantity }}">

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
        const updateQuantity = (promotionId, change) => {
            const display = document.querySelector(`.quantity-display[data-promotion-id="${promotionId}"]`);
            const input = document.querySelector(`.quantity-input[data-promotion-id="${promotionId}"]`);
            let current = parseInt(display.textContent);
            let newValue = Math.max(1, current + change);
            display.textContent = newValue;
            input.value = newValue;
        };

        document.querySelectorAll('.quantity-plus').forEach(btn => {
            btn.addEventListener('click', () => updateQuantity(btn.dataset.promotionId, 1));
        });

        document.querySelectorAll('.quantity-minus').forEach(btn => {
            btn.addEventListener('click', () => updateQuantity(btn.dataset.promotionId, -1));
        });

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
                        const promotionId = form.querySelector('.quantity-input').dataset.promotionId;
                        const buyQty = parseInt(form.querySelector('.quantity-input').dataset.buyQty);
                        const display = document.querySelector(`.quantity-display[data-promotion-id="${promotionId}"]`);
                        const sets = parseInt(display.textContent);
                        alert(`✅ Added ${sets * buyQty} pcs (${sets} sets) to cart!`);

                        // รีเซ็ตจำนวนกลับเป็น 1
                        display.textContent = "1";
                        form.querySelector('.quantity-input').value = "1";
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

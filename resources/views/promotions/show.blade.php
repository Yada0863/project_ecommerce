<x-app-layout>
    

    <div class="min-h-screen" style="background-color: #FAF6F0;">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="grid md:grid-cols-2 gap-8 p-6">
                    <div class="flex items-center justify-center">
                        <img src="{{ $promotion->image }}" 
                             alt="{{ $promotion->name }}" 
                             class="w-full max-w-md h-auto object-cover rounded-lg shadow-md">
                    </div>

                    <div class="flex flex-col justify-center">
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">{{ $promotion->name }}</h3>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">{{ $promotion->description }}</p>

                        <div class="mb-6">
                            <span class="text-gray-500 text-sm">Price</span>
                            <p class="text-3xl font-bold text-red-600">฿{{ number_format($promotion->promo_price, 2) }}</p>
                        </div>

                        <form id="add-to-cart-form" class="space-y-4">
                            @csrf
                            <div class="flex items-center gap-4">
                                <label class="text-gray-700 font-semibold">Quantity:</label>
                                <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-4 py-2">
                                    <button type="button" id="decrease-qty" class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded hover:bg-gray-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                           class="w-16 text-center border-0 bg-transparent text-lg font-semibold focus:ring-0" 
                                           data-buy-qty="{{ $promotion->buy_quantity }}">
                                    <button type="button" id="increase-qty" class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded hover:bg-gray-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @auth
                                <button type="submit" class="w-full bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold text-lg flex items-center justify-center gap-2">
                                    Add to Cart
                                </button>
                            @else
                                <button type="button" onclick="alert('⚠️ Please login to add to cart!')" class="w-full bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed font-semibold text-lg flex items-center justify-center gap-2" disabled>
                                    Add to Cart
                                </button>
                            @endauth
                        </form>

                        <a href="{{ route('promotions.index') }}" class="mt-4 inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Promotion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const buyQty = parseInt(quantityInput.dataset.buyQty);

    decreaseBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if(value > 1) quantityInput.value = value - 1;
    });

    increaseBtn.addEventListener('click', function() {
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });

    document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const sets = parseInt(quantityInput.value); // จำนวนชุด
        const totalItems = sets * buyQty; // จำนวนชิ้นจริง

        fetch("{{ route('cart.addPromotion', $promotion->id) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({ quantity: sets })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert(`✅ Added ${totalItems} pcs (${sets} sets) to cart!`);
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
</x-app-layout>

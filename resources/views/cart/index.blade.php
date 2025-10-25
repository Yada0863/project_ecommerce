<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Shopping Cart</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div id="cart-wrapper">
            <!-- ตรวจสอบว่าตะกร้าว่างหรือไม่ -->
            @if(empty($cart) || count($cart) === 0)
                <div class="bg-white rounded-lg shadow p-8 text-center" id="empty-cart">
                    <p class="text-gray-500 text-lg">Your cart is empty.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700">
                        Continue Shopping
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow overflow-hidden" id="cart-content">
                    <!-- Table Header -->
                    <div class="bg-amber-200 grid grid-cols-12 gap-4 p-4 font-semibold text-gray-700">
                        <div class="col-span-5">Product</div>
                        <div class="col-span-2 text-center">Unit Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-center">Total Price</div>
                        <div class="col-span-1 text-center">Actions</div>
                    </div>

                    <!-- Cart Items -->
                    <div id="cart-items">
                        @foreach($cart as $id => $item)
                            @php $total = $item['price'] * $item['quantity']; @endphp
                            <div class="grid grid-cols-12 gap-4 p-4 border-b items-center cart-item" data-id="{{ $id }}" data-price="{{ $item['price'] }}">
                                <div class="col-span-5 flex items-center gap-4">
                                    @if($item['image'] ?? false)
                                        <img src="{{ $item['image'] }}" class="w-20 h-20 rounded object-cover" alt="{{ $item['name'] }}">
                                    @endif
                                    <span class="font-medium">{{ $item['name'] }}</span>
                                </div>
                                <div class="col-span-2 text-center">
                                    <span class="text-gray-700">{{ number_format($item['price'],0) }} THB</span>
                                </div>
                                <div class="col-span-2 flex justify-center">
                                    <div class="flex items-center gap-2 bg-amber-100 rounded px-2 py-1">
                                        <button type="button" class="qty-decrease w-7 h-7 flex items-center justify-center bg-amber-200 rounded hover:bg-amber-300 transition-colors">-</button>
                                        <input type="text" class="qty-display w-12 text-center font-semibold border-none bg-transparent" value="{{ $item['quantity'] }}">
                                        <button type="button" class="qty-increase w-7 h-7 flex items-center justify-center bg-amber-200 rounded hover:bg-amber-300 transition-colors">+</button>
                                    </div>
                                </div>
                                <div class="col-span-2 text-center">
                                    <span class="item-total text-red-600 font-semibold">{{ number_format($total,0) }} THB</span>
                                </div>
                                <div class="col-span-1 text-center">
                                    <button class="remove-item bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 transition-colors text-sm">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Summary -->
                    <div class="bg-amber-100 p-6">
                        <div class="flex justify-end items-center gap-8">
                            <div class="text-right">
                                <p class="text-gray-600 mb-1">Total (<span id="total-items">{{ array_sum(array_column($cart,'quantity')) }}</span> items) :</p>
                                <p class="text-3xl font-bold text-gray-800">
                                    <span id="cart-total">{{ number_format(array_sum(array_map(fn($i)=>$i['price']*$i['quantity'],$cart)),0) }}</span> THB
                                </p>
                            </div>
                            <a href="{{ route('checkout') }}" class="bg-amber-700 text-white px-8 py-3 rounded-lg hover:bg-amber-800 transition-colors font-semibold text-lg">
                                Check Out
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript สำหรับอัปเดต cart แบบ dynamic -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartItems = document.getElementById('cart-items');
        let debounceTimers = {};

        // ฟังก์ชันคำนวณยอดรวมทั้งหมดและจำนวนสินค้า
        function updateCartTotals(){
            let total = 0, itemCount = 0;
            document.querySelectorAll('.cart-item').forEach(item=>{
                const price = parseFloat(item.dataset.price);
                const qty = parseInt(item.querySelector('.qty-display').value);
                item.querySelector('.item-total').textContent = (price*qty).toLocaleString() + ' THB';
                total += price*qty;
                itemCount += qty;
            });
            document.getElementById('cart-total').textContent = total.toLocaleString();
            document.getElementById('total-items').textContent = itemCount;
            const badge = document.getElementById('cart-count');
            if(badge) badge.textContent = document.querySelectorAll('.cart-item').length;
        }

        // ฟังก์ชันส่งข้อมูลไปอัปเดต server (debounce 500ms)
        function updateQuantity(id, qty){
            if(debounceTimers[id]) clearTimeout(debounceTimers[id]);
            debounceTimers[id] = setTimeout(()=>{
                fetch('{{ route("cart.update") }}',{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
                    body: JSON.stringify({quantities:{[id]:qty}})
                }).then(res=>res.json())
                  .then(data=>{ if(!data.success) alert('Failed to update quantity'); })
                  .catch(err=>alert(err));
            }, 500);
        }

        cartItems.addEventListener('click', function(e){
            const decrease = e.target.closest('.qty-decrease');
            const increase = e.target.closest('.qty-increase');
            const remove = e.target.closest('.remove-item');

            if(decrease||increase){
                const item = (decrease||increase).closest('.cart-item');
                const input = item.querySelector('.qty-display');
                let value = parseInt(input.value);
                if(decrease && value>1) value--;
                if(increase) value++;
                input.value = value;
                updateCartTotals();
                updateQuantity(item.dataset.id, value);
            }

            if(remove){
                const item = remove.closest('.cart-item');
                const id = item.dataset.id;
                if(confirm('Are you sure to remove this item?')){
                    fetch('/cart/remove/'+id,{
                        method:'POST',
                        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}
                    }).then(res=>res.json())
                    .then(data=>{
                        if(data.success){
                            item.remove();
                            updateCartTotals();
                            if(document.querySelectorAll('.cart-item').length===0){
                                document.getElementById('cart-wrapper').innerHTML = `
                                    <div class="bg-white rounded-lg shadow p-8 text-center">
                                        <p class="text-gray-500 text-lg">Your cart is empty.</p>
                                        <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700">
                                            Continue Shopping
                                        </a>
                                    </div>`;
                            }
                        } else alert('Failed to remove item');
                    }).catch(err=>alert(err));
                }
            }
        });

        // Optional: listen to input manually for direct typing
        cartItems.querySelectorAll('.qty-display').forEach(input=>{
            input.addEventListener('input', function(){
                let item = input.closest('.cart-item');
                let val = parseInt(input.value);
                if(isNaN(val)||val<1) val=1;
                input.value = val;
                updateCartTotals();
                updateQuantity(item.dataset.id, val);
            });
        });
    });
    </script>
</x-app-layout>

<x-app-layout>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden; /* ปิด scroll ทั้งหมด */
        }

        main {
            height: 100%;
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>

    <div class="flex flex-col min-h-screen" 
         style="background-color: #FAF6F0; color: #3B2F2F; font-family: 'Poppins', sans-serif; overflow: hidden;">
        <!-- Hero Section -->
        <div class="flex flex-col lg:flex-row flex-1 overflow-hidden h-screen">
            <!-- ซ้าย: ภาพขนม -->
            <div class="w-full lg:w-2/3">
                <img src="{{ asset('images/bakery-bg.jpg') }}" 
                     alt="Bakery pastries"
                     class="object-cover w-full h-full">
            </div>

            <!-- ขวา: ส่วนข้อความ -->
            <div class="w-full lg:w-1/3 flex flex-col justify-center items-center text-center p-10" 
                 style="background-color: #F8EFE4;">
                <h1 class="text-3xl lg:text-4xl font-semibold tracking-wide mb-6">
                    DATABASE<br>BAKERY
                </h1>

                <img src="{{ asset('images/chocolate-cake.png') }}" 
                     alt="Chocolate Cake" 
                     class="w-40 mb-8">

                <a href="{{ route('products.index') }}"
                   style="background-color: #C69C72; border: 2px solid #A87A52; color: #3B2F2F;"
                   class="py-3 px-8 rounded-md font-medium hover:opacity-90 transition shadow-sm">
                   VIEW PRODUCTS
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

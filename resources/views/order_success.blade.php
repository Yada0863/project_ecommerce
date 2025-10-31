<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center" style="background-color: #FAF6F0;">
        <div class="max-w-3xl w-full sm:px-6 lg:px-8">
            <div class="p-8 text-center">
                <h2 class="text-2xl font-semibold mb-6" style="color: #4A403A;">
                        🍰 Thank you for your order!
                </h2>

                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-40 h-40 mx-auto mb-6 object-contain">
                
                <p class="text-gray-500 dark:text-gray-400 mt-4">
                    We hope our treats make your day a little sweeter! 💖✨
                </p>

                <a href="{{ url('/') }}"
                   class="inline-block mt-8 text-white px-6 py-2 rounded-md font-medium transition hover:opacity-90"
                   style="background-color: #704214;">
                    Back to Home Page  
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
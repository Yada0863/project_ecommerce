<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Database Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col" style="background-color: #FAF6F0;">

    <!-- Header -->
    <header class="flex items-center px-8 py-3 bg-white shadow-sm">
        <img src="{{ asset('images/logo.png') }}" alt="Database Bakery Logo" class="w-10 h-10 mr-3">
        <h1 class="text-lg font-semibold text-gray-700">Register</h1>
    </header>

    <!-- Main content -->
    <main class="flex flex-1 items-center justify-center px-8 py-12">
        <div class="flex flex-col md:flex-row items-center md:space-x-16">

            <!-- Left side: Logo -->
            <div class="flex flex-col items-center text-center mb-10 md:mb-0">
                <img src="{{ asset('images/logo.png') }}" alt="Database Bakery Logo" class="w-64 mb-6">
                <h2 class="text-3xl font-serif text-[#4A403A] font-bold tracking-wide">
                    DATABASE<br>BAKERY
                </h2>
            </div>

            <!-- Right side: Sign Up form -->
            <div class="bg-white rounded-lg shadow-md p-8 w-80">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Register</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Username -->
                    <input type="text" name="name" placeholder="Username"
                        value="{{ old('name') }}"
                        class="w-full px-3 py-2 mb-2 rounded-md text-gray-800 placeholder-gray-600 focus:outline-none"
                        style="background-color: #C7A78A; opacity: 0.7;" required>
                    @error('name')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror

                    <!-- Phone Number -->
                    <input type="text" name="phone" placeholder="Phone Number"
                        value="{{ old('phone') }}"
                        class="w-full px-3 py-2 mb-2 rounded-md text-gray-800 placeholder-gray-600 focus:outline-none"
                        style="background-color: #C7A78A; opacity: 0.7;">
                    @error('phone')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror

                    <!-- Date of Birth -->
                    <input type="date" name="date_of_birth"
                        value="{{ old('date_of_birth') }}"
                        class="w-full px-3 py-2 mb-2 rounded-md text-gray-800 placeholder-gray-600 focus:outline-none"
                        style="background-color: #C7A78A; opacity: 0.7;">
                    @error('date_of_birth')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror

                    <!-- Email -->
                    <input type="email" name="email" placeholder="Email"
                        value="{{ old('email') }}"
                        class="w-full px-3 py-2 mb-2 rounded-md text-gray-800 placeholder-gray-600 focus:outline-none"
                        style="background-color: #C7A78A; opacity: 0.7;" required>
                    @error('email')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror

                    <!-- Password -->
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-3 py-2 mb-2 rounded-md text-gray-800 placeholder-gray-600 focus:outline-none"
                        style="background-color: #C7A78A; opacity: 0.7;" required>
                    @error('password')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror

                    <!-- Confirm Password -->
                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                        class="w-full px-3 py-2 mb-4 rounded-md text-gray-800 placeholder-gray-600 focus:outline-none"
                        style="background-color: #C7A78A; opacity: 0.7;" required>
                    @error('password_confirmation')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-2 rounded-md text-white font-semibold hover:opacity-90 transition"
                        style="background-color: #704214;">
                        Register
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Have an account?
                    <a href="{{ route('login') }}" class="text-[#D36B4C] font-semibold hover:underline">
                        Log in
                    </a>
                </p>
            </div>
        </div>
    </main>
</body>
</html>

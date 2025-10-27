<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Database Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col" style="background-color: #FAF6F0;">

    <!-- Header -->
    <header class="flex items-center px-8 py-3 bg-white shadow-sm">
        <img src="{{ asset('images/logo.png') }}" alt="Database Bakery Logo" class="w-10 h-10 mr-3">
        <h1 class="text-lg font-semibold text-gray-700">Log In</h1>
    </header>

    <!-- Main content -->
    <main class="flex flex-1 items-center justify-center px-8 py-12">
        <div class="flex flex-col md:flex-row items-center md:space-x-16">

            <!-- Left side: Logo -->
            <div class="flex flex-col items-center text-center mb-10 md:mb-0">
                <img src="{{ asset('images/logo.png') }}" alt="Database Bakery Logo" class="w-64 mb-6">
                <h2 class="text-3xl font-serif text-[#4A403A] font-bold tracking-wide">DATABASE<br>BAKERY</h2>
            </div>

            <!-- Right side: Login form -->
            <div class="bg-white rounded-lg shadow-md p-8 w-80">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Log In</h3>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email"
                        class="w-full px-3 py-2 mb-4 rounded-md text-gray-800 placeholder-gray-600"
                        style="background-color: #C7A78A; opacity: 0.7;" required>

                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-3 py-2 mb-6 rounded-md text-gray-800 placeholder-gray-600"
                        style="background-color: #C7A78A; opacity: 0.7;" required>

                    <button type="submit"
                        class="w-full py-2 rounded-md text-white font-semibold"
                        style="background-color: #704214;">
                        Log in
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-4">
                    New User?
                    <a href="{{ route('register') }}" class="text-[#D36B4C] font-semibold hover:underline">
                        Sign Up
                    </a>
                </p>
            </div>

        </div>
    </main>

</body>
</html>

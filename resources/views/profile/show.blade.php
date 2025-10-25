<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Profile</h2>
        <p class="text-sm text-gray-500">Manage and protect your profile</p>
    </x-slot>

    <div class="py-12 bg-[#F9F5F1] min-h-screen">
        <div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8 flex justify-between gap-10">
            <div class="flex-1 space-y-4 text-gray-700">
                <div class="flex justify-between">
                    <span class="font-semibold text-[#9A7B6F]">Username</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-[#9A7B6F]">Email</span>
                    <a href="mailto:{{ $user->email }}" class="text-[#6B4E3E] underline">
                        {{ $user->email }}
                    </a>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-[#9A7B6F]">Phone Number</span>
                    <span>{{ $user->phone ?? 'xxxxxxxxx' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-[#9A7B6F]">Date of Birth</span>
                    <span>{{ $user->dob ?? 'xx/xx/xxxx' }}</span>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('profile.edit') }}" class="px-6 py-2 bg-[#8B5E3C] text-white rounded-md hover:bg-[#734A2F]">Edit</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-[#E66E6E] text-white rounded-md hover:bg-[#C85B5B]">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <img src="{{ $user->profile_image ?? 'https://placekitten.com/200/200' }}"
                     class="w-40 h-40 rounded-full object-cover border border-gray-300" alt="Profile">
            </div>
        </div>
    </div>
</x-app-layout>

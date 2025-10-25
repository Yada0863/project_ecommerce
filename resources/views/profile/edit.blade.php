<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Profile</h2>
    </x-slot>

    <div class="py-12 bg-[#F9F5F1] min-h-screen">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-8">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-[#9A7B6F]">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border-gray-300 rounded-md mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#9A7B6F]">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full border-gray-300 rounded-md mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#9A7B6F]">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $user->dob) }}"
                           class="w-full border-gray-300 rounded-md mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#9A7B6F]">Profile Image</label>
                    <input type="file" name="profile_image" class="mt-1">
                    @if ($user->profile_image)
                        <img src="{{ $user->profile_image }}" class="w-24 h-24 mt-3 rounded-full object-cover">
                    @endif
                </div>

                <button type="submit"
                        class="px-6 py-2 bg-[#8B5E3C] text-white rounded-md hover:bg-[#734A2F]">
                    Save
                </button>
            </form>
        </div>
    </div>
</x-app-layout>

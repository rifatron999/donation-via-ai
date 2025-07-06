<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
        <form method="POST" action="{{ route('donor.login') }}">
            @csrf

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border mt-1 p-2 rounded" required autofocus>
            </div>

            <div class="mt-4">
                <label class="block font-medium">Password</label>
                <input type="password" name="password" class="w-full border mt-1 p-2 rounded" required>
            </div>

            <div class="mt-4">
                <button class="bg-blue-600 text-black px-4 py-2 rounded" type="submit">
                    Login as Donor
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>

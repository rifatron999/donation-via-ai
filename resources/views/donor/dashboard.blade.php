<!-- resources/views/donor/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Welcome, {{ auth()->guard('donor')->user()->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700 text-lg mb-4">
                    We're glad to have you here. Ready to make a donation?
                </p>

                <a href="{{ route('donor.donate.form') }}"
				   class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
				    Donate Now
				</a>

            </div>
        </div>
    </div>
</x-app-layout>

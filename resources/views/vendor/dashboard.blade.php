<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vendor Dashboard - Recent Donations
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Latest Received Stripe Payments (Donation via AI)</h3>

            @if($charges->isEmpty())
                <p>No donations with description "Donation via AI" found.</p>
            @else
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">Amount</th>
                            <th class="border px-4 py-2 text-left">Email</th>
                            <th class="border px-4 py-2 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($charges as $charge)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">
                                    ${{ number_format($charge->amount / 100, 2) }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $charge->billing_details->email ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::createFromTimestamp($charge->created)->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>

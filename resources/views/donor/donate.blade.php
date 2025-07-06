<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Donate
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <form action="{{ route('donor.donate') }}" method="POST" id="payment-form">
                @csrf

                <label for="amount" class="block font-medium text-sm text-gray-700">Amount (USD):</label>
                <input 
                    type="number" 
                    name="amount" 
                    id="amount" 
                    placeholder="e.g., 20" 
                    min="1" step="any" 
                    required
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                >

                <label for="vendor_id" class="block font-medium text-sm text-gray-700 mt-4">Select Vendor:</label>
                <select 
                    name="vendor_id" 
                    id="vendor_id" 
                    required 
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                >
                    <option value="">-- Choose a Vendor --</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->id }} : {{ $vendor->name }}</option>
                    @endforeach
                </select>


                <label for="card-element" class="block font-medium text-sm text-gray-700 mt-4">Credit or Debit Card:</label>
                <div id="card-element" class="p-3 border border-gray-300 rounded-md"></div>

                <div id="card-errors" role="alert" class="text-red-600 mt-2 mb-4"></div>

                <button 
                    type="submit" 
                    id="submit-button"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    Donate
                </button>
            </form>

        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();

        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': { color: '#aab7c4' },
            },
            invalid: { color: '#fa755a', iconColor: '#fa755a' },
        };

        const card = elements.create('card', { style });
        card.mount('#card-element');

        card.on('change', event => {
            const displayError = document.getElementById('card-errors');
            displayError.textContent = event.error ? event.error.message : '';
        });

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;

            const { token, error } = await stripe.createToken(card);

            if (error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                submitButton.disabled = false;
            } else {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'stripeToken';
                input.value = token.id;
                form.appendChild(input);

                form.submit();
            }
        });
    </script>
</x-app-layout>

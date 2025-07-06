<!-- resources/views/donate.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        input[type="number"],
        #card-element {
            width: 100%;
            padding: 10px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #card-errors {
            color: red;
            margin-bottom: 12px;
        }

        button {
            padding: 10px 20px;
            background-color: #6772e5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:disabled {
            background-color: #bbb;
        }
    </style>
</head>
<body>

    <h2>Donate</h2>

    <form action="{{ route('donor.donate') }}" method="POST" id="payment-form">
        @csrf
        <label for="amount">Amount (USD):</label>
        <input type="number" name="amount" id="amount" placeholder="e.g., 20" min="1" step="any" required>

        <label for="card-element">Credit or Debit Card:</label>
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>

        <button type="submit" id="submit-button">Donate</button>
    </form>

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
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const card = elements.create('card', { style });
        card.mount('#card-element');

        // Handle real-time validation errors
        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;

            const { token, error } = await stripe.createToken(card);

            if (error) {
                // Inform the user if there was an error.
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                submitButton.disabled = false;
            } else {
                // Append token to the form
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'stripeToken';
                input.value = token.id;
                form.appendChild(input);

                // Submit the form
                form.submit();
            }
        });
    </script>
</body>
</html>

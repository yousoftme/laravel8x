
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-96 m-auto shadow-lg rounded-lg my-5 p-4 bg-blue-100">
        <h1 class="text-center text-2xl text-purple-600 mb-4">Payment Method Stripe</h1>
        <div>
            <label for="card-holder-name">Card Holder Name</label>
            <input id="card-holder-name" class="w-full py-1 px-3 rounded" type="text" placeholder="Card Holder Name">
        </div>

        <!-- Stripe Elements Placeholder -->
        <div id="card-element" class="my-4"></div>
        <div class="text-right">
            <button id="card-button" class="bg-green-500 px-3 py-1 rounded text-white" data-secret="{{ $intent->client_secret }}">
                Update Payment Method
            </button>
        </div>
    </div>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            let stripeKey = document.querySelector('meta[name="stripe-key"]').content;

            const stripe = Stripe(stripeKey);

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            console.log(clientSecret);
            cardButton.addEventListener('click', async (e) => {
                console.log(e);
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                console.log(setupIntent);
                console.log(error);
                if (error) {
                    console.log(error.message);
                    // Display "error.message" to the user...
                } else {
                    console.log('The card has been verified successfully');
                    // The card has been verified successfully...
                }
            });
        </script>
    @endpush
</x-app-layout>



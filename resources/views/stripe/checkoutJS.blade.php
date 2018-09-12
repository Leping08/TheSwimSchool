<script src="https://js.stripe.com/v3/"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    let stripe = Stripe(window.laravelConfig.STRIPE_PUBLIC);
    let elements = stripe.elements();
    let formSubmitted = false;
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    axiosAPICall('Page loaded', 'So far so good!').then(function () {
        console.log('Page loaded');
    });

    let card = elements.create('card', {
        style: {
            base: {
                iconColor: '#666EE8',
                color: '#31325F',
                lineHeight: '40px',
                fontWeight: 300,
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSize: '15px',
                '::placeholder': {
                    color: '#CFD7E0'
                }
            }
        }
    });
    card.mount('#card-element');


    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        let form = document.getElementById('payment-form');
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

    function createToken() {
        axiosAPICall('The user hit the submit button! Executing the stripe.createToken function now.', null).then(function () {
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    let errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    axiosAPICall('Error in creating stripe token.', result).then(function () {
                        console.log("Error: ".result.error.message);
                    });
                } else {
                    axiosAPICall('Created Stripe token successfully ', result).then(function () {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    });
                }
            });
        });
    }

    //Create a token when the form is submitted.
    let form = document.getElementById('payment-form');
    form.addEventListener('submit', function(e) {
        if(!formSubmitted) {
            formSubmitted = true;
            e.preventDefault();
            createToken();
        }
    });

    card.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
            formSubmitted = false;
            displayError.textContent = event.error.message;

        } else {
            formSubmitted = false;
            displayError.textContent = '';
        }
    });

    async function axiosAPICall(message, params) {
        axios.post('/checkout-debug', {
            message: message,
            params: params,
            url: window.location.href
        })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
});
</script>
// Load Stripe.js
const stripe = Stripe('your_publishable_key_here');
let elements;

// Initialize payment elements
async function initializePayment(transportType, travelDate, passengers) {
    const response = await fetch("/process-payment.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ 
            request_type: 'create_payment_intent',
            transport_type: transportType,
            travel_date: travelDate,
            passengers: passengers,
            destination: 'coxs-bazar'
        })
    });

    const { clientSecret } = await response.json();

    elements = stripe.elements({ clientSecret });

    const paymentElement = elements.create("payment");
    paymentElement.mount("#payment-element");
}

// Handle form submission
async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: "http://your-domain.com/booking-success.php",
        },
    });

    if (error) {
        const messageContainer = document.querySelector("#payment-message");
        messageContainer.textContent = error.message;
        messageContainer.classList.remove("hidden");
        setLoading(false);
    }
}

// UI helpers
function setLoading(isLoading) {
    const submitButton = document.querySelector("#submit-button");
    const spinner = document.querySelector("#spinner");
    const buttonText = document.querySelector("#button-text");

    if (isLoading) {
        submitButton.disabled = true;
        spinner.classList.remove("hidden");
        buttonText.classList.add("hidden");
    } else {
        submitButton.disabled = false;
        spinner.classList.add("hidden");
        buttonText.classList.remove("hidden");
    }
} 
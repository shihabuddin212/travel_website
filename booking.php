<?php
require_once __DIR__ . '/vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51QLLqbJcVq5mfW9UcfkUMQE5rZ1Co5Q3wPMA2NoD1XtkdHze6oJvVq9l7VDs0lKLcxupPq54Q2fpM9U9XC09zxrU00FDoeS8g6');

session_start();

// Debug session information
error_log("Session data: " . print_r($_SESSION, true));

// Ensure user is authenticated
if (!isset($_SESSION['user_id']) && !isset($_SESSION['google_user'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Book Your Trip - BD Adventures";
include 'components/header.php';
include 'components/nav.php';

// Get destination from URL
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';

if (isset($_GET['destination'])) {
    $_SESSION['destination'] = $_GET['destination'];
}
?>

<div class="booking-page" style="margin-top: 80px;">
    <div class="container">
        <div class="booking-form-container">
            <h2>Book Your Trip to <?php echo ucwords(str_replace('-', ' ', $destination)); ?></h2>
            
            <!-- Transport Selection -->
            <div class="transport-selection">
                <h3>Select Your Transport Mode</h3>
                <div class="transport-options">
                    <div class="transport-option" data-transport="bus">
                        <i class="fas fa-bus"></i>
                        <span>By Bus</span>
                        <p class="transport-price">From 800 BDT</p>
                    </div>
                    <div class="transport-option" data-transport="air">
                        <i class="fas fa-plane"></i>
                        <span>By Air</span>
                        <p class="transport-price">From 3500 BDT</p>
                    </div>
                    <div class="transport-option" data-transport="train">
                        <i class="fas fa-train"></i>
                        <span>By Train</span>
                        <p class="transport-price">From 1200 BDT</p>
                    </div>
                </div>
            </div>

            <!-- Booking Details Form -->
            <form id="bookingForm" class="booking-form" style="display: none;">
                <div class="form-group">
                    <label for="travel-date">Travel Date</label>
                    <input type="date" id="travel-date" name="travel-date" required>
                </div>

                <div class="form-group">
                    <label for="passengers">Number of Passengers</label>
                    <input type="number" id="passengers" name="passengers" min="1" max="10" value="1" required>
                </div>

                <div class="form-group">
                    <label for="class">Travel Class</label>
                    <select id="class" name="class" required>
                        <option value="">Select Class</option>
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="first">First Class</option>
                    </select>
                </div>

                <!-- Price Display -->
                <div class="price-display">
                    <h4>Price Breakdown</h4>
                    <div class="price-details">
                        <p>Base Fare: <span id="baseFare">0</span> BDT</p>
                        <p>Tax (15%): <span id="tax">0</span> BDT</p>
                        <hr>
                        <p class="total">Total: <span id="totalPrice">0</span> BDT</p>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <h3>Payment Details</h3>
                    <div id="card-element"></div>
                    <div id="card-errors" role="alert" class="hidden"></div>
                    <button type="submit" class="btn btn-primary proceed-payment" id="submit-button">
                        <span id="button-text">Pay Now</span>
                        <div class="spinner hidden" id="spinner"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.booking-page {
    background-color: var(--light-beige);
    padding: 40px 0;
    min-height: 80vh;
}

.booking-form-container {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.transport-options {
    display: flex;
    gap: 20px;
    margin: 30px 0;
}

.transport-option {
    flex: 1;
    padding: 20px;
    text-align: center;
    background: var(--light-beige);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.transport-option:hover {
    transform: translateY(-5px);
    background: var(--light-orange);
    color: white;
}

.transport-option.selected {
    background: var(--dark-orange);
    color: white;
}

.transport-option i {
    font-size: 2em;
    margin-bottom: 10px;
    display: block;
}

.transport-option span {
    display: block;
    margin: 10px 0;
    font-weight: bold;
}

.transport-option .transport-price {
    font-size: 0.9em;
    color: #666;
}

.transport-option.selected .transport-price {
    color: white;
}

.booking-form {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--dark-green);
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1em;
}

.price-display {
    background: var(--light-beige);
    padding: 20px;
    border-radius: 12px;
    margin: 30px 0;
}

.price-details p {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
}

.payment-section {
    margin-top: 20px;
}

#payment-element {
    margin: 20px 0;
}

.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.hidden {
    display: none;
}

@media (max-width: 768px) {
    .transport-options {
        flex-direction: column;
    }
    
    .transport-option {
        margin-bottom: 10px;
    }
}

/* Add these new Stripe-related styles */
#card-element {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin: 20px 0;
}

#card-errors {
    color: #dc3545;
    margin-top: 10px;
    text-align: center;
}

.hidden {
    display: none;
}
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe with your publishable key
    const stripe = Stripe('pk_test_51QLLqbJcVq5mfW9UuULwTh36xX4C0tEYKKVp7W4AF7RbPCR46NHHcVR9N5LrGmh5zcWnQukTdFXMQl0v867TdrqQ00ZDiRsvQ3');
    const elements = stripe.elements();

    // Create card Element
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    // Handle form submission
    const form = document.getElementById('bookingForm');
    const submitButton = document.getElementById('submit-button');
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('button-text');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        console.log('Form submitted');

        // Disable the submit button
        submitButton.disabled = true;
        spinner.classList.remove('hidden');
        buttonText.classList.add('hidden');

        try {
            const totalAmount = parseFloat(document.getElementById('totalPrice').textContent);
            const transportType = document.querySelector('.transport-option.selected').dataset.transport;
            const travelClass = document.getElementById('class').value;
            const passengers = document.getElementById('passengers').value;
            const travelDate = document.getElementById('travel-date').value;

            console.log('Amount:', totalAmount);

            // Create PaymentIntent
            const response = await fetch('create-payment-intent.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: totalAmount,
                    transport_type: transportType,
                    travel_class: travelClass,
                    passengers: passengers,
                    travel_date: travelDate
                })
            });

            const data = await response.json();
            console.log('PaymentIntent response:', data);

            if (data.error) {
                throw new Error(data.error);
            }

            // Confirm card payment
            const result = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: {
                    card: cardElement,
                }
            });

            console.log('Payment result:', result);

            if (result.error) {
                throw new Error(result.error.message);
            }

            if (result.paymentIntent.status === 'succeeded') {
                try {
                    // Get the form data
                    const transportType = document.querySelector('.transport-option.selected').dataset.transport;
                    const travelClass = document.getElementById('class').value;
                    const passengers = document.getElementById('passengers').value;
                    const travelDate = document.getElementById('travel-date').value;
                    const totalAmount = parseFloat(document.getElementById('totalPrice').textContent);

                    // Send booking data to server
                    const response = await fetch('save-booking.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            transport_type: transportType,
                            travel_class: travelClass,
                            number_of_persons: parseInt(passengers),
                            travel_date: travelDate,
                            total_amount: totalAmount,
                            payment_intent_id: result.paymentIntent.id
                        })
                    });

                    const responseData = await response.json();

                    if (response.ok && responseData.success) {
                        window.location.href = 'booking-success.php';
                    } else {
                        throw new Error(responseData.message || 'Failed to save booking');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    document.getElementById('card-errors').textContent = error.message;
                    document.getElementById('card-errors').classList.remove('hidden');
                }
            }

        } catch (error) {
            console.error('Error:', error);
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            errorElement.classList.remove('hidden');
        } finally {
            submitButton.disabled = false;
            spinner.classList.add('hidden');
            buttonText.classList.remove('hidden');
        }
    });

    // Handle real-time validation errors
    cardElement.addEventListener('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.classList.remove('hidden');
        } else {
            displayError.textContent = '';
            displayError.classList.add('hidden');
        }
    });

    const transportOptions = document.querySelectorAll('.transport-option');
    const bookingForm = document.getElementById('bookingForm');

    // Add click event listeners to transport options
    transportOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            transportOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Show the booking form
            bookingForm.style.display = 'block';
            
            // Scroll to the form
            bookingForm.scrollIntoView({ behavior: 'smooth' });
            
            // Update prices based on selection
            updatePrices();
        });
    });

    // Function to update prices
    function updatePrices() {
        const selectedTransport = document.querySelector('.transport-option.selected');
        const passengers = parseInt(document.getElementById('passengers').value) || 1;
        const travelClass = document.getElementById('class').value;

        if (!selectedTransport) return;

        let basePrice = 0;
        switch(selectedTransport.dataset.transport) {
            case 'bus':
                basePrice = 800;
                break;
            case 'air':
                basePrice = 3500;
                break;
            case 'train':
                basePrice = 1200;
                break;
        }

        // Apply class multiplier
        switch(travelClass) {
            case 'business':
                basePrice *= 1.5;
                break;
            case 'first':
                basePrice *= 2;
                break;
        }

        // Multiply by number of passengers
        basePrice *= passengers;

        // Calculate tax
        const tax = basePrice * 0.15;
        const total = basePrice + tax;

        // Update price display
        document.getElementById('baseFare').textContent = basePrice.toFixed(2);
        document.getElementById('tax').textContent = tax.toFixed(2);
        document.getElementById('totalPrice').textContent = total.toFixed(2);
    }

    // Add event listeners for form inputs to update prices
    document.getElementById('passengers').addEventListener('change', updatePrices);
    document.getElementById('class').addEventListener('change', updatePrices);
});
</script>

<?php include 'components/footer.php'; ?> 
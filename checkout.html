<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #fff8f2;
    margin: 0;
    padding: 20px;
}
h1 { color: #6b3e26; text-align: center; margin-bottom: 30px; }

.checkout-container {
    max-width: 600px;
    margin: auto;
    background: #fff;
    padding: 25px;
    border: 2px solid #6b3e26;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.checkout-container label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #333;
}

.checkout-container input, .checkout-container select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #6b3e26;
    font-size: 16px;
}

.checkout-container button {
    background: #6b3e26;
    color: #fff;
    border: none;
    padding: 12px 0;
    width: 100%;
    margin-top: 20px;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
}
.checkout-container button:hover { background: #855c3a; }

.total-price {
    text-align: right;
    margin-top: 15px;
    font-weight: bold;
    font-size: 18px;
    color: #6b3e26;
}
</style>
</head>
<body>

<h1>Checkout</h1>

<div class="checkout-container">
    <form id="checkoutForm">
        <label for="name">Full Name:</label>
        <input type="text" id="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" required>

        <label for="address">Address:</label>
        <input type="text" id="address" required>

        <label for="payment">Payment Method:</label>
        <select id="payment" required>
            <option value="">--Select--</option>
            <option value="card">Credit/Debit Card</option>
            <option value="paypal">PayPal</option>
            <option value="cod">Cash on Delivery</option>
        </select>

        <p class="total-price" id="totalPrice">Total: $0.00</p>

        <button type="submit">Pay Now</button>
    </form>
</div>

<script>
let cart = JSON.parse(localStorage.getItem("cart")) || [];
const totalPriceEl = document.getElementById("totalPrice");

function calculateTotal() {
    let total = 0;
    cart.forEach(item => {
        const price = parseFloat(item.pricePerUnit) || 0;
        const qty = parseInt(item.qty) || 0;
        total += price * qty;
    });
    totalPriceEl.textContent = `Total: $${total.toFixed(2)}`;
}


document.getElementById("checkoutForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const address = document.getElementById("address").value.trim();
    const payment = document.getElementById("payment").value;

    if(!name || !email || !address || !payment) {
        alert("Please fill all fields!");
        return;
    }

    alert(`Thank you ${name}! Your order has been placed.\nTotal: ${totalPriceEl.textContent.replace("Total: ", "")}\nPayment Method: ${payment}`);

  
    localStorage.removeItem("cart");
    window.location.href = "brownies.html"; 
});


calculateTotal();
</script>

</body>
</html>

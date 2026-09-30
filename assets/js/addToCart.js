// Load cart items from localStorage
const container = document.getElementById('cart-container');
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function renderCart() {
  if (cart.length === 0) {
    container.innerHTML = "<p>Your cart is empty. Start shopping!</p>";
    return;
  }

  container.innerHTML = cart.map((item, index) => `
    <div class="cart-item">
      <img src="${item.image}" alt="${item.name}">
      <h2>${item.name}</h2>
      <p>${item.price}</p>
      <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
    </div>
  `).join('');
}

function removeItem(index) {
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  renderCart();
}

// Checkout button
document.getElementById('checkout-btn').addEventListener('click', () => {
  alert("Proceeding to checkout...");
});

renderCart();

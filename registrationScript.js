// registrationScript.js

// JavaScript for toggling between login and registration forms, show password, and form validation
const container = document.querySelector('.container');
const loginForm = document.querySelector('.form-box.login');
const registerForm = document.querySelector('.form-box.register');
const loginBtn = document.querySelector('.login-btn');
const registerBtn = document.querySelector('.register-btn');

// Default: show login
loginForm.classList.add('active');

registerBtn.addEventListener('click', () => {
  loginForm.classList.remove('active');
  registerForm.classList.add('active');
  container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
  registerForm.classList.remove('active');
  loginForm.classList.add('active');
  container.classList.remove('active');
});

// Functions to show login and registration forms
function showLogin() {
  document.querySelector(".container").classList.add("show-login");
  document.querySelector(".container").classList.remove("show-register");
}

function showRegister() {
  document.querySelector(".container").classList.add("show-register");
  document.querySelector(".container").classList.remove("show-login");
}

// Event listeners for form submission and validation
document.querySelector('.login-form').addEventListener('submit', e => {
  e.preventDefault(); // stop default redirect

  // Show confirmation message
  document.getElementById('confirmation-message').style.display = 'block';
});


// Show password toggle
const passwordInput = document.getElementById('password');
const togglePassword = document.querySelector('.toggle-password');
togglePassword.addEventListener('click', () => {
  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordInput.setAttribute('type', type);
  togglePassword.textContent = type === 'password' ? 'Show' : 'Hide';
});

// Form validation
const form = document.getElementById('authForm');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  const email = document.getElementById('email').value.trim();
  const password = passwordInput.value.trim();
    if (!email || !password) {
    alert('Please fill in all fields');
    return;
  } else if (!validateEmail(email)) {
    alert('Please enter a valid email');
    return;
  } else if (password.length < 6) {
    alert('Password must be at least 6 characters');
    return;
  } else {
    alert('Form submitted successfully!');
    form.reset();
  }
});

// Email validation function
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

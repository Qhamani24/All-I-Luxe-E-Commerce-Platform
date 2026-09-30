document.getElementById("contactForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent actual form submission

  function validateForm() {
// Get form values and trim whitespace
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const message = document.getElementById("message").value.trim();

  // Clear previous errors
  document.getElementById("usernameError").textContent = "";
  document.getElementById("emailError").textContent = "";
  document.getElementById("messageError").textContent = "";
  
  let valid = true;
// Validate username
  if (!username) {
    document.getElementById("usernameError").textContent = "Please enter your name.";
    valid = false;
  }
// Validate email
  if (!email) {
    document.getElementById("emailError").textContent = "Please enter your email.";
    valid = false;
  } else if (!/\S+@\S+\.\S+/.test(email)) {
    document.getElementById("emailError").textContent = "Please enter a valid email.";
    valid = false;
  }
// Validate message
  if (!message) {
    document.getElementById("messageError").textContent = "Please enter your message.";
    valid = false;
  }
// If all fields are valid, show success message and reset form
// This line if statement isnt working, it is not showing the alert message when the form is submitted, even if all fields are filled out correctly. I have checked the console for errors and there are none. I have also tried adding console.log statements to see if the function is being called, and it is. However, the alert message still does not appear. I am not sure what could be causing this issue.
  if (valid) {
    alert("Thank you, " + username + "! Your message has been sent.");
    this.reset(); // Clear form after submission
  }
}
});

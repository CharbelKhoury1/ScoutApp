// Get form and input field elements
const form = document.querySelector('form');
const nameInput = document.querySelector('#name');
const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');

// Add event listener to form on submit
form.addEventListener('submit', (event) => {
  // Check if input fields are empty
  if (nameInput.value.trim() === '' || emailInput.value.trim() === '' || passwordInput.value.trim() === '') {
    event.preventDefault();
    alert('Please fill out all fields.');
  }
  
  // Check if password is at least 8 characters long
  if (passwordInput.value.length < 8) {
    event.preventDefault();
    alert('Password must be at least 8 characters long.');
  }
  
  // Check if email address is valid
  if (!isValidEmail(emailInput.value)) {
    event.preventDefault();
    alert('Please enter a valid email address.');
  }
});

// Function to check if email address is valid
function isValidEmail(email) {
  // Regex pattern for email validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(email);
}

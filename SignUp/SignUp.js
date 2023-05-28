// Get form and input field elements
const form = document.querySelector('form');
const fnameInput = document.querySelector('#firstname');
const lnameInput = document.querySelector('#lastname');
const fatherNameInput = document.querySelector('#fathername');
const motherNameInput = document.querySelector('#mothername');
const birthDateInput = document.querySelector('#dateofbirth');
const birthPlaceInput = document.querySelector('#placeofbirth');
const bloodTypeInput = document.querySelector('#bloodtype');
const landlineInput = document.querySelector('#landline');
const mobileInput = document.querySelector('#phonenumber');
const fatherJobInput = document.querySelector('#fatherjob');
const motherJobInput = document.querySelector('#motherjob');
const fatherMobileInput = document.querySelector('#fatherphonenumber');
const motherMobileInput = document.querySelector('#motherphonenumber');
const educationInput = document.querySelector('#education');
const jobInput = document.querySelector('#job');
const emailInput = document.querySelector('#email');
const medicalConditionInput = document.querySelector('#medicalcondition');

// Add event listener to form on submit
form.addEventListener('submit', (event) => {
  // Check if input fields are empty
  if (
    fnameInput.value.trim() === '' ||
    lnameInput.value.trim() === '' ||
    fatherNameInput.value.trim() === '' ||
    motherNameInput.value.trim() === '' ||
    birthDateInput.value.trim() === '' ||
    birthPlaceInput.value.trim() === '' ||
    bloodTypeInput.value.trim() === '' ||
    landlineInput.value.trim() === '' ||
    mobileInput.value.trim() === '' ||
    fatherJobInput.value.trim() === '' ||
    motherJobInput.value.trim() === '' ||
    fatherMobileInput.value.trim() === '' ||
    motherMobileInput.value.trim() === '' ||
    educationInput.value.trim() === '' ||
    jobInput.value.trim() === '' ||
    emailInput.value.trim() === '' ||
    medicalConditionInput.value.trim() === ''
  ) {
    event.preventDefault();
    alert('Please fill out all fields.');
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

const form = document.querySelector('form');
const codeInput = document.getElementById('scoutcode');
const passwordInput = document.getElementById('password');
const submitBtn = document.getElementById('submit-btn');

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const code = codeInput.value;
  const password = passwordInput.value;
  // Perform validation or authentication logic here
  console.log(`ScoutCode: ${code}, Password: ${password}`);
});

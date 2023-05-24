function togglePasswordVisibility(inputId) {
	var passwordInput = document.getElementById(inputId);
	var togglePassword = passwordInput.nextElementSibling;
	var icon = togglePassword.querySelector("i");

	if (passwordInput.type === "password") {
		passwordInput.type = "text";
		icon.classList.remove("fa-eye-slash");
		icon.classList.add("fa-eye");
	} else {
		passwordInput.type = "password";
		icon.classList.remove("fa-eye");
		icon.classList.add("fa-eye-slash");
	}
	
	passwordInput.style.padding = "10px";
	passwordInput.style.border = "1px solid #ccc";
	passwordInput.style.borderRadius = "5px";
	passwordInput.style.marginBottom = "20px";
	passwordInput.style.fontSize = "16px";
	passwordInput.style.width = "100%";
}
	
function validateForm() {
	var passwordInput = document.getElementById("passwordInput");
	var confirmPasswordInput = document.getElementsByName("confirmPassword")[0];
	var password = passwordInput.value;
	var confirmPassword = confirmPasswordInput.value;
	var passwordError = document.getElementById("passwordError");

	var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

	if (password !== confirmPassword) {
		passwordError.innerText = "Passwords do not match";
		passwordError.style.display = "block";
		passwordInput.classList.add("error-input");
		confirmPasswordInput.classList.add("error-input");
		passwordInput.style.borderColor = "red";
		confirmPasswordInput.style.borderColor = "red"; 
		return false;
	} else if (!regex.test(password)) {
		passwordError.innerText = "Password should contain a minimum of 8 characters with at least one uppercase letter, one lowercase letter, one number, and one special character";
		passwordError.style.display = "block";
		passwordInput.classList.add("error-input");
		passwordInput.style.borderColor = "red";
		confirmPasswordInput.style.borderColor = "initial"; 
		return false;
	} else {
		passwordError.style.display = "none";
		passwordInput.classList.remove("error-input");
		confirmPasswordInput.classList.remove("error-input");
		passwordInput.style.borderColor = "initial";
		confirmPasswordInput.style.borderColor = "initial";
		return true;
    }
}
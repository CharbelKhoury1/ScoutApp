var submitButton = document.getElementById("submit-button");
var userInput = document.getElementById("user-input");
var canvas = document.getElementById("canvas");
var reloadButton = document.getElementById("reload-button");
var text = "";
var passwordError = document.getElementById("passwordError");

function textGenerator() {
    var generatedText = "";
    generatedText += String.fromCharCode(randomNumber(65, 90));
    generatedText += String.fromCharCode(randomNumber(97, 122));
    generatedText += String.fromCharCode(randomNumber(48, 57));
    var randomType = randomNumber(0, 2);
    if (randomType === 0) {
        generatedText += String.fromCharCode(randomNumber(65, 90)); // Capital letter
    } else if (randomType === 1) {
        generatedText += String.fromCharCode(randomNumber(97, 122)); // Small letter
    } else {
        generatedText += String.fromCharCode(randomNumber(48, 57)); // Number
    }
    
    return generatedText;
}

function randomNumber(min, max) {
	return Math.floor(Math.random() * (max - min + 1) + min);
}

function drawStringOnCanvas(string) {
	var ctx = canvas.getContext("2d");
	// Clear canvas
	ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
	var textColors = ["rgb(0,0,0)", "rgb(130,130,130)"];
	var letterSpace = 150 / string.length;
	for (var i = 0; i < string.length; i++) {
		// Define initial space on X axis
		var xInitialSpace = 25;
		ctx.font = "20px Roboto Mono";
		// Set text color
		ctx.fillStyle = textColors[randomNumber(0, 1)];
		ctx.fillText(
			string[i],
			xInitialSpace + i * letterSpace,
			randomNumber(25, 40),
			100
		);
	}
}

function triggerFunction() {
	userInput.value = "";
	userInput.classList.remove("invalid"); 
	text = textGenerator();
	console.log(text);
	// Randomize the text so that every time the position of numbers and small letters is random
	text = text.split("").sort(function () {
		return 0.5 - Math.random();
	}).join("");
		drawStringOnCanvas(text);
}

reloadButton.addEventListener("click", triggerFunction);

window.onload = function () {
	triggerFunction();
};

submitButton.addEventListener("click", function (event) {
	event.preventDefault();
	if (userInput.value === text) {
		document.getElementById("contactForm").submit();
	} else {
		triggerFunction();
		userInput.classList.add("invalid"); // Add invalid class to the input field
	}
});
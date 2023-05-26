// When the page loads, execute the following code
window.addEventListener('load', function() {
    // Get the navigation menu element
    const nav = document.querySelector('nav');
  
    // Get the height of the header element
    const headerHeight = document.querySelector('header').offsetHeight;
  
    // When the user scrolls the page, execute the following code
    window.addEventListener('scroll', function() {
      // If the user has scrolled past the header element
      if (window.scrollY > headerHeight) {
        // Add a class to the navigation menu to make it stick to the top of the screen
        nav.classList.add('sticky');
      } else {
        // Otherwise, remove the sticky class from the navigation menu
        nav.classList.remove('sticky');
      }
    });
  });

  // Store the current orientation of the device
var currentOrientation = window.orientation;

// Listen for changes in the device orientation
window.addEventListener("orientationchange", function() {
  // If the device orientation has changed
  if (window.orientation !== currentOrientation) {
    // Set the current orientation to the new orientation
    currentOrientation = window.orientation;
    // Update the viewport meta tag to prevent the website from resetting
    var viewport = document.querySelector("meta[name=viewport]");
    viewport.setAttribute("content", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0");
  }
});

  
// sidebar js
document.querySelector(".sidebar .logo").addEventListener("click",
function(){
  document.querySelector(".sidebar").classList.toggle("active");
})





const slides = document.querySelectorAll(".slide");
//This part is for enabling the arrows left and right of the keyboard.
document.addEventListener("keydown", (event) => {
    if (event.key === "ArrowRight") {
      // Move to the next slide
      const activeSlide = document.querySelector(".slide.active");
      const nextSlide = activeSlide.nextElementSibling || slides[0];
      activeSlide.classList.remove("active");
      nextSlide.classList.add("active");
    } else if (event.key === "ArrowLeft") {
      // Move to the previous slide
      const activeSlide = document.querySelector(".slide.active");
      const prevSlide = activeSlide.previousElementSibling || slides[slides.length - 1];
      activeSlide.classList.remove("active");
      prevSlide.classList.add("active");
    
    }
    
    // Loop back to the first slide when reaching the end
    const activeSlide = document.querySelector(".slide.active");
    if (!activeSlide) {
      slides[0].classList.add("active");
    }
  });




// Get the slider and slide elements
const slider = document.querySelector('.slider');
// Set the active slide index to 0
let activeSlide = 0;

// Set the touch start and end coordinates
let touchStartX = 0;
let touchEndX = 0;

// Add event listeners for touch start, move, and end
slider.addEventListener('touchstart', handleTouchStart);
slider.addEventListener('touchmove', handleTouchMove);
slider.addEventListener('touchend', handleTouchEnd);

// Handle touch start
function handleTouchStart(event) {
touchStartX = event.touches[0].clientX;
}

// Handle touch move
function handleTouchMove(event) {
touchEndX = event.touches[0].clientX;
}

// Handle touch end
function handleTouchEnd() {
// Determine the direction of the swipe
const deltaX = touchEndX - touchStartX;
if (deltaX > 0) {
// Swipe to the right
showSlide(activeSlide - 1);
} else if (deltaX < 0) {
// Swipe to the left
showSlide(activeSlide + 1);
}
}

// Show the specified slide
function showSlide(index) {
// Check if the index is out of bounds
if (index < 0) {
index = slides.length - 1;
} else if (index >= slides.length) {
index = 0;
}

// Remove the active class from the current slide
slides[activeSlide].classList.remove('active');

// Add the active class to the specified slide
slides[index].classList.add('active');

// Update the active slide index
activeSlide = index;

// Update the active dot
updateActiveDot();
}

function scrollToSection(sectionClass) {
  const section = document.getElementsByClassName(sectionClass)[0];
  section.scrollIntoView({ behavior: "smooth" });

  const buttons = document.querySelectorAll(".links button");

buttons.forEach((button) => {
  button.addEventListener("click", function () {
    // Remove the "active" class from all buttons
    buttons.forEach((btn) => btn.classList.remove("active"));
    
    // Add the "active" class to the clicked button
    this.classList.add("active");
  });
});
}



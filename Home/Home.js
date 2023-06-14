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

  // This code will be executed once a key is pressed on your computer's keyboard
  // I added the automatic scrolling.
  const slider = document.querySelector('.slider');
  let activeSlide = 0;
  let touchStartX = 0;
  let touchEndX = 0;
  let timer = null; // Variable to store the timer
  
  // Add event listeners for touch events
  slider.addEventListener('touchstart', handleTouchStart);
  slider.addEventListener('touchmove', handleTouchMove);
  slider.addEventListener('touchend', handleTouchEnd);
  
  // Function to start the automatic scrolling timer
  function startTimer() {
    timer = setInterval(() => {
      showSlide(activeSlide + 1); // Show the next slide
    }, 3000); // Interval of 3 seconds
  }
  
  // Function to stop the automatic scrolling timer
  function stopTimer() {
    clearInterval(timer);
  }
  
  // Function to handle touch start event
  function handleTouchStart(event) {
    touchStartX = event.touches[0].clientX;
    stopTimer(); // Stop the timer when user starts touching
  }
  
  // Function to handle touch move event
  function handleTouchMove(event) {
    touchEndX = event.touches[0].clientX;
  }
  
  // Function to handle touch end event
  function handleTouchEnd() {
    const deltaX = touchEndX - touchStartX;
    if (deltaX > 0) {
      showSlide(activeSlide - 1);
    } else if (deltaX < 0) {
      showSlide(activeSlide + 1);
    }
    startTimer(); // Start the timer again after user stops touching
  }
  
  // Function to show the specified slide
  function showSlide(index) {
    if (index < 0) {
      index = slides.length - 1;
    } else if (index >= slides.length) {
      index = 0;
    }
    slides[activeSlide].classList.remove('active');
    slides[index].classList.add('active');
    activeSlide = index;
    updateActiveDot();
  }
  
  // Start the timer when the page loads
  window.addEventListener('load', () => {
    startTimer();
  
  });
  

function scrollToSection(sectionClass) {
  const section = document.getElementsByClassName(sectionClass)[0];
  section.scrollIntoView({ behavior: "smooth" });
}

 // Get all the buttons
const buttons = document.querySelectorAll('.links button');

// Add event listener to each button
buttons.forEach(button => {
  button.addEventListener('click', () => {
    // Check if the clicked button is already active
    if (!button.classList.contains('active')) {
      // Remove the active class from all buttons
      buttons.forEach(btn => btn.classList.remove('active'));

      // Add the active class to the clicked button
      button.classList.add('active');
    }
  });
});




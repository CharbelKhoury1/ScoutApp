      const slides = document.querySelectorAll(".slide");
      const dots = document.querySelectorAll(".dot");

      dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
          const activeDot = document.querySelector(".dot.active");
          activeDot.classList.remove("active");
          dot.classList.add("active");

          const activeSlide = document.querySelector(".slide.active");
          activeSlide.classList.remove("active");
          slides[index].classList.add("active");
        });
      });



      
//This part is for enabling the arrows left and right of the keyboard.
      document.addEventListener("keydown", (event) => {
          if (event.key === "ArrowRight") {
            // Move to the next slide
            const activeSlide = document.querySelector(".slide.active");
            const nextSlide = activeSlide.nextElementSibling || slides[0];
            const activeDot = document.querySelector(".dot.active");
            const nextDot = activeDot.nextElementSibling || dots[0];
            activeSlide.classList.remove("active");
            nextSlide.classList.add("active");
            activeDot.classList.remove("active");
            nextDot.classList.add("active");
          } else if (event.key === "ArrowLeft") {
            // Move to the previous slide
            const activeSlide = document.querySelector(".slide.active");
            const prevSlide = activeSlide.previousElementSibling || slides[slides.length - 1];
            const activeDot = document.querySelector(".dot.active");
            const prevDot = activeDot.previousElementSibling || dots[dots.length - 1];
            activeSlide.classList.remove("active");
            prevSlide.classList.add("active");
            activeDot.classList.remove("active");
            prevDot.classList.add("active");
          }
          
          // Loop back to the first slide when reaching the end
          const activeSlide = document.querySelector(".slide.active");
          if (!activeSlide) {
            slides[0].classList.add("active");
            dots[0].classList.add("active");
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

// Update the active dot
function updateActiveDot() {
  // Remove the active class from all dots
  const dots = document.querySelectorAll('.dot');
  dots.forEach((dot) => dot.classList.remove('active'));

  // Add the active class to the dot corresponding to the active slide
  dots[activeSlide].classList.add('active');
}


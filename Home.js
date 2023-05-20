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




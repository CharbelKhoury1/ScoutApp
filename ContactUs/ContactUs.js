  const form = document.querySelector('form');
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const homeLink = document.querySelector('.home-link');
    homeLink.classList.remove('hidden');
  });

// sidebar code
document.querySelector(".sidebar .logo").addEventListener("click",
function(){
  document.querySelector(".sidebar").classList.toggle("active");
})
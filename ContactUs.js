  const form = document.querySelector('form');
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const homeLink = document.querySelector('.home-link');
    homeLink.classList.remove('hidden');
  });


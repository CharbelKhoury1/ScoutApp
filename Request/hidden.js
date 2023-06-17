var checkbox = document.getElementById('checkbox');
var contentToHide = document.getElementById('contentToHide');

checkbox.addEventListener('change', function() {
  if (checkbox.checked) {
    contentToHide.style.display = 'block';
  } else {
    contentToHide.style.display = 'none';
  }
});

// Initially hide the content
contentToHide.style.display = 'none';
document.getElementById('submitBtn').addEventListener('click', calculateDays);

function calculateDays() {
    const currentDate = new Date();
    const chosenDate = new Date(document.getElementById('date').value);
    const timeDifference = chosenDate.getTime() - currentDate.getTime();
    const dayDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

    if (dayDifference >= 14) {
        // Redirect to another page
        showNotification();
        //window.location.href = "process.html";
        
    } else {
        alert("Error: Event's date must at least be 14 days apart from today's date.");
    }
}
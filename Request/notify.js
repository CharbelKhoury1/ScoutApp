
notificationButton.addEventListener("click", showNotification);

function showNotification() {

    if (!("Notification" in window)) {
      console.log("This browser does not support desktop notifications.");
      return;
    }
  
    Notification.requestPermission().then(function (permission) {
      if (permission === "granted") {

        var notification = new Notification("Hello!", {
          body: "A request has been sent to you.",
        });

        notification.onclick = function () {
          //window.location.href = "process.html";
          console.log("Notification clicked.");
          
        };
      }
    });
}
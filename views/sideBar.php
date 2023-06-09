<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="Home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  </head>
  <body> 
  <div class="sidebar">
        <div class="logo">
            <img src="../Icons/menu-svgrepo-com.svg" alt="sds">
            <img src="../Icons/arrow-right-svgrepo-com.svg" alt="sdsd">
            <img src="../Icons/close-md-svgrepo-com.svg" alt="dsd">
        </div>
        <div class="links">
            <button class="active" onclick="scrollToSection('hero')">
                <img src="../Icons/home-alt-svgrepo-com.svg">Home
            </button>
            <button onclick="window.location.href='Requests.html'">
                <img src="../Icons/git-pull-request-svgrepo-com.svg">Requests
            </button>
            <button onclick="window.location.href='../views/transactionView.php'">
                <img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance
            </button>
            <button onclick="window.location.href='../ScoutManagementSystem/ScoutCode.php'">
                <img src="../Icons//icons8-password.svg">Scouts Management
            </button>
            <button onclick="scrollToSection('Scout-gallery')">
                <img src="../Icons/world-1-svgrepo-com.svg">Social Media
            </button>
            <button class="" onclick="scrollToSection('testimonials')">
                <img src="../Icons/system-help-svgrepo-com.svg">About Us
            </button>
            <button  class="" onclick="window.location.href='../views/contactUsView.php'">
                <img src="../Icons/phone-svgrepo-com.svg">Contact Us
            </button>
       </div>
    </div>
    <script src="../Home/Home.js"></script>
  </body>
</html>

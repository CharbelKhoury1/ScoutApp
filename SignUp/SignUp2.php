<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="icon" type="image/x-icon" href="ScoutsLogo.gif">
  <link rel="stylesheet" href="SignUp.css">
</head>
<body>
  <div class="container">
    <h1>Scout Info</h1>
    <form method="post" action="InsertUser.php">

      <label for="scoutrank">Scout rank (الرتبة الكشفية) with date (from newest to oldest):</label>
      <select id="scoutrank" name="scoutrank">
        <option value="generalcommander">General Commander</option>
        <option value="generalleadershipmember">General Leadership Member</option>
        <option value="generalcommisionner">General Commisionner</option>
        <option value="commissioner">Commissioner</option>
        <option value="leader">Leader</option>
        <option value="rover">Rover</option>
        <option value="ranger">Ranger</option>
        <option value="scout">Scout</option>
        <option value="girlguide">Girl Guide</option>
        <option value="cub">Cub</option>
        <option value="browny">Browny</option>
        <option value="beaver">Beaver</option>
        <option value="daisy">Daisy</option>
      </select>


      <label for="nameofregiment">Name of regiment (اسم الفوج التابع له):</label>   <!-- hyde mnaamela dropdown list mn l regiments mn l database -->
      <input type="text" id="nameofregiment" name="nameofregiment" >

      <label for="scoutunit">Scout unit اسم الفرقة التابع لها مع تاريخ (من الاجدد الى الاقدم)</label> <!-- hyde hie l table unitrankhistory  -->
      <input type="text" name="scoutunit" id="scoutunit">

      <label for="scoutclass">Scout class (الدرجة الكشفية) with date (from newest to oldest):</label>
      <textarea id="scoutclass" name="scoutclass" rows="10"></textarea>
  
      <label for="affiliationdate">Affiliation Date: (تاريخ الانتساب)</label>
      <input type="date" id="affiliationdate" name="affiliationdate" required>

      <label for="promisedate">Oath Date (تاريخ الوعد):</label>
      <input type="date" id="promisedate" name="oathdate">

      <label for="scouttitle">Scout Title (اللقب الكشفي):</label>
      <input type="text" id="scouttitle" name="scouttitle">

      <label for="dateofthetitle">Date of the title:</label>
      <input type="date" id="dateofthetitle" name="dateofthetitle">

      <label for="placeofthetitle">Place of the title:</label>
      <input type="text" id="placeofthetitle" name="placeofthetitle">
      
      <label for="trainingcourses">Training courses he participated in (what is the course / time (from date to date) / place):</label>    <!-- hle hyde barke mnaamol mtl section lahala bye2dar l moufawad aw hada martabe aalye enno yzid l courses bl database w se3eta byerjaa b na2e l chakhes shu l courses w hasab aya date kmn -->
      <textarea id="trainingcourses" name="trainingcourses" rows="10"></textarea>
      
      <input type="submit" name='SignUp2' value="Sign Up">  
    </form>
  
  </div>
</body>
</html>

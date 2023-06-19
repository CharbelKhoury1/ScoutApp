<!DOCTYPE html>
<html ng-app="app">

  <head>
    <title>Request Page</title>
    <script data-require="jquery@2.2.0" data-semver="2.2.0" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link data-require="bootstrap-css@3.3.6" data-semver="3.3.6" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel = "stylesheet" href = "design.css"/>
  </head>

  <body>

    <div class="container" ng-controller="FirstCtrl">
      <table class="table table-bordered table-downloads">
        <thead>
          <tr>
            <th>Select</th>
            <th>File name</th>
            <th>Downloads</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="tableData in tableDatas">
            <td>
              <div class="checkbox">
                <input type="checkbox" name="{{tableData.name}}" id="{{tableData.name}}" value="{{tableData.name}}" ng-model="tableData.checked" ng-change="selected()" />
              </div>
            </td>
            <td>{{tableData.fileName}}</td>
            <td>
              <a target="_self" id="download-{{tableData.name}}" ng-href="{{tableData.filePath}}" class="btn btn-success pull-right downloadable" download="">Download</a>
            </td>
          </tr>
        </tbody>
      </table>
      <a class="btn btn-success pull-right" ng-click="downloadAll()">Download Selected</a>
    </div>

    <section>

      <form action="request.php" method="POST" enctype="multipart/form-data">
        <h2>Request Details</h2>
        
        <div class="container">
          <input type = "file" name="file" id = "file-input" accept=".pdf"/>
          <label for = "file-input">
            <i class="fa-solid fa-arrow-up-from-bracket"></i>
            &nbsp; Choose Files To Upload
          </label>
          <div id = "num-of-files">No Files Choosen</div>
            <ul id = "files-list"></ul>  
          </div>
          <table class="input-table">
            <tr>
              <td><label for="date">Select Event Date:</label></td>
              <td><input type="date" name="dateN" id="date" ></td>
            </tr>

            <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <tr>

              <td><label for="user">Receiver:</label></td>
              <td><select name="receiverN" id="receiver">
              <option value="Mofawad 3am">Mofawad 3am</option>
              <option value="Ra2is">ra2is</option>
              <option value="Ne2ib">Ne2ib</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="rank">Description:</label></td>
              <td><textarea  id="description" name="descriptionN" style="resize: none;" rows="7" cols="115"></textarea></td>
            </tr>
          </table>
      
          <h2>Social Media</h2>     
          Please note that this section is not required, and if filled it's not posted on social media until it's accepted by the receiver.
          <label for="checkbox"></label>
          <input type="checkbox" id="checkbox">
          <div id = "contentToHide"> 
            <div class="container">
              <input type = "file" id = "f-input" name="mediaFile" accept="image/*" multiple/>
              <label for = "f-input">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                &nbsp; Choose Files To Upload On Social Media
              </label>
              <div id = "num-files">No Files Choosen</div>
                <ul id = "f-list"></ul>  
              </div>
              <table class="input-table">
                <tr>
                  <td><label for="rank">Caption:</label></td>
                  <td><textarea  style="resize: none;" id="caption" name="caption" rows="7" cols="115"></textarea></td>
                </tr>
              </table>
            </div>
          </div>
          <!--<a class="btn btn-success pull-right" type="submit" id="submitBtn" name="submit">Submit</a> -->
          <input type="submit" id="submitBtn" name="submit" value="Submit">
          <!--<button type="submit" id="submitBtn" name="submit">Submit</button>-->
        </div>
      </form>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <!-- <script src="daysDifference.js"></script> -->
    <script src="notify.js"></script>
    <script src="download.js"></script>
    <script src="uploadFiles.js"></script>
    <script src="uploadSocialMedia.js"></script>
    <script src="hidden.js"></script>
  </body>


</html>
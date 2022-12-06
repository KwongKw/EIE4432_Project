<?php
session_start();
unset($_SESSION['uid']);
unset($_SESSION['password']);
unset($_SESSION['username']);
if (!empty($_COOKIE['uid'])) {
  $_SESSION['uid'] = $_COOKIE['uid'];
  $_SESSION['password'] = $_COOKIE['password'];
  $_SESSION['username'] = $_COOKIE['username'];
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Lost & Found</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles/raleway.css">
  <link rel="stylesheet" href="styles/font-awesome.min.css">
  <link rel="stylesheet" href="styles/w3.css">
  <link rel="stylesheet" href="styles/style.css">
  <script src="scripts/jquery-3.6.0.min.js"></script>
  <script src="scripts/forum.js"></script>
</head>

<body>
  <!-- Navbar (sit on top) -->
  <div class="w3-top">
    <div class="w3-bar w3-white w3-card" id="myNavbar">
      <img src="images/logo.jpg" href="#home" class="w3-bar-item w3-button logo">
      <!-- Right-sided navbar links -->
      <div class="w3-right w3-hide-small">
        <a href="#about" class="w3-bar-item w3-button"> ABOUT</a>
        <a href="#forum" class="w3-bar-item w3-button"><i class="fa fa-th"></i> FORUM</a>

        <!--show account-->
        <?php if (empty($_SESSION['uid'])): ?>
        <a onclick="document.getElementById('sign-in').style.display='block'" class="w3-bar-item w3-button"><i
            class="fa fa-user"></i> SIGN IN</a>
        <?php else: ?>
        <a onclick="document.getElementById('profile').style.display='block'" class="w3-bar-item w3-button"><i
            class="fa fa-user"></i>
          <?php echo strtoupper($_SESSION['uid']) ?>
        </a>
        <?php endif; ?>
        <a href="#contact" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i> CONTACT</a>
      </div>
      <!-- Hide right-floated links on small screens and replace them with a menu icon -->
      <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
        onclick="w3_open()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <!-- Header with full-height image -->
  <header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
    <div class="w3-display-right w3-text-white" style="text-align: right; padding:48px">
      <span class="w3-jumbo w3-hide-small">Losing Something?</span><br>
      <span class="w3-xxlarge w3-hide-large w3-hide-medium">Losing Something?</span><br>
      <span class="w3-large">Get yourself some help.</span>
      <p><a href="#forum"
          class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Check our
          forum</a></p>
    </div>
    <div class="w3-display-bottomleft w3-text-grey w3-large" style="padding:24px 48px">
      <i class="fa fa-facebook-official w3-hover-opacity"></i>
      <i class="fa fa-instagram w3-hover-opacity"></i>
      <i class="fa fa-snapchat w3-hover-opacity"></i>
      <i class="fa fa-pinterest-p w3-hover-opacity"></i>
      <i class="fa fa-twitter w3-hover-opacity"></i>
      <i class="fa fa-linkedin w3-hover-opacity"></i>
    </div>
  </header>

  <!-- Forum Section-->
  <div id="forum" name="forum" style="padding:128px 16px" class="w3-container">
    <div class="w3-row w3-centered">
      <div class="col-lg-6">
        <div class="mb-3">
          <?php if ((!empty($_SESSION['uid'])) && ($_SESSION['uid'] == 'admin')): ?>
          <h4 class="forum-title"><b>Panel</b></h4>
          <?php else: ?>
          <h4 class="forum-title"><b>FORUM</b></h4>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="w3-right-align" style="padding-top: 20px;">
          <div>
            <form name="search" id="search" action="scripts/search.php" method="post" autocomplete="off">
              <?php if ((!empty($_SESSION['uid'])) && ($_SESSION['uid'] == 'admin')): ?>
              <input style="width: 30%" type="text" placeholder="Search with ID" id="inp" name="inp">
              <button class="w3-button forum-button" type="submit">Search</button>
              <a onclick="seperateforum()" class="w3-button forum-button"><i class="fa fa-gg-circle"></i> Seperated</a>
              <?php endif; ?>
              <a onclick="defaultforum()" class="w3-button forum-button"><i class="fa fa-gg-circle"></i> Default</a>
              <?php if (empty($_SESSION['uid'])): ?>
              <a onclick="alert('Please Login First')" class="w3-button forum-button"><i class="fa fa-user-circle"></i>
                My
                Notice</a>
              <a onclick="alert('Please Login First')" class="w3-button forum-button"><i class="fa fa-dropbox"></i> Add
                New</a>
              <?php else: ?>
              <a onclick="myforum()" class="w3-button forum-button"><i class="fa fa-user-circle"></i> My
                Notice</a>
              <a onclick="document.getElementById('add').style.display='block'" class="w3-button forum-button"><i
                  class="fa fa-dropbox"></i> Add New</a>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="">
          <div class="table-responsive">
            <table class="table table-nowrap align-middle table-borderless" style="padding-top: 20px;">
              <thead>
                <tr>
                  <th scope="col">Case ID</th>
                  <th scope="col">User ID</th>
                  <th scope="col">Topic</th>
                  <th scope="col">Description</th>
                  <th scope="col">Response</th>
                  <th scope="col" style="width: 200px;">Action</th>
                </tr>
              </thead>
              <tbody id="forum-content" name="forum-content">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- About Section -->
  <div class="w3-container" style="padding:128px 16px" id="about">
    <h3 class="w3-center">ABOUT THE WEBSITE</h3>
    <p class="w3-center w3-large">Key features of our website</p>
    <div class="w3-row-padding w3-center" style="margin-top:64px">
      <div class="w3-third">
        <i class="fa fa-lock w3-margin-bottom w3-jumbo w3-center"></i>
        <p class="w3-large">Lost</p>
        <p>Post descriptions on your lost item.</p>
      </div>
      <div class="w3-third">
        <i class="fa fa-key w3-margin-bottom w3-jumbo"></i>
        <p class="w3-large">Found</p>
        <p>Post descriptions on your found item.</p>
      </div>
      <div class="w3-third">
        <i class="fa fa-unlock w3-margin-bottom w3-jumbo"></i>
        <p class="w3-large">Matching</p>
        <p>Matching lost and found items.</p>
      </div>
    </div>
  </div>

  <!-- Contact Section -->
  <div class="w3-container w3-light-grey" style="padding:128px 16px" id="contact">
    <h3 class="w3-center">CONTACT</h3>
    <p class="w3-center w3-large">Lets get in touch. Send us a message:</p>
    <div style="margin-top:48px">
      <p><i class="fa fa-map-marker fa-fw w3-xxlarge w3-margin-right"></i> PolyU, HK</p>
      <p><i class="fa fa-phone fa-fw w3-xxlarge w3-margin-right"></i> Phone: +852 54761931</p>
      <p><i class="fa fa-envelope fa-fw w3-xxlarge w3-margin-right"> </i> Email:
        19067393d@connect.polyu.hk</p>
      <br>
      <form action="/action_page.php" target="_blank">
        <p><input class="w3-input w3-border" type="text" placeholder="Name" required name="Name"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Email" required name="Email"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Subject" required name="Subject">
        </p>
        <p><input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
        </p>
        <p>
          <button class="w3-button w3-black" type="submit">
            <i class="fa fa-paper-plane"></i> SEND MESSAGE
          </button>
        </p>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-center w3-black w3-padding-64">
    <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the
      top</a>
    <div class="w3-xlarge w3-section">
      <i class="fa fa-facebook-official w3-hover-opacity"></i>
      <i class="fa fa-instagram w3-hover-opacity"></i>
      <i class="fa fa-snapchat w3-hover-opacity"></i>
      <i class="fa fa-pinterest-p w3-hover-opacity"></i>
      <i class="fa fa-twitter w3-hover-opacity"></i>
      <i class="fa fa-linkedin w3-hover-opacity"></i>
    </div>
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank"
        class="w3-hover-text-green">w3.css</a></p>
  </footer>

  <!-- Sign in Section-->
  <div name="sign-in" id="sign-in" class="w3-modal modal">
    <!-- Modal Content -->
    <form name="signin" id="signin" class="w3-modal-content w3-animate-opacity modal-content"
      action="scripts/sign-in.php" method="post" autocomplete="off">
      <div class="w3-container">
        <span onclick="document.getElementById('sign-in').style.display='none'" class="modal-close"
          title="Close Modal">&times;</span>
      </div>

      <div class="modal-logo">
        <i class="fa fa-user w3-margin-bottom w3-center extra-large"></i>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="uid"><b>User ID</b></label><br>
        <input class="modal-input" type="text" placeholder="Enter Username" id="uid" name="uid" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="password"><b>Password</b></label><br>
        <input class="modal-input" type="password" placeholder="Enter Password" id="password" name="password"
          required><br>
      </div>

      <div class="w3-container modal-container">
        <button class="w3-button modal-button" type="submit">Login</button>
        <div class="w3-half">
          <label><input type="checkbox" checked="checked" id="remember" name="remember"> Remember
            me</label>
        </div>

        <div class="w3-half" style="text-align: right">
          <span class="password">Forgot <a href="#">password?</a></span>
        </div>
      </div>

      <div class="w3-container modal-container-last">
        <span>Don't have an account? <a href="#"
            onclick="document.getElementById('sign-in').style.display='none'; document.getElementById('sign-up').style.display='block'"
            class="modal-hypertext">Sign Up</a></span>
      </div>
    </form>
  </div>

  <!-- Sign up Section-->
  <div id="sign-up" name="sign-up" class="w3-modal modal">
    <!-- Modal Content -->
    <form id="signup" name="signup" class="w3-modal-content w3-animate-opacity modal-content"
      action="scripts/sign-up.php" method="post" autocomplete="off">
      <div class="w3-container">
        <span
          onclick="document.getElementById('sign-up').style.display='none'; document.getElementById('sign-in').style.display='block'"
          class="modal-back" title="Back Modal">&#x25c0;</span>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="uid"><b>User ID</b></label><br>
        <input class="modal-input" type="text" placeholder="Enter Your User ID" name="uid" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="password"><b>Password</b></label><br>
        <input class="modal-input" type="password" placeholder="Enter Your Password" name="password" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="username"><b>Nick Name</b></label><br>
        <input class="modal-input" type="text" placeholder="Enter your Nick Name" name="username" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="email"><b>E-mail</b></label><br>
        <input class="modal-input" type="email" placeholder="Enter Your E-mail" name="email" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="gender"><b>Gender</b></label><br>
        <select class="modal-input" type="select" name="gender" required>
          <option disabled selected value> -- select an option -- </option>
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">other</option>
        </select>
        <br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="birthday"><b>Birthday</b></label><br>
        <input class="modal-input" type="date" name="birthday" required><br>
      </div>


      <div class="w3-container modal-container">
        <button class="w3-button modal-button" type="submit">Sign Up</button>
      </div>

      <div class="w3-container modal-container-last">
        <span class="psw">Already have an account? <a href="#"
            onclick="document.getElementById('sign-up').style.display='none'; document.getElementById('sign-in').style.display='block'"
            class="modal-hypertext">Login here</a></span>
      </div>

    </form>
  </div>

  <!-- Profile Section-->
  <div id="profile" name="profile" class="w3-modal modal">
    <!-- Modal Content -->
    <form id="profileUpdate" name="profileUpdate" class="w3-modal-content w3-animate-opacity modal-content"
      action="scripts/update.php" method="post" autocomplete="off">
      <div class="w3-container">
        <span
          onclick="document.getElementById('profile').style.display='none';"
          class="modal-back" title="Back Modal">&times;</span>
      </div>

      <div class="w3-container modal-container modal-container-last">
        <label class="modal-label" for="uid"><b>User ID: <u><?php echo $_SESSION['uid'] ?></u></b></label><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="password"><b>Password</b></label><br>
        <input class="modal-input" type="password" placeholder="Enter Your New Password" name="password" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="username"><b>Nick Name</b></label><br>
        <input class="modal-input" type="text" placeholder="Enter your New Nick Name" name="username" required><br>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="email"><b>E-mail</b></label><br>
        <input class="modal-input" type="email" placeholder="Enter Your New E-mail" name="email" required><br>
      </div>

      <div class="w3-container modal-container">
      <?php if ((!empty($_SESSION['uid'])) && ($_SESSION['uid'] == 'admin')): ?>
        <button disabled class="w3-button modal-button" type="submit">Change</button><br>
      <?php else: ?>
        <button enabled class="w3-button modal-button" type="submit">Change</button><br>
      <?php endif; ?>
      </div>
      
      <div class="w3-container modal-container">
        <button onclick="signout();" style="background-color: red;" class="w3-button modal-button" type="submit">LOG OUT</button>
      </div>

      <div class="w3-container modal-container"></div>
    </form>
  </div>

  <!-- Add Section-->
  <div id="add" name="add" class="w3-modal modal">
    <!-- Modal Content -->
    <form id="addforum" name="addforum" class="w3-modal-content w3-animate-opacity forum-modal-content"
      action="scripts/add-forum.php" method="post" autocomplete="off">
      <div class="w3-container">
        <span onclick="document.getElementById('add').style.display='none';" class="modal-back"
          title="Back Modal">&times;</span>
      </div>

      <div class="w3-container modal-container">
        <label class="modal-label" for="topic"><b>Topic</b></label><br>
        <input class="modal-input" type="text" placeholder="Enter Your Lost Item" name="topic" required><br>
      </div>

      <div class="w3-container modal-container-forum">
        <label class="modal-label " for="description"><b>Description</b></label><br>
        <textarea class="forum-modal-input" rows="6"
          placeholder="Describe on something that can help on finding your lost item" name="description"
          required></textarea><br>
      </div>

      <div class="w3-container modal-container-last">
        <button class="w3-button modal-button" type="submit" style="margin-bottom: 20px">Submit</button>
      </div>

    </form>
  </div>

  <!-- Show Section-->
  <div id="show" name="show" class="w3-modal modal">
    <!-- Modal Content -->
    <form id="fulforum" name="fulforum" class="w3-modal-content w3-animate-opacity forum-modal-content"
      action="scripts/ful-forum.php" method="post" autocomplete="off">
      <div class="w3-container">
        <span onclick="document.getElementById('show').style.display='none';" class="modal-back"
          title="Back Modal">&times;</span>
      </div>

      <div id="forum-detail" name="forum-detail" class="w3-container modal-container">
      </div>

    </form>
  </div>

  <script>

    $(function () {
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("forum-content").innerHTML = this.responseText;
        }
      }
      xhttp.open("GET", "scripts/get-forum.php");
      xhttp.send();
    });


    function myforum() {
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("forum-content").innerHTML = this.responseText;
        }
      }
      xhttp.open("GET", "scripts/my-forum.php");
      xhttp.send();
    }

    function defaultforum() {
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("forum-content").innerHTML = this.responseText;
        }
      }
      xhttp.open("GET", "scripts/get-forum.php");
      xhttp.send();
    }

    function seperateforum() {
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("forum-content").innerHTML = this.responseText;
        }
      }
      xhttp.open("GET", "scripts/seperate-forum.php");
      xhttp.send();
    }

    $("#signin").submit(function (event) {

      event.preventDefault();
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea, checkbox");
      var serializedData = $form.serialize();
      $inputs.prop("disabled", true);

      // Fire off the request
      request = $.ajax({
        url: "scripts/sign-in.php",
        type: "post",
        data: serializedData
      });

      request.done(function (response) {
        if (response == '"Success"') {
          window.location.reload();
        }
        else {
          window.alert(response);
        }
      });

      request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
      });

    });

    $("#signup").submit(function (event) {

      event.preventDefault();
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea, checkbox");
      var serializedData = $form.serialize();
      $inputs.prop("disabled", true);

      // Fire off the request
      request = $.ajax({
        url: "scripts/sign-up.php",
        type: "post",
        data: serializedData
      });

      request.done(function (response) {
        if (response == '"You have successfully registered, you can now login!"') {
          window.location.reload();
        }
        window.alert(response);
      });

      request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
      });

    });

    $("#profileUpdate").submit(function (event) {

      event.preventDefault();
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea, checkbox");
      var serializedData = $form.serialize();
      $inputs.prop("disabled", true);

      // Fire off the request
      request = $.ajax({
        url: "scripts/update.php",
        type: "post",
        data: serializedData
      });

      request.done(function (response) {
        if (response == '"You have successfully registered, you can now login!"') {
          window.location.reload();
        }
        window.alert(response);
      });

      request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
      });

    });


    function signout() {
      document.cookie = "uid=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      document.cookie = "password=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      window.location.reload();
    }

    $("#addforum").submit(function (event) {

      event.preventDefault();
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea, checkbox");
      var serializedData = $form.serialize();
      $inputs.prop("disabled", true);

      // Fire off the request
      request = $.ajax({
        url: "scripts/add-forum.php",
        type: "post",
        data: serializedData
      });

      request.done(function (response) {
        if (response == '"Upload Success, please wait patiently"') {
          window.location.reload();
        }
        window.alert(response);
      });

      request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
      });

    });

    $("#fulforum").submit(function (event) {

      event.preventDefault();
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea, checkbox");
      var serializedData = $form.serialize();
      $inputs.prop("disabled", true);

      // Fire off the request
      request = $.ajax({
        url: "scripts/ful-forum.php",
        type: "post",
        data: serializedData
      });

      request.done(function (response) {
        if (response == '"Record updated successfully"') {
          window.location.reload();
        }
        window.alert(response);
      });

      request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
      });

    });

    // Toggle between showing and hiding the sidebar when clicking the menu icon
    var mySidebar = document.getElementById("mySidebar");

    function w3_open() {
      if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
      } else {
        mySidebar.style.display = 'block';
      }
    }

    // Close the sidebar with the close button
    function w3_close() {
      mySidebar.style.display = "none";
    }

    // Get the modal
    var modals = ['sign-in', 'sign-up', 'add', 'show'];

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
      modals.forEach(modal => {
        if (event.target == document.getElementById(modal)) {
          document.getElementById(modal).style.display = "none";
        }
      });
    }

    function detail(id) {
      document.getElementById('show').style.display = 'block';
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function () {
        document.getElementById("forum-detail").innerHTML = this.responseText;
      }
      xhttp.open("GET", "scripts/get-detail.php?q=" + id);
      xhttp.send();
    }

    function del(id) {
      if (confirm('Are you sure you want to delete this record?')) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
        }
        xhttp.open("GET", "scripts/delete.php?q=" + id);
        xhttp.send();
      }
      window.location.reload();
    }

    $("#search").submit(function (event) {

      event.preventDefault();
      var $inp = document.getElementById('inp').value;
      const xhttp = equest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("forum-content").innerHTML = this.responseText;
        }
      }
      xhttp.open("GET", "scripts/search.php?q=" + $inp);
      xhttp.send();
    });
  </script>

</body>

</html>
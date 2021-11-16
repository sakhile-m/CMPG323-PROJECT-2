<?php

include 'functions.php';


session_start();

$db = mysqli_connect('localhost', 'root', 'C4!uh>oL7', 'photogallerydb');

if ( isset($_POST['uname']) && isset($_GET['userid'])) {
     
  // Data sanitization to prevent SQL injection
  $email = mysqli_real_escape_string($db, $_POST['uname']);
  $password = mysqli_real_escape_string($db, $_POST['psw']);

  // Error message if the input field is left blank
  if (empty($email)) {
      array_push($errors, "Username is required");
  }
  if (empty($password)) {
      array_push($errors, "Password is required");
  }

  // Checking for the errors
  if (count($errors) == 0) {
       
      // Password matching
      //$password = md5($password);
       
      $query = "SELECT * FROM users WHERE username=
              '$email' AND password='$password'";
      $results = mysqli_query($db, $query);

      // $results = 1 means that one user with the
      // entered username exists
      if (mysqli_num_rows($results) == 1) {
           
          // Storing username in session variable
          $_SESSION['email'] = $email;
          $_SESSION['userid'] = $row['userid'];
           
          // Welcome message
          $_SESSION['success'] = "You have logged in!";
           
          // Page on which the user is sent
          // to after logging in
          header('Location: http://localhost/photoplatform/index.php');
      }
      else {
           
          // If the username and password doesn't match
          array_push($errors, "Email or password incorrect");
      }
  }
}

// $pdo = pdo_connect_mysql();
// // Query checks if the email and password are present in the database.
// $stmt = $pdo->prepare("SELECT `id`, `email`, `password` FROM `users` WHERE `email` = ? AND `password` = ?");
// $stmt->execute(['s', $_POST['email'], md5($_POST['password'])]);


// // If the email and password are not present in the database, the mysqli_num_rows returns 0, it is assigned to $num.
// if ($result->num_rows === 0) {
//     $error = "<span class='red'>Please enter correct E-mail id and Password</span>";
//     header('location: login.php?error=' . $error);
// } else {
//     $row = $result->fetch_assoc();
//     $_SESSION['email'] = $row['email'];
//     $_SESSION['userid'] = $row['userid'];
//     header('location: index.php');
// }


// $error = '';
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
//     $email = trim($_POST['email']);
//     $password =  trim($_POST['password']);
   
   
//     if (empty($email)){
//         $error .= '<p class="error">Please enter email.</p>';
//     } 

//     if (empty($password)){
//         $error .= '<p class="error">Please enter your password.</p>';
//     } 
//     if (empty($error)) {
//         if($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
//             $query->bind_param('s', $email);
//             $query->execute();
//             $row = $query-> fetch();
//             if ($row){
//                 if (password_verify($password, $row['password'])){
//                     $_SESSION["userid"] = $row['id'];
//                     $_SESSION["user"] = $row;
//                     header("location: index.php");
//                     exit;
//                 } else {
//                     $error.= '<p class="error">The password is not valid.</p>';
//                 } }else {
//                     $error.= '<p class="error">No User exist with that email address.</p>';
//                 }
//             }
//         }
    
//     $query->close();
//     }

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>

<h2>Login Form</h2>

<form action="/index.php" method="post">
  <div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn"onclick="goBack()">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
  <script>
    function goBack() {
      window.history.back();
    }
    </script>
</form>

</body>
</html>

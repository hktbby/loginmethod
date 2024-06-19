<?php
require_once('classes/database.php');
$con=new database();
session_start();
if (isset($_SESSION['username'])) {
  header('location:index.php');
  }

  if (isset($_POST['login'])) {
    $username = $_POST['Username'];
    $password = $_POST['Pass_word'];
    $result = $con->check($username, $password);
  
    if ($result) {
        $_SESSION['username'] = $result['Username'];
        header('location:index.php');
    } else {
        $error = "Incorrect username or password. Please try again.";
    }


if ($result) { 
        $_SESSION['username'] = $result['Username'];
        $_SESSION['UserID'] =$result['UserID'];
       if($result['account_type']== 0){
        header('location:index.php');
       } else if($result['acount_type']== 1){
        header('location:user_account.php');
       } else{
          $error = '';
      }
       }
      }
       ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      height: auto;
      padding: 20px;
    }
  </style>
</head>
<body>


<div class="container-fluid login-container rounded shadow">
  <h2 class="text-center mb-4">Login</h2>


<form method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" name="Username" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" name="Pass_word" placeholder="Enter password">
    </div>

    <div class="container"><div class="row gx 1"><div class="col"><input type="submit" name="login" class="btn btn-warning btn-block" value="Login"></input></div>
    <div class="col"><a class="btn btn-danger btn-block" href=signup.php>Sign Up</a></div></div></div>

  </form>
</div>




 

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>

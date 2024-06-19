<?php
require_once('classes/database.php');
$con = new database();
$error_message = '';
 
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $sex = $_POST['sex'];
 
    if (!empty($username) && !empty($password) && !empty($confirmpassword) && !empty($firstname) && !empty($lastname) && !empty($birthday) && !empty($sex)) {
        if ($password == $confirmpassword) {
            if($con->signup($username, $password, $firstname, $lastname, $birthday, $sex)) {
                header('location:login.php');
                exit();
            } else {
                $error_message = "Username already exists. Please choose a different username.";
            }
        } else {
            $error_message = "Password did not match.";
        }
    } else {
        $error_message = "Please fill all fields.";
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Page</title>
 
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" >
  <style>
    .signup-container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      height: auto;
      padding: 20px;
    }
  </style>
</head>
<body>
 
<div class="container-fluid signup-container rounded shadow">
  <h2 class="text-center mb-4">Sign Up</h2>
 
  <form method="post">
    <div class="form-group">
      <label for="firstname">First Name:</label>
      <input type="text" class="form-control" required name="firstname" placeholder="Enter First Name">
    </div>
    <div class="form-group">
      <label for="lastname">Last Name:</label>
      <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name">
    </div>
    <div class="form-group">
      <label for="birthday" class="form-label">Birthday:</label>
      <input type="date" class="form-control" name="birthday">
 
      <div class="form-group">
      <label for="sex" class="form-label">Sex:</label>
      <select class="form-select" name="sex">
        <option selected disabled>Select Sex</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
    </div>
    </div>
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" name="username" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" name="password" placeholder="Enter password">
    </div>
   
    <div class="form-group">
      <label for="confirmpassword">Confirm Password:</label>
      <input type="password" class="form-control" name="confirmpassword" placeholder="Enter password">
    </div>
    <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <input type="submit" name="signup" class="btn btn-danger btn-block" value="Sign Up">
  </form>
</div>
 
<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
 
</body>
</html>
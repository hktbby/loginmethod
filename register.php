<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:login.php');
    exit();
}
require_once('classes/database.php');
$con = new database();
$error = "";

if (isset($_POST['multisave'])) {
    // Getting the account information
    $TenantFN = $_POST['Tfirstname'];
    $TenantLN = $_POST['Tlastname'];
    $sex = $_POST['sex'];
    $Number = $_POST['number'];

    // Getting the address information
    $Floor = $_POST['floor'];
    $Room = $_POST['room'];
    $numbedrooms = $_POST['numbedroom'];
    $rentamount = $_POST['rentamount'];

    // Handle file upload
    $target_dir = "uploads/";
    $original_file_name = basename($_FILES["profile_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    $new_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . '_' . time() . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;
    $uploadOk = 1;

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if everything is ok
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture_path = $target_file;

            // Save the user data and the path to the profile picture in the database
            $userID = $con->signupUser($TenantFN, $TenantLN, $sex, $Number, $profile_picture_path);

            if ($userID) {
                // Signup successful, insert address into users_address table
                if ($con->insertAddress($userID, $Floor, $Room, $numbedrooms, $rentamount)) {
                    // Address insertion successful, redirect to index page
                    header('location:index.php');
                    exit();
                } else {
                    $error = "Error occurred while inserting address. Please try again.";
                }
            } else {
                $error = "Sorry, there was an error signing up.";
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <title>Multi-Step Form</title>
    <style>
        .form-step {
            display: none;
        }
        .form-step-active {
            display: block;
        }
    </style>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="container custom-container rounded-3 shadow my-5 p-3 px-5">
    <h3 class="text-center mt-4">Registration Form For Tenant</h3>
    <form id="registration-form" method="post" action="" enctype="multipart/form-data" novalidate>
        <!-- Step 1 -->
        <div class="form-step form-step-active" id="step-1">
            <div class="card mt-4">
                <div class="card-header bg-info text-white">Tenant Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="Tfirstname">First Name:</label>
                        <input type="text" class="form-control" name="Tfirstname" id="Tfirstname" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter a valid first name.</div>
                    </div>
                    <div class="form-group">
                        <label for="Tlastname">Last Name:</label>
                        <input type="text" class="form-control" name="Tlastname" id="Tlastname" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter a valid last name.</div>
                    </div>
                    <div class="form-group">
                        <label for="sex">Sex:</label>
                        <select class="form-control" name="sex" id="sex" required>
                            <option selected disabled value="">Select Sex</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select a sex.</div>
                    </div>
                    <div class="form-group">
                        <label for="number">Phone Number:</label>
                        <input type="tel" class="form-control" name="number" id="number" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter a valid phone number.</div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mt-3" onclick="nextStep()">Next</button>
        </div>
        
        <!-- Step 2 -->
        <div class="form-step" id="step-2">
            <div class="card mt-4">
                <div class="card-header bg-info text-white">Address Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="floor">Floor:</label>
                        <input type="text" class="form-control" name="floor" id="floor" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter the floor number.</div>
                    </div>
                    <div class="form-group">
                        <label for="room">Room Number:</label>
                        <input type="text" class="form-control" name="room" id="room" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter the room number.</div>
                    </div>
                    <div class="form-group">
                        <label for="numbedroom">Number of Bedrooms:</label>
                        <input type="number" class="form-control" name="numbedroom" id="numbedroom" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter the number of bedrooms.</div>
                    </div>
                    <div class="form-group">
                        <label for="rentamount">Rent Amount:</label>
                        <input type="number" class="form-control" name="rentamount" id="rentamount" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter the rent amount.</div>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please upload a profile picture.</div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-3" onclick="prevStep()">Previous</button>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </div>
    </form>
</div>

<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function () {
    $("#registration-form").on('submit', function (event) {
        event.preventDefault();
        // Form validation logic
        var form = this;
        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            form.submit();
        }
        form.classList.add('was-validated');
    });
});

function nextStep() {
    // Simple client-side validation
    var currentStep = $(".form-step-active");
    if (currentStep.find("input:invalid").length > 0) {
        currentStep.find("input:invalid").first().focus();
        return;
    }
    currentStep.removeClass("form-step-active").next().addClass("form-step-active");
}

function prevStep() {
    $(".form-step-active").removeClass("form-step-active").prev().addClass("form-step-active");
}
</script>
</body>
</html>

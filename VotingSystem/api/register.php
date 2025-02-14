<?php

include("connect.php");  // Connect with the database

// Check if all required fields are set and not empty
if (empty($_POST['name']) || empty($_POST['mobile']) || empty($_POST['password']) || 
    empty($_POST['cpassword']) || empty($_POST['age']) || empty($_POST['dob']) || 
    empty($_POST['address']) || empty($_POST['role']) || empty($_FILES['photo']['name'])) {

    echo '
    <script>
        alert("All fields are required! Please fill all details.");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Retrieve form data
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$age = $_POST['age'];  
$dob = $_POST['dob'];  
$address = $_POST['address'];
$image = $_FILES['photo']['name'];
$temp_name = $_FILES['photo']['tmp_name'];
$role = $_POST['role'];

// Password match validation
if ($password !== $cpassword) {
    echo '
    <script>
        alert("Password and Confirm Password do not match!");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Validate the format of the date (dd-mm-yyyy)
$dob_date = DateTime::createFromFormat('d-m-Y', $dob);
$errors = DateTime::getLastErrors();
if ($errors['warning_count'] > 0 || $dob_date === false) {
    echo '
    <script>
        alert("Invalid Date of Birth! Please enter a valid date.");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Calculate the age based on Date of Birth
$current_date = new DateTime();
$age_interval = $dob_date->diff($current_date);
$calculated_age = $age_interval->y;  

// Compare manually entered age with calculated age from DOB
if ($age != $calculated_age) {
    echo '
    <script>
        alert("The age you entered (' . $age . ') does not match your Date of Birth (' . $calculated_age . '). Please enter a valid age.");
        window.location="../routes/register.html";
    </script>
    ';
    exit;
}

// Check if the user is eligible (18 years or older)
if ($calculated_age < 18) {
    echo '
    <script>
        alert("You are not eligible for voting as you are under 18!");
        window.location="../home.html";
    </script>
    ';
    exit;
}

// Move the uploaded image to the designated folder
move_uploaded_file($temp_name, "../uploads/$image");

// Insert the user into the database
$insert = mysqli_query($connect, "INSERT INTO user(name, mobile, address, password, dob, photo, role, status, votes) 
                                    VALUES ('$name', '$mobile', '$address', '$password', '$dob', '$image', '$role', 0, 0)");

// Check if the insertion is successful
if ($insert) {
    echo '
    <script>
        alert("Registration Successful!");
        window.location="../login.html";
    </script>
    ';
} else {
    echo '
    <script>
        alert("Some error occurred during registration!");
        window.location="../routes/register.html";
    </script>
    ';
}

?>

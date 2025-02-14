<?php
session_start(); // Enables session variables

include("connect.php");

$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

// Get data from database
$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role='$role'");

// Check if user exists
if (mysqli_num_rows($check) > 0) {
    $userdata = mysqli_fetch_array($check); // Fetch single user data
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2"); // Fetch groups
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC); // Fetch all groups as associative array

    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;

    echo '
    <script>
        window.location = "../routes/dashboard.php";
    </script>
    ';
} else {
    echo '
    <script>
        alert("Invalid Credentials or user not found!");
        window.location = "../";
    </script>
    ';
}
?>

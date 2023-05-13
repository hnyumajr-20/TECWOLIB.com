<?php
$username = $_POST['username'];
$fullname1 = $_POST['fullname1'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordconfrim = $_POST['passwordconfrim'];

if (!empty($username) && !empty($fullname1) && !empty($email) && !empty($password) && !empty($passwordconfrim)) {
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        die();
    }
    
    // Check if passwords match
    if ($password != $passwordconfrim) {
        echo "Passwords do not match";
        die();
    }
    
    // All input is valid, insert into database
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "BrighterDay";

    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('connect Error ('. mysqli_connect_errno() .')' .  mysqli_connect_error());
    } else {
        $SELECT = "SELECT Email FROM Backend WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO Backend (username, fullname1, email, password) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $username, $fullname1, $email, $password);
            $stmt->execute();
            echo 
                            "SignUp was successful<br />Please check your email for more details";
        } else {
            echo "Someone already registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
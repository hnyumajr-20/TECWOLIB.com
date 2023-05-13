<?php

$username = $_POST['username'];
$fullname1  = $_POST['fullname1'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordconfrim = $_POST['passwordconfrim'];




if (!empty($username) || !empty($fullname1) || !empty($email) || !empty(password) || !empty(passwordconfrim) )
{

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "BrighterDay";




    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()){
  die('connect Error ('.
    mysqli_connect_errno() .')'
    .  mysqli_connect_error());
}



else{
  $SELECT = "SELECT Email From Datamag Where Email = ? Limit 1";
  $INSERT = "INSERT Into Datamag(username, fullname1, email, password ) values(?,?,?,?)";




     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $Email);
     $stmt->execute();
     $stmt->bind_result($Email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;



       if ($rnum==0) {
       $stmt->close();
       $stmt = $conn->prepare($INSERT);
       $stmt->bind_param("ssss", $username,$fullname1,$email,$password);
       $stmt->execute();
       echo "SingUp was sucessfull<br />Please Check you email for more details";

      } else {
       echo "Someone already register using this email";
      }
      $stmt->close();
      $conn->close();
    } 
} else  {
 echo "All field are required";
 die();
}
?>

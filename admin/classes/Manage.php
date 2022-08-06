<?php
include 'Database.php';


$HostName="localhost";
$HostUser="root";
$HostPass="";
$DatabaseName="store";
$db = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

if (isset($_POST['Save'])) {
 $password = $_POST['password'];
 $email =  $_POST['email'];
if (empty($email) || empty($password)) {
    echoData('Fill all fields');
} else {
    checkUserExsit();
}
}

// Check User is New Or Already Registered
function checkUserExsit()
{
    global $db;
    global $email;
    global $fullname;

    $userQuery = "SELECT * FROM user WHERE username ='$email'";
    $sendingQuery = mysqli_query($db, $userQuery);
    $checkQuery = mysqli_num_rows($sendingQuery);

    if ($checkQuery == 1) {
        // if Username is already registered
        tryLogin();
    } else {
            trySignup();
        }

    }
function tryLogin()
{
    global $db;
    global $email;
    global $password;

    $sql = "SELECT * FROM userData where username = '$email'";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {

        while ($row[] = $result->fetch_assoc()) {

            $tem = $row;
        }

        $dbPWD = $tem[0]['password'];

        if (password_verify($password, $dbPWD)) {
            echoData("Login Success");
        } else {
            echoData("Wrong Password");
        }

    } else {
        echoData("No User Found");
    }
}

function trySignup()
{
    global $db;
    global $email;
    global $password;
    global $fullname;
    global $phonenumber;
    global $address;

    $hashPwd = password_hash($password, PASSWORD_DEFAULT);

    $insert = "INSERT INTO userData (fullname,email,password,phonenumber,address)VALUES('$fullname','$email','$hashPwd','$phonenumber','$address')";
    $query = mysqli_query($db, $insert);

    if ($query) {
        echoData("Account Created");
    } else {
        echoData("Getting Error");
    }
}

function echoData($result)
{
    echo json_encode($result);
}

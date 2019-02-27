<?php

// get database connection
include_once '../config/database.php';

// instantiate user object
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

//if (isset($_POST['submit'])) {
// set user property values
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->created = date('Y-m-d H:i:s');

// create the user
    if ($user->signup()) {
        $user_arr = array(
            "status" => true,
            "message" => "Successfully Signup!",
            "id" => $user->id,
            "username" => $user->username
        );
    } else {
        $user_arr = array(
            "status" => false,
            "message" => "Username already exists!"
        );
    }
    echo json_encode($user_arr);

//}

?>


<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <title>Document</title>-->
<!--</head>-->
<!--<body>-->
<!--    <form action="signup.php" method="post">-->
<!--        <input type="text" name="username" id="username" > <br>-->
<!--        <input type="text" name="password" id="password" > <br><br>-->
<!--        <input type="submit" name="submit" id="submit" > <br>-->
<!---->
<!--    </form>-->
<!--</body>-->
<!--</html>-->
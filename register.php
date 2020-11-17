<?php
if(
    !empty($_POST['userName'])
    && !empty($_POST['pass'])
){
    require_once("sec/words.inc.php");
    require_once("bus/WebUser.php");

    $userName = $_POST['userName'];

    $loginUser = WebUser::userExists($userName);
    if($loginUser == NULL)
    {
        $pass = $_POST['pass'];
        $pass = md5($pass);
        $privateSalt = newUserSalt();
        $userTokenBase = newUserSalt();
        $userToken = uniqid($userTokenBase);
        $newUser = new WebUser($userName, $pass, $privateSalt, $userToken);
        $id = $newUser->save();
        if($id)
        {
            echo "User " . $userName . " Registered";
            ?><br /><a href="login.html">Login</a><?php
        }
        else echo "Error - The user name didn't register";
    }
    else echo "Error - User " . $userName . " Already exists!";
}
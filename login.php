<?php
if(
    !empty($_POST['userName'])
    && !empty($_POST['pass'])
){
    require_once("bus/WebUser.php");

    $userName = $_POST['userName'];

    $loginUser = WebUser::userExists($userName);
    if($loginUser != NULL) // the user exists and has a db id
    {
        $pass = $_POST['pass'];
        $pass = md5($pass);
        $loginUser->setPass($pass);
        $loginUser = $loginUser->login();
        if($loginUser)
        {
            $loginUser->setPass("login");
            $loginUser->setPrivateSalt("login");
            session_start();
            $_SESSION['loginUser'] = serialize($loginUser);
//            $_SESSION['webUserID'] = $loginUser->getUserID();
//            $_SESSION['userName'] = $loginUser->getUserName();
//            $_SESSION['token'] = $loginUser->getToken();
            header("Location:index.php");
        }
        else echo "Error - User " . $userName . " doesn't exist or password is incorrect!";

    }
    else echo "Error - User " . $userName . " doesn't exist or password is incorrect!";
}
else
    header("Location:login.html");

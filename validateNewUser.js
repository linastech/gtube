

    function validateNewUser()
    {
        var userName = document.getElementById("userName").value;
        var pass = document.getElementById("pass").value;
        var passAgain = document.getElementById("passAgain").value;
        var errorMsg = document.getElementById("errorMsg");
        errorMsg.innerHTML = "";

        if(userName.length < 3)
        {
            errorMsg.innerHTML = "<h4>Usernames should be more than 3 characters!</h4>";
            return false;
        }
        else if(pass != passAgain)
        {
            errorMsg.innerHTML = "<h4>Passwords do not match!</h4>";
            return false;
        }
        else if(pass.length < 8)
        {
            errorMsg.innerHTML = "<h4>Passwords should be 8 or more characters.</h4>";
            return false;
        }
        /*
            additional regex validation for uppercase letter, and a number
         */

        return true;
    }
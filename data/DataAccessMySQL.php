<?php
require_once("aDataAccess.php");

class DataAccessMySQL extends aDataAccess
{
    private $dbConnection;
    private $result;

    public function connectToDB()
    {
        $this->dbConnection = @new mysqli("localhost", "webuser", "webuser", "gtube");
        if(!$this->dbConnection)
        {
            die("Could not connect to the MySQL Database " . $this->dbConnection->errno);
        }
    }

    public function closeDB()
    {
        $this->dbConnection->close();
    }

    public function fetchArray()
    {
        if($this->result == NULL)
            die("No results to display");
        return $this->result->fetch_array();
    }

    public function getResult()
    {
        if($this->result != NULL)
        return $this->result->fetch_array();
        else return false;
    }

    //WEB USERS

    public function selectByUserName($userName)
    {
        $userName = $this->sanitize($userName);
        $queryString = "
        SELECT
        webUserID
        , userName
        , privateSalt
        , token
        FROM gtube.webusers
        WHERE userName = '$userName'
        ORDER BY webUserID
        LIMIT 0,1;
        ";
        $this->result = $this->dbConnection->query($queryString);
    }

    public function login($userName, $pass, $privateSalt)
    {
        $salt = "";
        if(file_exists("./sec/sel"))
        {
            $salt = file_get_contents("./sec/sel"); //required file with master salt
        }

        $salt .= $privateSalt;
        $CRYPT_CMD = '$6$rounds=3472$' . $salt . '$';
        $finalHash = crypt($pass, $CRYPT_CMD);
        $finalHash = substr($finalHash, 30, strlen($finalHash) - 1);

        $userName = $this->sanitize($userName);

        $queryString = "
        SELECT
        webUserID
        , userName
        FROM gtube.webusers
        WHERE userName = '$userName'
        AND pass = '$finalHash';
        ";
        $this->result = $this->dbConnection->query($queryString);
    }

    public function insertWebUser($userName, $pass, $privateSalt, $token)
    {
        $salt = "";
        if(file_exists("./sec/sel"))
        {
            $salt = file_get_contents("./sec/sel"); //required file with master salt
        }

        $salt .= $privateSalt;
        $CRYPT_CMD = '$6$rounds=3472$' . $salt . '$';
        $finalHash = crypt($pass, $CRYPT_CMD);
        $finalHash = substr($finalHash, 30, strlen($finalHash) - 1);

        $userName = $this->sanitize($userName);

        $queryString = "INSERT
        INTO gtube.webusers(
        userName
        , pass
        , privateSalt
        , token
        )VALUES(
        '$userName'
        , '$finalHash'
        , '$privateSalt'
        , '$token'
        );
        ";
        $this->result = $this->dbConnection->query($queryString);

        if($this->result)
        {
            $queryString = "
            SELECT
            webUserID
            FROM gtube.webusers
            WHERE userName = '$userName';
            ";
            $this->result = $this->dbConnection->query($queryString);
            if($this->result)
            {
                $row = $this->result->fetch_array();
                return $row['webUserID'];
            }
            else return false;
        }
        else return false;
    }

    public function updateWebUser($webUserID, $userName, $pass)
    {
        // TODO: Implement updateWebUser() method.
    }

    public function fetchPrivateSalt($row)
    {
       return $row['privateSalt'];
    }

    public function fetchWebUserID($row)
    {
        return $row['webUserID'];
    }

    public function fetchToken($row)
    {
        return $row['token'];
    }

    // SANITIZER

    private function sanitize($rawString)
    {
        $rawString = stripslashes($rawString);
        $rawString = mysqli_real_escape_string($this->dbConnection, $rawString);
        return $rawString;
    }
}

<?php
require_once("DataAccessMySQL.php");
//require_once("DataAccessSQLServer.php");

abstract class aDataAccess
{
    private static $dataAccess;

    public static function getInstance()
    {
        if(self::$dataAccess == null)
        {
            self::$dataAccess = new DataAccessMySQL();
//            self::$dataAccess = new DataAccessSQLServer();
        }
        return self::$dataAccess;
    }

    public abstract function connectToDB();

    public abstract function closeDB();

    /*RETURN RESULT WITHOUT DYING*/
    public abstract function getResult();

    /*RETURN RESULT WITH DYING*/
    public abstract function fetchArray();

    //WEB USERS

    public abstract function selectByUserName($userName);

    public abstract function login($userName, $pass, $privateSalt);

    public abstract function insertWebUser($userName, $pass, $privateSalt, $token);

    public abstract function updateWebUser($webUserID, $userName, $pass);

    public abstract function fetchWebUserID($row);

    public abstract function fetchPrivateSalt($row);
}
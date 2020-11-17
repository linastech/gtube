<?php
require ("./bus/iWebUser.php");
require("./data/aDataAccess.php");

    class WebUser implements iWebUser
    {
        private $webUserID;
        private $userName;
        private $pass;
        private $privateSalt;
        private $token;

        public function __construct($userName, $userPass, $privateSalt, $userToken)
        {
            $this->userName = $userName;
            $this->pass = $userPass;
            $this->privateSalt = $privateSalt;
            $this->token = $userToken;
        }

        private function setUserID($newUserID)
        {
            $this->webUserID = $newUserID;
        }

        public function setPass($pass)
        {
            $this->pass = $pass;
        }

        private function getPass()
        {
            return $this->pass;
        }

        public function getUserID()
        {
            return $this->webUserID;
        }

        public function getUserName()
        {
            return $this->userName;
        }

        public function getToken()
        {
            return $this->token;
        }

        public function getPrivateSalt()
        {
            return $this->privateSalt;
        }

        public function setPrivateSalt($salt)
        {
            $this->privateSalt = $salt;
        }

        /***
         * @param $userName
         * @return null|WebUser
         * @see: /data/aDataAccess.php
         *
         * This is a function for registering AND logging in
         * If there is no user for aDataAccess->selectByUserName(@param: $userName)
         * return NULL and Create new user @see: /pres/resiger.php
         * else return them as WebUser
         */
        public static function userExists($userName)
        {
            $myData = aDataAccess::getInstance();
            $myData->connectToDB();
            $myData->selectByUserName($userName);

            $row = $myData->getResult();

            $myData->closeDB();
            if(!$row)
            {
                // create new user
                return NULL;
            }
            else //the user exists, select from db and return them
            {
                $webUserID = $myData->fetchWebUserID($row);
                $privateSalt = $myData->fetchPrivateSalt($row);
                $token = $myData->fetchToken($row);
                $loginUser = new self($userName, NULL, $privateSalt, $token);
                $loginUser->setUserID($webUserID);
                return $loginUser;
            }
        }

        public function login()
        {
            $myData = aDataAccess::getInstance();
            $myData->connectToDB();
            $myData->login($this->getUserName(), $this->getPass(), $this->getPrivateSalt());
            $row = $myData->getResult();

            $myData->closeDB();
            if($row)
            {
                $this->setUserID($myData->fetchWebUserID($row));
                return $this;
            }
        }

        /**
         * @return int|bool
         * If saving for the first time, returns the new row ID,
         * If updating, returns the number of rows
         * If error, returns false
         */
        public function save()
        {
            $myDataAccess = aDataAccess::getInstance();
            $myDataAccess->connectToDB();
            $result = NULL;
            $numRows = NULL;
            $newID = NULL;

            if($this->webUserID)
                // TODO: Implement updateWebUser() method.
                $numRows = $myDataAccess->updateWebUser($this->webUserID, $this->userName, $this->pass);
            else
                $newID =  $myDataAccess->insertWebUser($this->userName, $this->pass, $this->privateSalt, $this->token);

            $myDataAccess->closeDB();
            if(!empty($newID) && $newID != false)
            {
                $this->setUserID($newID);
                return $this->getUserID();
            }
            else if($newID == false)
            {
                return false;
            }
            return $numRows;

        }

        public function delete()
        {
            // TODO: Implement delete() method.
        }


    }
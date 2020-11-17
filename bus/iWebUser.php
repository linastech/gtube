<?php
interface iWebUser
{
    public static function userExists($userName);
    public function login();
    public function save();
}
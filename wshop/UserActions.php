<?php
    class UserActions{
        static function getAllUsers(){
            require "db.php";
            $query = "SELECT * FROM users WHERE username != 'admin'";
            $users = $database->query($query);
            if($users != false){
                return $users->fetch_all(MYSQLI_ASSOC);
            }
            else{
                return [];
            }
        }
        static function exists($username,$email){
            require "db.php";
            $query = "SELECT * FROM users WHERE username = '{$username}' OR email = '{$email}'";
            $results = $database->query($query);
            if($results->num_rows === 0){
                return false;
            }
            return true;
        }
    }
?>
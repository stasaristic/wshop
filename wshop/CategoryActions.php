<?php 
    class CategoryActions{
        static function getAllCategories(){
            require "db.php";
            $query = "SELECT DISTINCT category from products";
            $categories = $database->query($query);
            if($categories != false){
                $categories = $categories->fetch_all();
                return $categories;
            }
            return [];
        }
    }
?>
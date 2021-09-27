<?php 
    class ProductActions{
        static function getAverageRating($product_id){
            require "db.php";

            $query = "SELECT AVG(grade) as 'avg' FROM product_reviews WHERE product_id = $product_id";
            $result = $database->query($query);
            if($result != false){
                $rate = $result->fetch_assoc();
                return round($rate['avg']);
            }
            else{
                return 0;
            }
        }
        static function getAllProducts(){
            require "db.php";
            $query = "SELECT products.*, product_images.path FROM products INNER JOIN product_images on products.id = product_images.product_id  GROUP BY products.name";
            $products = $database->query($query);
            if($products != false){
                $products = $products->fetch_all(MYSQLI_ASSOC);
                return $products;
            }
            else{
                return [];
            }
        }
        static function getAllProductsFromSeller($username){
            require "db.php";
            $query = "SELECT products.*, product_images.path FROM products INNER JOIN product_images on products.id = product_images.product_id WHERE seller = '{$username}'  GROUP BY products.name";
            $products = $database->query($query);
            if ($products != false) {
                $products = $products->fetch_all(MYSQLI_ASSOC);
                return $products;
            } else {
                return [];
            }
        }
        static function getSearchedProducts($search_text){
            require "db.php";
            $query = "SELECT products.*, product_images.path from products INNER JOIN product_images on product_images.product_id = products.id WHERE name LIKE '%" . $search_text . "%' OR category LIKE '%" . $search_text . "%' GROUP BY products.name";
            $products = $database->query($query);
            if ($products != false) {
                $products = $products->fetch_all(MYSQLI_ASSOC);
                return $products;
            } else {
                return [];
            }
        }
        static function getSingleProductDetails($product_id){
            require "db.php";
            $query = "SELECT products.*, product_images.path FROM products INNER JOIN product_images where products.id = {$product_id} AND product_images.product_id = {$product_id} GROUP BY products.name";
            $product = $database->query($query);
            if($product != false){
                return $product->fetch_assoc();
            }
            return null;
        }
        static function getProductImages($product_id){
            require "db.php";
            $query = "SELECT path FROM product_images WHERE product_id = $product_id";
            $images = $database->query($query);
            if($images != false){
                return $images->fetch_all();
            }
            return [];
        }
        static function getReviewsForProduct($product_id,$username){
            require "db.php";
            if($username != null){
                $query = "SELECT * FROM product_reviews WHERE product_id = $product_id";
            }
            else{
                $query = "SELECT * FROM product_reviews WHERE product_id = $product_id";
            }
            $reviews = $database->query($query);
            if ($reviews != false) {
                $reviews = $reviews->fetch_all(MYSQLI_ASSOC);
            } else {
                $reviews = [];
            }
            return $reviews;
        }
        public static function canReview($product_id,$username){
            require "db.php";
            $query = "SELECT * FROM product_orders WHERE username = '{$username}' AND product_id = {$product_id} AND status = 1";
            $result = $database->query($query);
            if ($result != false) {
                return true;
            }
            return false;
        }
        public static function getUserReview($product_id,$username){
            require "db.php";
            $query = "SELECT * FROM product_reviews WHERE product_id = {$product_id} AND username = '{$username}'";
            $review = $database->query($query);
            if($review != false){
                return $review->fetch_assoc();
            }
            else{
                return null;
            }
        }
        static function getProductReviewByID($review_id){
            require "db.php";
            $query = "SELECT * FROM product_reviews WHERE id = $review_id";
            if($database->query($query) != false){
                return $database->query($query)->fetch_assoc();
            }
            else{
                return -1;
            }
        }
        static function removeReview($review_id){
            require "db.php";
            $query = "DELETE FROM product_reviews WHERE id = $review_id";
            if($database->query($query) === TRUE){
                return 1;
            }
            else{
                return -1;
            }
        }
    }
?>
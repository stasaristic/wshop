<?php 
    class SessionActions{
        public static function startSession(){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
        }
        public static function renderMessages(){
            echo "<div id = 'messages'>";
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Greska!</strong> '.$_SESSION['error'].'
                    </div>';
                    unset($_SESSION["error"]);
            }
            if (isset($_SESSION['message'])){
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Uspeh!</strong> '.$_SESSION['message'].'
                    </div>';
                unset($_SESSION["message"]);
            }    
            echo "</div>";
        }
        public static function addToCart($product_id){
            if (!array_key_exists($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][$product_id] = 1;
            } else {
                $_SESSION['cart'][$product_id]++;
            }
            return 1;
        }
        public static function removeFromCart($product_id)
        {
            $cart_products = array_keys($_SESSION['cart']);
            if(in_array($product_id,$cart_products)){
                unset($_SESSION['cart'][$product_id]);
                return 1;
            }
            return -1;
        }
        public static function emptyCart()
        {
            $_SESSION['cart'] = [];
            return 1;
        }
        public static function countCart(){
            $count = 0;
            foreach($_SESSION['cart'] as $key => $value){
                $count += $value;
            }
            return $count;
        }
    }
?>
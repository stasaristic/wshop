<?php 
    require "db.php";
    require "SessionActions.php";
    require "UserActions.php";
    SessionActions::startSession();

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        $type = $_POST['type'];
        $user_exists = UserActions::exists($username,$email);
        if(empty($fname)) {
            $_SESSION['error'] = "Ime korisnika je neophodno";
            header("location: register.php");
            return;
        }
        if(empty($lname)) {
            $_SESSION['error'] = "Prezime korisnika je neophodno";
            header("location: register.php");
            return;
        }
        if(empty($username)) {
            $_SESSION['error'] = "Username je neophodno uneti";
            header("location: register.php");
            return;
        }
        if(empty($email)) {
            $_SESSION['error'] = "Email je neophodno uneti";
            header("location: register.php");
            return;
        } 
        if($user_exists){
            $_SESSION['error'] = "Korisnik sa ovim korisnickim imenom ili email adresom vec postoji";
            header("location: register.php");
            return;
        }
        $query = "INSERT INTO users VALUES('{$username}','{$fname}','{$lname}','{$email}','{$password}','{$type}')";
        if($database->query($query) === TRUE){
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['type'] = $type;
            header("location: pocetna.php");
            return;
        }
    }
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $query = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
        $user = $database->query($query)->fetch_assoc();
        if($user == null){
            $_SESSION['error'] = "Greska pri prijavljivanju. Proverite ponovo korisnicko ime i/ili lozinku";
            header("location:login.php");
            return;
        }
        else{
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['type'] = $user['type'];
            if($user['type'] === "kupac"){
                header("location:pocetna.php");
                return;
            }
            if($user['type'] === "prodavac"){
                header("location:prodavac.php");
                return;
            }
            if($user['type'] === "admin"){
                header("location:admin.php");
                return;
            }
        }
    }
    if(isset($_POST['add_product'])){
        $product_name = $_POST["pname"];
        $price = $_POST['price'];
        $username = $_POST['username'];
        $description = $_POST['description'];
        $stock = $_POST['stock'];
        $category = $_POST['cat'];
        $category = strtolower($category);
        $query = "INSERT INTO products (name,price,category,seller,description,stock) VALUES ('${product_name}',{$price},'{$category}','{$username}','{$description}',{$stock})";
        $index = 0;
        if($database->query($query) === TRUE){
            //dodavanje fajlova u folder sa slikama
            $total = count($_FILES['images']['name']);
            $product_id = $database->insert_id;
            for($i=0; $i<$total; $i++) {
                $tmpFilePath = $_FILES['images']['tmp_name'][$i];
                
                if ($tmpFilePath != ""){
                    $newFilePath = "./media/" . $_FILES['images']['name'][$i];
                    $query = "INSERT INTO product_images VALUES({$product_id},'{$newFilePath}')";
                    if($database->query($query) != TRUE){
                        $_SESSION['error'] = "Greska prilikom cuvanja slike proizvoda u bazi podataka. Tekst greske: ".$database->error;
                        header("location:pocetna.php");
                        return;
                    }
                    else{
                        move_uploaded_file($tmpFilePath, $newFilePath);
                        $_SESSION['message'] = "Uspesno dodavanje proizvoda u bazu podataka";
                        header("location: pocetna.php");
                    }
                }
            }
        }
        else{
            $_SESSION['error'] = $database->error;
            header("location: pocetna.php");
            return;
        }
    }
    if(isset($_POST['edit_product'])){
        $product_name = $_POST["pname"];
        $price = $_POST['price'];
        $username = $_POST['username'];
        $product_id = $_POST['product_id'];
        $description = $_POST['description'];
        $stock = $_POST['stock'];

        $category;
        if ($_POST['cat'] == -1) {
            $category = $_POST['catManual'];
        } else {
            $category = $_POST['cat'];
        }
        $category = strtolower($category);

        $query = "UPDATE products SET name = '{$product_name}',price = '{$price}', category = '{$category}', description = '{$description}',stock = {$stock} WHERE id = {$product_id}";

        if($database->query($query) === TRUE){
            $_SESSION['message'] = "Uspesno izmenjen proizvod";
            header("location:pocetna.php");
            return;
        }
        else{
            $_SESSION['error'] = "Greska prilikom izmene proizvoda. Tekst greske: $database->error";
            header("location:pocetna.php");
            return;
        }
    }
    if(isset($_POST['process_order'])){
        $products = explode(",",$_POST['products']);
        $quantity = explode(",", $_POST['quantity']);

        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $zip_code = $_POST['zip_code'];
        $payment = $_POST['payment'];
        $username = $_POST['username'];
        if($payment == 1){
            $card_owner = $_POST['cown'];
            $cnumber = $_POST['cnum'];
            $cvc = $_POST['cvc'];
            $expiration = $_POST['cexp'];
            if(is_numeric($expiration[0]) && is_numeric($expiration[1]) && is_numeric($expiration[3]) && is_numeric($expiration[4]) && $expiration[2] == "/"){
                echo "Success";
            }
            else{
                $_SESSION['error'] = "Neispravan datum isteka kartice";
                header("location:placanje.php");
                return;
            }
            if(!is_numeric($cvc) || strlen($cvc) != 3){
                $_SESSION['error'] = "Neispravan CVC";
                header("location:placanje.php");
                return;
            }
        }
        foreach($products as $index => $product){
            $query = "INSERT INTO product_orders (product_id,username,first_name,last_name,country,city,address,zip_code,payment_option,quantity) VALUES({$product},'{$username}','{$first_name}','{$last_name}','{$country}','{$city}','{$address}','{$zip_code}',{$payment},{$quantity[$index]})";
            if($database->query($query) != TRUE){
                $_SESSION['error'] = "Greska prilikom kreiranja porudzbine. Tekst greske : {$database->error}";
                header("location:pocetna.php");
                return;
            }
        }
        $_SESSION['cart'] = [];
        $_SESSION['message'] = "Uspesno kreirana porudzbina";
        header("location: pocetna.php");
    }
    if(isset($_POST['disable_order'])){
        // var_dump($_POST);
        $product_id = $_POST['product_id'];
        $username = $_POST['username'];
        $order_date = $_POST['order_date'];
        $quantity = $_POST['quantity'];
        $query = "SELECT seller FROM products WHERE id = {$product_id}";
        $product = $database->query($query)->fetch_array(MYSQLI_ASSOC);
        // echo $order_date;
        // return;
        if ($product['seller'] != $_SESSION['user']['username']) {
            $_SESSION['error'] = "Samo vlasnik moze otkazati/odobriti porudzbinu na proizvod.";
            header("location:pocetna.php");
        } else {
            $prevStatus = 0;
            $query = "SELECT status FROM product_orders WHERE product_id = {$product_id} AND username = '{$username}' AND order_date = '{$order_date}'";
            $status = $database->query($query)->fetch_array();
            $prevStatus = $status[0];
            $query = "UPDATE product_orders SET status = -1 WHERE product_id = {$product_id} AND username = '{$username}' AND order_date = '{$order_date}'";
            if ($database->query($query) === TRUE) {
                if($prevStatus == 1){
                    $query = "UPDATE products SET stock = stock + {$quantity} WHERE id = {$product_id}";
                    if($database->query($query) === TRUE){
                        $_SESSION['message'] = "Uspesno odbijena porudzbina";
                        header("location: porudzbine.php");
                        return;
                    }
                    else{
                        $_SESSION['error'] = "Greska prilikom izmene stanja proizvoda. Tekst greske: {$database->error}";
                        header("location: porudzbine.php");
                        return;
                    }
                }
                else{
                $_SESSION['message'] = "Uspesno odbijena porudzbina";
                header("location: porudzbine.php");
                return;
                }
            } else {
                $_SESSION['error'] = "Greska prilikom odobravanja porudzbine. Tekst greske: {$database->error}";
                header("location:porudzbine.php");
                return;
            }
        }
    }
    if(isset($_POST['allow_order'])){
        var_dump($_POST);
        $product_id = $_POST['product_id'];
        $username = $_POST['username'];
        $order_date = $_POST['order_date'];
        $query = "SELECT seller FROM products WHERE id = {$product_id}";
        $quantity = $_POST['quantity'];
        $product = $database->query($query)->fetch_array(MYSQLI_ASSOC);
        // echo $order_date;
        // return;
        if($product['seller'] != $_SESSION['user']['username']){
            $_SESSION['error'] = "Samo vlasnik moze otkazati/odobriti porudzbinu na proizvod.";
            header("location:pocetna.php");
        }
        else{
            $query = "UPDATE product_orders SET status = 1 WHERE product_id = {$product_id} AND username = '{$username}' AND order_date = '{$order_date}'";
            if($database->query($query) === TRUE){
                $query = "UPDATE products SET stock = stock - {$quantity} WHERE id = {$product_id}";
                if ($database->query($query) === TRUE) {
                    $_SESSION['message'] = "Uspesno odobrena porudzbina";
                    header("location: porudzbine.php");
                    return;
                } else {
                    $_SESSION['error'] = "Greska prilikom izmene stanja proizvoda. Tekst greske: {$database->error}";
                    header("location: porudzbine.php");
                    return;
                }
            }
            else{
                $_SESSION['error'] = "Greska prilikom odobravanja porudzbine. Tekst greske: {$database->error}";
                header("location:porudzbine.php");
                return;
            }
        }
    }
    if(isset($_POST['add_review'])){
        $product_id = $_POST['product_id'];
        $username = $_POST['username'];
        $grade = $_POST['grade'];
        $review = $_POST['review'];
        $query = "INSERT INTO product_reviews(product_id,username,grade,review) VALUES({$product_id},'{$username}',{$grade},'{$review}')";
        if($database->query($query) === TRUE){
            $_SESSION['message'] = "Uspesno ocenjen proizvod";
            header("location:detalji_proizvoda.php?id=$product_id");
            return;
        }
        else{
            $_SESSION['error'] = "Greska prilikom ocenjivanja proizvoda. Tekst greske: $database->error";
            header("location:detalji_proizvoda.php?id=$product_id");
            return;
        }
    }
    if (isset($_POST['edit_review'])) {
        $product_id = $_POST['product_id'];
        $username = $_POST['username'];
        $grade = $_POST['grade'];
        $review = $_POST['review'];
        $query = "UPDATE product_reviews SET product_id = $product_id , username = '$username', grade = $grade, review = '$review' WHERE username = '$username' AND product_id = $product_id";
        if ($database->query($query) === TRUE) {
            $_SESSION['message'] = "Uspesno izmenjena ocena proizvoda";
            header("location:detalji_proizvoda.php?id=$product_id");
            return;
        } else {
            $_SESSION['error'] = "Greska prilikom izmene ocene proizvoda. Tekst greske: $database->error";
            header("location:detalji_proizvoda.php?id=$product_id");
            return;
        }
    }
    if(isset($_POST['remove_user'])){
        if ($_SESSION['user']['type'] != "admin") {
            $_SESSION['error'] = "Nemate dozvolu da vrsite izmenu korisnika.";
            header("location: pocetna.php");
            return;
        }
        $username = $_POST['username'];
        $query = "DELETE FROM users WHERE username = '{$username}'";
        if($database->query($query) === TRUE){
            $_SESSION['message'] = "Uspesno uklonjen korisnik iz baze podataka";
        }
        else{
            $_SESSION['error'] = "Doslo je do greske prilikom uklanjanja koprisnika iz baze podataka";
        }
        header("location:pocetna.php");
        return;
    }
    if(isset($_POST['edit_user'])){
        if($_SESSION['user']['type'] != "admin"){
            $_SESSION['error'] = "Nemate dozvolu da vrsite izmenu korisnika.";
            header("location: pocetna.php");
            return;
        }
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        // first, get user we are trying to edit
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $userBefore = $database->query($query)->fetch_assoc();
        //try to edit user
        $query = "UPDATE users SET  first_name = '{$first_name}', last_name = '{$last_name}', email = '{$email}' WHERE username = '{$username}'";
        try{
            if($database->query($query)===true){
                $_SESSION['message'] = "Uspesno izmenjeni podaci o korisniku";
                header("location:admin.php");
                return;
            }
            else{
                throw new Exception("Greska prilikom izmene korisnika. Tekst greske: {$database->error}");
            }
            
        }
        catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("location:pocetna.php");
            return;
        }
    }
    if(isset($_POST['cancel_order'])){
        $query = "DELETE FROM product_orders WHERE id = {$_POST['order_id']}";
        if($database->query($query) === TRUE){
            $_SESSION['message'] = "Uspesno otkazana porudzbina";
            header("location:porudzbine.php");
        }
        else{
            $_SESSION['error'] = "Greska prilikom otkazivanja porudzbine";
            header("location:porudzbine.php");
        }
    }
    if(isset($_POST['add_to_cart'])){
        $product_id = $_POST['product_id'];
        $result = SessionActions::addToCart($product_id);
        $response = [];
        if($result == 1){
            $response['msg'] = "Uspesno dodat proizvod u korpu";
            $response['count'] = SessionActions::countCart();
        }
        else{
            $response = "Greska prilikom dodavanja proizvoda u korpu";
            $response['count'] = SessionActions::countCart();
        }
        echo json_encode($response);
    }
    if (isset($_POST['remove_from_cart'])) {
        $product_id = $_POST['product_id'];
        $result = SessionActions::removeFromCart($product_id);
        $response = [];
        if ($result == 1) {
            $response['msg'] = "Uspesno uklonjen proizvod iz korpe";
            $response['count'] = SessionActions::countCart();
        } else {
            $response['msg'] = "Greska prilikom uklanjanja proizvoda iz korpe";
            $response['count'] = SessionActions::countCart();
        }
        echo json_encode($response);
    }
    if (isset($_POST['empty_cart'])) {
        $result = SessionActions::emptyCart();
        $response = [];
        if ($result == 1) {
            $response['msg'] = "Uspesno ispraznjena korpa";
            $response['count'] = SessionActions::countCart();
        } else {
            $response = "Greska prilikom praznjenja korpe";
            $response['count'] = SessionActions::countCart();
        }
        echo json_encode($response);
    }
    if(isset($_POST['remove_product'])){
        $product_id = $_POST['product_id'];
        $username = $_SESSION['user']['username'];
        $query = "SELECT * FROM products WHERE id = {$product_id}";
        $product = $database->query($query)->fetch_assoc();
        $response = "";
        if ($product['seller'] != $username) {
            $response['msg'] = "Nemate dozvolu za uklanjanje ovog proizvoda.";
        } else {
            $query = "SELECT * from product_images WHERE product_id = {$product_id}";
            $images = $database->query($query)->fetch_all(MYSQLI_ASSOC);
            foreach ($images as $image) {
                if (is_file($image['path'])) {
                    unlink($image['path']);
                }
                $query = "DELETE FROM products where id = {$product_id}";
                if ($database->query($query) === TRUE) {
                    $response = "Uspesno brisanje proizvoda iz baze podataka";
                } else {
                    $response = "Greska prilikom brisanja proizvoda iz baze podataka. Tekst greske: " . $database->error;
                }
            }
            echo json_encode($response);
        }
    }
    if(isset($_POST['get_reviews'])){
        require "ProductActions.php";
        $product_id = $_POST['product_id'];
        $reviews = ProductActions::getReviewsForProduct($product_id,null);
        echo json_encode($reviews);
    }
    if(isset($_POST['remove_review'])){
        require "ProductActions.php";
        $review_id = $_POST['review_id'];
        $username = $_SESSION['user']['username'];
        $review = ProductActions::getProductReviewByID($review_id);
        if($review != -1 && $review['id'] != $review_id){
            $response = "Nemate dozvolu da uklonite ovu recenziju";
        }
        else{
            $res = ProductActions::removeReview($review_id,$username);
            if($res == 1){
                $response = "Uspesno uklonjena ocena";
            }
            else{
                $response = "Greska prilikom uklanjanja ocene";
            }
        }
        echo json_encode($response);
    }
?>
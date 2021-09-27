<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placanje</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php require "db.php"; ?>
    <?php
    $sum = 0;
    $productsString = implode(",", array_keys($_SESSION['cart']));
    $quantityString = implode(",", array_values($_SESSION['cart']));
    foreach ($_SESSION['cart'] as $key => $in_cart) {
        $query = "SELECT products.price FROM products where products.id = {$key}";
        $product = $database->query($query)->fetch_assoc();
        $sum += $product['price'] * $in_cart;
    }

    ?>
    <div class="container mt-5">
        <h3 class="text-center">Placanje</h3>
        <h5 class="text-center">Popunite formu sa licnim informacijama kako biste dovrsili kreiranje porudzbine</h5>
        <form action="server.php" method="POST" id="paymentForm">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fname">Ime</label>
                    <input required type="text" name="fname" id="fname" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group col-md-6">
                    <label for="lname">Prezime</label>
                    <input required type="text" name="lname" id="lname" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="country">Drzava</label>
                    <input required type="text" name="country" id="fname" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group col-md-3">
                    <label for="city">Grad</label>
                    <input required type="text" name="city" id="city" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group col-md-3">
                    <label for="address">Adresa</label>
                    <input required type="text" name="address" id="address" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group col-md-3">
                    <label for="zip_code">Postanski kod</label>
                    <input required type="text" name="zip_code" id="zip_code" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <h4>Cena porudzbine: <?php echo number_format($sum, 2) . "din"; ?></h4>
            <h5>Placanje:</h5>
            <div class="form-check">
                <label class="form-check-label" for="cash">
                    <input required type="radio" class="form-check-input" required name="payment" id="cash" value="0" checked>
                    Pouzecu
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label" for="card">
                    <input required type="radio" class="form-check-input" required name="payment" id="card" value="1">
                    Karticom
                </label>
            </div>

            <input type="hidden" name="process_order" value=1>
            <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
            <input type="hidden" name="products" value="<?php echo $productsString; ?>">
            <input type="hidden" name="quantity" value="<?php echo $quantityString; ?>">

            <div id="cardInfo">

            </div>
            <button type="submit" class="btn btn-block btn-lg btn-primary w-50 mx-auto">Kreiraj porudzbinu</button>
        </form>
    </div>
    <script src="js/placanje.js"></script>
</body>

</html>
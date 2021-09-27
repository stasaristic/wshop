<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naslovna</title>
    <?php include("style.php"); ?>
</head>

<body>
    <?php include("navigation.php"); ?>
    <?php require "ProductActions.php" ?>
    <?php require "UserActions.php"; ?>
    <?php SessionActions::renderMessages(); ?>

    <?php require "db.php"; ?>
    <h3 class="text-center mt-3 mb-3">TRENUTNO U PRODAJI</h3>
    <?php
    $products = ProductActions::getAllProducts();
    ?>
    <div class="container">
        <div class="pb-5 mb-4 row">
            <?php foreach ($products as $product) : ?>
                <div class="col-md-6 mt-3 mb-4 mb-lg-0 d-flex flex-grow-1">
                    <!-- Card-->
                    <div class="card rounded shadow-sm border-0 d-flex flex-grow-1">
                        <div class="card-body row p-4">
                            <div class="col-md-6 d-flex align-center justify-content-center">
                                <img src="<?php echo $product['path']; ?>" alt="" class="product_image img-fluid d-block m-auto mb-3">
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between h-100 flex-column">
                                    <h5> <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="text-dark"><?php echo $product['name']; ?></a></h5>
                                    <small>Oglas postavio: <?php echo $product['seller']; ?></small>
                                    <p class="small text-muted font-italic"><?php echo $product['description']; ?></p>
                                    <h4><?php echo number_format($product['price'], 2) . "din"; ?></h4>
                                    <ul class="list-inline">
                                        <?php $rate = ProductActions::getAverageRating($product['id']); ?>
                                        <?php for ($i = 0; $i < 5; $i++) {
                                            if ($i < $rate) {
                                                echo "<i class = 'fa fa-star text-primary'></i>";
                                            } else {
                                                echo "<i class = 'fa fa-star-o text-primary'></i>";
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <?php if ($_SESSION['user']['username'] == null) : ?>
                                        <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block ">Prikazi detalje</a>
                                    <?php else : ?>
                                        <?php if ($product['stock'] > 0) : ?>
                                            <a onclick="addToCart(<?php echo $product['id']; ?>)" class="btn btn-primary btn-block ">Dodaj u korpu</a>
                                        <?php else : ?>
                                            <button disabled="disabled" class="btn btn-danger btn-block">Nema na stanju</button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
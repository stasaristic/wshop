<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni proizvod</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php
    require "db.php";
    require "ProductActions.php";
    require "CategoryActions.php";

    $product_id = $_GET['id'];
    $product = ProductActions::getSingleProductDetails($product_id);
    $categories = CategoryActions::getAllCategories();
    ?>
    <div class="container mt-5">
        <h3 class="text-center">Izmena proizvoda</h3>
        <form action="server.php" method="post">
            <div class="form-group">
                <label for="product_name">Naziv proizvoda</label>
                <input type="text" name="pname" id="product_name" class="form-control" placeholder="" value="<?php echo $product["name"]; ?>">
            </div>
            <div class="form-group">
                <label for="description">Opis proizvoda</label>
                <textarea type="text" name="description" id="description" class="form-control" placeholder="" aria-describedby="helpId"><?php echo $product["description"]; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Cena proizvoda</label>
                <input type="text" name="price" id="product_price" class="form-control" placeholder="" value="<?php echo $product["price"]; ?>">
            </div>
            <div class="form-group">
                <label for="stock">Stanje</label>
                <input type="text" name="stock" id="stock" class="form-control" placeholder="" value="<?php echo $product["stock"]; ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Kategorija proizvoda</label>
                <select class="form-control" name="cat" id="exampleFormControlSelect1">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category[0]; ?>" <?php if (strcasecmp($category[0], $product["category"]) == 0) : ?>selected<?php endif; ?>><?php echo ucfirst($category[0]); ?></option>
                    <?php endforeach; ?>
                    <option value=-1>Samostalan unos kategorije</option>
                </select>
            </div>
            <div class="form-group" id="catManual">
                <label for="productName">Kategorija proizvoda</label>
                <input type="text" class="form-control" id="productName" name="catManual">
            </div>
            <input type="hidden" name="edit_product" value="1">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="btn btn-primary btn-block">Izmeni proizvod</button>
        </form>
    </div>
</body>

</html>
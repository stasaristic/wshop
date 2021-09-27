<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezultati pretrage</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php" ?>
    <?php
    require "db.php";
    require "ProductActions.php";
    require "CategoryActions.php";
    $search_Text = $_GET['search'];
    $products = ProductActions::getAllProducts();
    $categories = CategoryActions::getAllCategories();
    $categories_array = [];
    foreach($products as $index => $product){
        if(!str_contains(strtolower($product["name"]),$search_Text)){
            unset($products[$index]);
        }
    }
    //get product categories
    foreach ($products as $product) {
        if (!array_key_exists($product['category'], $categories_array)) {
            $categories_array[$product['category']]['title'] = $product['category'];
            $categories_array[$product['category']]['count'] = 1;
        } else {
            $categories_array[$product['category']]['count']++;
        }
    }
    if (isset($_GET['price-sort'])) {
        if ($_GET['price-sort'] === 'desc') {
            array_multisort(array_column($products, 'price'), SORT_ASC, $products);
        }
        if ($_GET['price-sort'] === "asc") {
            array_multisort(array_column($products, 'price'), SORT_DESC, $products);
        }
    }
    if (isset($_GET['categories'])) {
        foreach ($products as $index => $product) {
            if (!in_array($product['category'], $_GET['categories'])) {
                unset($products[$index]);

            }
        }
    }
    if (isset($_GET['min']) && isset($_GET['max'])) {
        if ($_GET['min'] > $_GET['max']) {
            $temp = $_GET['min'];
            $_GET['min'] = $_GET['max'];
            $_GET['max'] = $temp;
        }
    }
    if (isset($_GET['min']) && $_GET['min'] != "") {
        foreach ($products as $index => $product) {
            if ($product['price'] < $_GET['min']) {
                unset($products[$index]);
            }
        }
    }
    if (isset($_GET['max']) && $_GET['max'] != "") {
        foreach ($products as $index => $product) {
            if ($product['price'] > $_GET['max']) {
                unset($products[$index]);
            }
        }
    }
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-center">Filteri</h5>
                <form action="pretraga.php" method="get" class=" w-100">
                    <div class=" mt-3 container">
                        <div class="form-group">
                            <label for="search">Pretraga</label><br>
                            <input type="text" id="search" class=" form-control" value="<?php echo $search_Text; ?>" name="search" val="<?php echo $_GET['search']; ?>">
                        </div>
                    </div>
                    <div class="container my-3" id="filters">
                        <div class="">
                            <label for="priceFilter">Cena</label>
                            <select class="form-control" id="priceFilter" name="price-sort">
                                <option value="desc" <?php if (isset($_GET['price-sort']) && $_GET['price-sort'] == "asc") echo "selected"; ?>>Opadajuce</option>
                                <option value="asc" <?php if (isset($_GET['price-sort']) && $_GET['price-sort'] == "asc") echo "selected"; ?>>Rastuce</option>
                            </select>
                        </div>
                        <div class="border border-grey p-3 mt-3 rounded">
                            <label for="catFilter">Kategorije</label>
                            <?php foreach ($categories_array as $index => $category) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" name='categories[]' type="checkbox" value="<?php echo $index; ?>" id="checkbox-<?php echo $category['title']; ?>" <?php if (isset($_GET['categories']) && in_array($category['title'], $_GET['categories'])) echo "checked"; ?>>
                                    <label class="form-check-label" for="checkbox-<?php echo $category['title']; ?>">
                                        <?php echo ucfirst($category['title']) . "(" . $category['count'] . ")"; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6  p-3 my-3 rounded">
                                <label for="minprice">Od</label>
                                <input type="number" name="min" id="minprice" class="form-control" value="<?php if (isset($_GET['min'])) echo $_GET['min']; ?>">
                            </div>
                            <div class=" col-md-6 p-3 my-3 rounded">
                                <label for="maxprice">Do</label>
                                <input type="number" name="max" id="maxprice" class="form-control" value="<?php if (isset($_GET['max'])) echo $_GET['max']; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Pretrazi</button>
                </form>

            </div>
            <div class="col-md-8">
                <div class="container">
                    <?php foreach ($products as $product) : ?>
                        <div class=" mt-3 mb-4 mb-lg-0">
                            <!-- Card-->
                            <div class="card rounded shadow-sm border-0">
                                <div class="card-body row p-4">
                                    <div class="col-md-3">
                                        <img src="<?php echo $product['path']; ?>" alt="" class="product_image img-fluid d-block mx-auto mb-3">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between h-75 flex-column">
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
                                        </div>
                                        <?php if ($_SESSION['user']['username'] == null) : ?>
                                            <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block ">Prikazi detalje</a>
                                        <?php else : ?>
                                            <?php if ($product['stock'] > 0) : ?>
                                                <a onclick = "addToCart(<?php echo $product['id'];?>)" class="btn btn-primary btn-block ">Dodaj u korpu</a>
                                            <?php else : ?>
                                                <button disabled="disabled" class="btn btn-danger btn-block">Nema na stanju</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
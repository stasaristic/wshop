<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodavac</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php
    require "db.php";
    require "CategoryActions.php";
    require "ProductActions.php";
    $products = ProductActions::getAllProductsFromSeller($_SESSION['user']['username']);
    $categories = CategoryActions::getAllCategories();

    ?>
    <?php if ($_SESSION['user']['type'] != "prodavac") {
        $_SESSION['error'] = "Nemate pristup ovom delu sajta";
        header("location:pocetna.php");
        return;
    }
    ?>
    <?php SessionActions::renderMessages(); ?>

    <div class="p-5 container-fluid row">
        <div class="col-md-9">
            <h3 class="text-center">
                Pregled Vasih proizvoda
            </h3>
            <?php if (count($products) == 0) : ?>
                <h5 class="text-center">Nemate dodat ni jedan proizvod.</h5>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table text-center ">
                        <th>Slika</th>
                        <th>Sifra</th>
                        <th>Naziv</th>
                        <th>Kategorija</th>
                        <th>Cena</th>
                        <th>Stanje</th>
                        <th>Obrisi proizvod</th>
                        <th>Izmeni proizvod</th>
                        <th>Ocene</th>
                        <tbody>
                            <?php foreach ($products as $product) : ?>
                                <!-- <?php var_dump($product); ?> -->
                                <tr>
                                    <td><img src="<?php echo $product['path']; ?>" class="img-thumbnail pimg"></td>
                                    <td class="align-middle"><?php echo $product['id']; ?></td>
                                    <td class="align-middle"><?php echo $product['name']; ?></td>
                                    <td class="align-middle"><?php echo ucfirst($product['category']); ?></td>
                                    <td class="align-middle"><?php echo $product['price']; ?></td>
                                    <td class="align-middle"><?php echo $product['stock']; ?></td>
                                    <td class="align-middle text-center"><a onclick="removeProduct(<?php echo $product['id']; ?>)" class="btn btn-danger">Ukloni</a></td>
                                    <td class="align-middle text-center"><a href="editproduct.php?id=<?php echo $product['id']; ?>" class="btn btn-warning">Izmeni</a></td>
                                    <td class="align-middle text-center"><a onclick="showRates(<?php echo $product['id']; ?>)" class="btn btn-primary">Prikazi</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3" id="colPlaceholder">
            <div id="addProduct">
                <h3 class="text-center">Dodaj proizvod</h3>
                <form method="POST" action="server.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="productName">Naziv proizvoda</label>
                        <input type="text" class="form-control" id="productName" name="pname">
                    </div>
                    <div class="form-group">
                        <label for="description">Opis proizvoda</label>
                        <textarea type="text" name="description" id="description" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                    </div>
                    <div class="form-group" id="catSelect">
                        <label for="category">Kategorija proizvoda</label>
                        <select class="form-control" name="cat" id="category" onchange="enableManualCatSelect()">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category[0]; ?>"><?php echo ucfirst($category[0]); ?></option>
                            <?php endforeach; ?>
                            <option value=-1>Samostalan unos kategorije</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Cena proizvoda</label>
                        <input type="text" class="form-control" id="productPrice" name="price">
                    </div>
                    <div class="form-group">
                        <label for="stock">Stanje u inventaru</label>
                        <input type="text" class="form-control" id="stock" name="stock">
                    </div>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" name="images[]" class="custom-file-input" id="inputGroupFile01" multiple>
                            <label class="custom-file-label" for="inputGroupFile01">Odaberite slike</label>
                        </div>
                        <small class="text-muted text-center">Pritiskom Ctrl tastera na tastaturi ili drzanjem misa i prevlacenjem preko slika to mozete uraditi.</small>
                    </div>
                    <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
                    <input type="hidden" name="add_product" value="1">
                    <button type="submit" class="btn btn-primary btn-block">Dodaj proizvod</button>
                </form>
            </div>
            <div id="productReviews" class="d-none">

            </div>
        </div>

    </div>
</body>

</html>
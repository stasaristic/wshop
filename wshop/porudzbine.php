<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porudzbine</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php require "db.php"; ?>
    <?php SessionActions::renderMessages(); ?>
    <?php
    if ($_SESSION['user']['type'] == 'prodavac') {
        $query = "SELECT product_orders.*, products.*, product_images.path FROM product_orders INNER JOIN products on products.id = product_orders.product_id INNER JOIN product_images on products.id = product_images.product_id WHERE products.seller = '{$_SESSION['user']['username']}' GROUP BY products.name";
    } else {
        $query =
            "SELECT product_orders.*, products.*,product_orders.id as 'order_id', product_images.path FROM product_orders INNER JOIN products on products.id = product_orders.product_id INNER JOIN product_images on products.id = product_images.product_id WHERE product_orders.username = '{$_SESSION['user']['username']}' GROUP BY products.name";
    }
    $orders = $database->query($query)->fetch_all(MYSQLI_ASSOC);
    ?>

    <div class="container mt-5">
        <h3 class="text-center">Pregled porudzbina</h3>
        <?php if (count($orders) == 0) : ?>
            <h5 class="text-center">Nemate ni jednu porudzbinu.</h5>
        <?php else : ?>
            <?php if ($_SESSION['user']['type'] == "prodavac") : ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive mt-5">
                            <table class="table " id="myTable2">
                                <th onclick="sortTable(0)">Proizvod</th>
                                <th onclick="sortTable(1)">Korisnik</th>
                                <th onclick="sortTable(2)">Ime</th>
                                <th onclick="sortTable(3)">Prezime</th>
                                <th onclick="sortTable(4)">Kolicina</th>
                                <th onclick="sortTable(5)">Odobri porudzbinu</th>
                                <th onclick="sortTable(6)">Odbij porudzbinu</th>
                                <tbody>
                                    <?php foreach ($orders as $order) : ?>
                                        <!-- <?php var_dump($order); ?> -->
                                        <tr>
                                            <td class="align-middle"><?php echo $order['name']; ?></td>
                                            <td class="align-middle"><?php echo $order['username']; ?></td>
                                            <td class="align-middle"><?php echo ucfirst($order['first_name']); ?></td>
                                            <td class="align-middle"><?php echo ucfirst($order['last_name']); ?></td>
                                            <td class="align-middle"><?php echo ucfirst($order['quantity']); ?></td>
                                            <td class="align-middle">
                                                <form action="server.php" method="POST">
                                                    <input type="hidden" name="username" value="<?php echo $order['username']; ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $order['product_id'] ?>">
                                                    <input type="hidden" name="order_date" value="<?php echo $order['order_date'] ?>">
                                                    <input type="hidden" name="quantity" value="<?php echo $order['quantity'] ?>">
                                                    <input type="hidden" name="allow_order" value="1">
                                                    <?php if ($order['quantity'] > $order['stock']) : ?>
                                                        <button type="submit" class="btn btn-success btn-block" disabled data-toggle="tooltip" data-placement="top" title="Porucen broj artikala je veci od trenutnog stanja proizvoda">Odobri</button>

                                                    <?php else : ?>
                                                        <button type="submit" class="btn btn-success btn-block" <?php if ($order['status'] == 1) echo "disabled"; ?>>Odobri</button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <form action="server.php" method="POST">
                                                    <input type="hidden" name="username" value="<?php echo $order['username']; ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $order['product_id'] ?>">
                                                    <input type="hidden" name="order_date" value="<?php echo $order['order_date'] ?>">
                                                    <input type="hidden" name="quantity" value="<?php echo $order['quantity'] ?>">
                                                    <input type="hidden" name="disable_order" value="1">
                                                    <button type="submit" class="btn btn-danger btn-block" <?php if ($order['status'] == -1) echo "disabled"; ?>>Odbij</button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <h3 class="text-center">Licne podudzbine</h5>
                            <?php
                            $pers_query =
                                    "SELECT product_orders.*, products.*,product_orders.id as 'order_id', product_images.path FROM product_orders INNER JOIN products on products.id = product_orders.product_id INNER JOIN product_images on products.id = product_images.product_id WHERE product_orders.username = '{$_SESSION['user']['username']}' GROUP BY products.name";
                            $pers_orders = $database->query($pers_query)->fetch_all(MYSQLI_ASSOC);
                            ?>
                            <?php foreach ($pers_orders as $order) : ?>
                                <div class="my-3 mb-4 mb-lg-0">
                                    <!-- Card-->
                                    <div class="card rounded shadow-sm border-0">
                                        <div class="card-body row p-4">
                                            <div class="col-md-3">
                                                <img src="<?php echo $order['path']; ?>" alt="" class="product_image img-fluid d-block mx-auto mb-3">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="d-flex flex-column">
                                                    <h5> <a href="detalji_proizvoda.php?id=<?php echo $order['product_id']; ?>" class="text-dark"><?php echo $order['name']; ?></a></h5>
                                                    <small>Prodavac: <?php echo $order['seller']; ?></small>
                                                    <h6><?php echo number_format($order['price'], 2) . "din"; ?></h6>
                                                    <div class="d-flex flex-column">
                                                        <span>Podaci o isporuci:</span>
                                                        <span>Ime i prezime preuzimaoca:
                                                            <?php echo $order['first_name'] . " " . $order['last_name']; ?> </span>
                                                        <span>Datum porucivanja: <?php echo $order['order_date']; ?></span>
                                                    </div>
                                                    <button onclick="location.href='detalji_proizvoda.php?id=<?php echo $order['id']; ?>'" class="my-2 flex-fill btn btn-primary btn-block align-middle text-center ">Prikazi
                                                        detalje</button>

                                                    <?php if ($order['status'] == 0) : ?>
                                                        <form action="server.php" method="POST" class="flex-fill w-100">
                                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                            <input type="hidden" name="cancel_order" value="1">
                                                            <button type="submit" class=" btn btn-danger btn-block ">Otkazi
                                                                porudzbinu</button>
                                                        </form>
                                                    <?php else : ?>
                                                        <button type="submit" class="flex-fill btn btn-success btn-block align-middle" disabled data-toggle="tooltip" data-placement="top" title="Porudzbina je vec odobrena i ne moze biti otkazana">Otkazi porudzinu</button>

                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php foreach ($orders as $order) : ?>
                                    <div class="my-3 mb-4 mb-lg-0">
                                        <!-- Card-->
                                        <div class="card rounded shadow-sm border-0">
                                            <div class="card-body row p-4">
                                                <div class="col-md-2">
                                                    <img src="<?php echo $order['path']; ?>" alt="" class="img-fluid d-block mx-auto mb-3">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="d-flex justify-content-between h-100 flex-column">
                                                        <h5> <a href="detalji_proizvoda.php?id=<?php echo $order['product_id']; ?>" class="text-dark"><?php echo $order['name']; ?></a></h5>
                                                        <small>Prodavac: <?php echo $order['seller']; ?></small>
                                                        <h6><?php echo number_format($order['price'], 2) . "din"; ?></h6>
                                                        <div class="d-flex flex-column">
                                                            <span>Podaci o isporuci:</span>
                                                            <span>Ime i prezime preuzimaoca:
                                                                <?php echo $order['first_name'] . " " . $order['last_name']; ?> </span>
                                                            <span>Datum porucivanja: <?php echo $order['order_date']; ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mx-auto h-100 d-flex flex-grow-1 flex-column justify-content-center align-items-center">
                                                        <button onclick="location.href='detalji_proizvoda.php?id=<?php echo $order['id']; ?>'" class="my-2 flex-fill btn btn-primary btn-block align-middle text-center ">Prikazi
                                                            detalje</button>

                                                        <?php if ($order['status'] == 0) : ?>
                                                            <form action="server.php" method="POST" class="flex-fill w-100">
                                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                                <input type="hidden" name="cancel_order" value="1">
                                                                <button type="submit" class=" btn btn-danger btn-block ">Otkazi
                                                                    porudzbinu</button>
                                                            </form>
                                                        <?php else : ?>
                                                            <button type="submit" class="flex-fill btn btn-success btn-block align-middle" disabled data-toggle="tooltip" data-placement="top" title="Porudzbina je vec odobrena i ne moze biti otkazana">Otkazi porudzinu</button>

                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                    <script src="js/porudzbine.js"></script>
                                    <script>
                                        $(function() {
                                            $('[data-toggle="tooltip"]').tooltip()
                                        })
                                    </script>
</body>

</html>
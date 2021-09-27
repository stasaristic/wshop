<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php require "UserActions.php";?>
    <?php SessionActions::renderMessages();?>
    <?php if($_SESSION['user']['type'] != "admin"){
        $_SESSION['error'] = "Nemate pristup ovom delu sajta";
        header("location:pocetna.php");
        return;
    }
    ?>
    <div class="container mt-5">
        <h3 class="text-center">Pregled i izmena korisnika</h3>
        <?php
        $users = UserActions::getAllUsers();
        ?>
        <div class="row">
            <?php foreach ($users as $user) : ?>
                <div class="col-md-6 my-2">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $user['username']; ?>
                        </div>
                        <div class="card-body">
                            <form action="server.php" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Ime</label>
                                            <input type="text" name="fname" id="first_name" class="form-control" placeholder="" aria-describedby="helpId" value="<?php echo $user['first_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Prezime</label>
                                            <input type="text" name="lname" id="last_name" class="form-control" placeholder="" aria-describedby="helpId" value="<?php echo $user['last_name']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpId" value="<?php echo $user['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Uloga</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="kupac">Kupac</option>
                                                <option value="prodavac">Prodavac</option>
                                                <option value="admin">Admin (ne preporucujemo)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="edit_user">
                                    <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                    <input type="hidden" name="prev_email" value="<?php echo $user['username']; ?>">

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="server.php">
                                            <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                            <button class="btn btn-danger btn-block" type="submit">Ukloni korisnika</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-block" type="submit">Izmeni korisnika</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
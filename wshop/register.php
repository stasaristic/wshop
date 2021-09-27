<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <?php include("style.php"); ?>
</head>

<body>
    <?php include("navigation.php"); ?>
    <div class="container mt-5">
        <?php 
        SessionActions::startSession();
        ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>Greska!</strong> <?php echo $_SESSION['error'];
                                            unset($_SESSION["error"]); ?>.
            </div>
        <?php endif; ?>
        <h3>Registracija naloga</h3>
        <form method="POST" action="server.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputFirstName">Ime</label>
                    <input type="text" name="fname" class="form-control" id="inputFirstName">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputLastName">Prezime</label>
                    <input type="text" name="lname" class="form-control" id="inputLastName">
                </div>
                <div class="form-group col-md-12">
                    <label for="inputUsername">Korisnicko ime</label>
                    <input type="text" name="username" class="form-control" id="inputUsername">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail">Email adresa</label>
                    <input type="email" name="email" class="form-control" id="inputEmail">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Lozinka</label>
                    <input type="password" name="password" class="form-control" id="inputPassword4">
                </div>
            </div>

            <div class="form-group">
                <span>Registrujem se kao: </span>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="kupac" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Kupac
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="prodavac">
                    <label class="form-check-label" for="exampleRadios2">
                        Prodavac
                    </label>
                </div>
                <input type="hidden" name="register">
            </div>
            <p class="text-center">Nalog vec postoji? Prijavite se <a href="login.php">ovde</a>.</p>

            <button type="submit" class="btn btn-primary w-100">Registruj se</button>
        </form>
    </div>
</body>

</html>
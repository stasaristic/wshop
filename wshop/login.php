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
        SessionActions::renderMessages();
        ?>
        
        <h3>Prijavljivanje na nalog</h3>
        <form method="POST" action="server.php">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputUsername">Korisnicko ime</label>
                    <input type="text" name="username" class="form-control" id="inputUsername">
                </div>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">Lozinka</label>
                    <input type="password" name="password" class="form-control" id="inputPassword4">
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" name="login">
            </div>
            <p class = "text-center">Nalog ne postoji? Prijavite se <a href = "register.php">ovde</a>.</p>
            <button type="submit" class="btn btn-primary w-100">Prijavi se</button>
        </form>
    </div>
</body>

</html>
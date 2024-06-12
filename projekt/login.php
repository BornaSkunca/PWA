<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    include 'connect.php';
    define('UPLPATH', 'img/');
    ?>

    <?php
        session_start();
        if(isset($_SESSION['$username']) && $_SESSION['$username'] != ""){
            header('Location: administracija.php');
            exit(); 
            
        }
    ?>
    
    <div id="glavniDiv">
        <header>
            <nav>
                <a href="index.php">HOME</a>
                <a href="kategorija.php?kategorija=politik">POLITIK</a>
                <a href="kategorija.php?kategorija=sport">SPORT</a>
                <a href="login.php">ADMINISTRACIJA</a>
            </nav>
            <hr>
            
            <h1 class="naslov">Frankfurter Allgemeine</h1>
        </header>

        <form action="administracija.php" method="post">
            <input type="text" name="username" placeholder="username">
            <br>
            <input type="password" name="lozinka" placeholder="password">
            <br>
            <input type="submit" name="prijava" value="Log in">
        </form>

    </div>

    <footer>
        <h2 class="naslov">Borna Škunca</h2>
    </footer>
    
    
</body>
</html>

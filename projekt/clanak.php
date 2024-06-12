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

    if(isset($_GET["id"]))
        $id = $_GET["id"];
        
        $query = "SELECT * from vijesti1 WHERE id = $id";
        $result = mysqli_query($dbc,$query);
        $row = mysqli_fetch_array($result);
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
            <hr>
        </header>

        <section role="main"> 
            <div class="row"> 
                <h2 class="category">
                    <?php 
                    //echo "<span>".$row['kategorija']."</span>"; 
                    ?>
                </h2> 
                <h1 class="title"><?php echo $row['naslov']; ?></h1> 
                <p>OBJAVLJENO: <?php echo "<span>".$row['datum']."</span>"; ?></p> 
            </div> 
            <section class="slika"> 
                <?php echo '<img src="' . UPLPATH . $row['slika'] . '">'; 
                ?> 
            </section> 
            <section class="about">
                 <p> <?php echo "<i>".$row['sazetak']."</i>"; ?> </p> 
            </section> 
            <section class="sadrzaj"> 
                <p> <?php echo $row['tekst']; ?> </p> 
            </section> 
        </section>

    </div>

    <footer>
        <h2 class="naslov">Borna Škunca</h2>
    </footer>
    
    
</body>
</html>

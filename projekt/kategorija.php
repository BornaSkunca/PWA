<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
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
            <br>
            <h2><?php $kategorija=$_GET['kategorija']; 
            
            echo ucfirst($kategorija);
            ?></h2>
        </header>

        <?php 
        include 'connect.php'; 
        define('UPLPATH', 'img/'); 
        ?> 
        
        <section class="sport">
             
            <?php 
            
            $query = "SELECT * FROM vijesti1 WHERE arhiva=0 AND (kategorija='$kategorija')"; 
            $result = mysqli_query($dbc, $query);  
            
            while($row = mysqli_fetch_array($result)) { 
                echo'<div class="katArticle">'; 
                echo '<div class="sport_img">'; 
                echo '<img src="' . UPLPATH . $row['slika'] . '">'; 
                echo '</div>'; 
                echo '<div class="media_body">'; 
                echo '<h4 class="title">'; 
                echo '<a href="clanak.php?id='.$row['id'].'">'; 
                echo $row['naslov']; 
                echo '</a></h4>'; 
                echo "</div><div class='sazeto'><p>" . $row['sazetak'] . "</p></div></div>"; 
                
                }
                
                ?> 
        </section>

    </div>

    <footer>
        <h2 class="naslov">Borna Škunca</h2>
    </footer>
    
    
</body>
</html>

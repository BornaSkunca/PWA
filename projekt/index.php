<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frankfurter Allgemeine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    include 'connect.php';
    define('UPLPATH', 'img/');
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

        <section>
            <article class="articleTema">
                <hr>
                <p>POLITIK</p>
                
            </article>

            <?php
            $query = "SELECT * FROM vijesti1 WHERE arhiva = 0 AND kategorija = 'politik' limit 3";
            $result = mysqli_query($dbc, $query);
            
            while($row = mysqli_fetch_array($result)){
                echo '<div class="article">';
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

        <section>
            <article class="articleTema">
                <hr>
                <p>SPORT</p>
                
            </article>

            <?php
            $query2 = "SELECT * FROM vijesti1 WHERE arhiva = 0 AND kategorija = 'sport' limit 3";
            $result2 = mysqli_query($dbc, $query2);
            while($row2 = mysqli_fetch_array($result2)){
                echo '<div class="article">';
                echo '<div class="sport_img">';
                echo '<img src="' . UPLPATH . $row2['slika'] . '">';
                echo '</div>';
                echo '<div class="media_body">';
                echo '<h4 class="title">';
                echo '<a href="clanak.php?id='.$row2['id'].'">';
                echo $row2['naslov'];
                echo '</a></h4>';
                echo "</div><div class='sazeto'><p>" . $row2['sazetak'] . "</p></div></div>";
            }
            ?>
        </section>
    </div>

    <footer>
        <h2 class="naslov">Borna Škunca</h2>
    </footer>
</body>
</html>

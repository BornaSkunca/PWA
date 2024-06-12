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
        </header>

    

        <?php 
        session_start(); 
        include 'connect.php'; 
        define('UPLPATH', 'img/');

        $uspjesnaPrijava = false;

        if (isset($_POST['prijava'])) { 
            $prijavaImeKorisnika = $_POST['username']; 
            $prijavaLozinkaKorisnika = $_POST['lozinka']; 
            $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik1 WHERE korisnicko_ime = ?"; 
            $stmt = mysqli_stmt_init($dbc); 
            if (mysqli_stmt_prepare($stmt, $sql)) { 
                mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika); 
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_store_result($stmt); 
            } 
            mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika); 
            mysqli_stmt_fetch($stmt); 
            if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) { 
                $uspjesnaPrijava = true;
                if($levelKorisnika == 1) { 
                    $admin = true; 
                } else { $admin = false; } 
                $_SESSION['$username'] = $imeKorisnika; 
                $_SESSION['$level'] = $levelKorisnika; 
            } else { $uspjesnaPrijava = false; } 
        } ?>

        <?php 
        if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) { 
            $query = "SELECT * FROM vijesti1"; 
            $result = mysqli_query($dbc, $query); 
            while($row = mysqli_fetch_array($result)) { 
                echo '
                <form enctype="multipart/form-data" action="" method="POST"> 
                    <div class="form-item"> 
                        <label for="title">Naslov vjesti:</label> 
                        <div class="form-field"> 
                            <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'"> 
                        </div> 
                    </div> 
                    <div class="form-item"> 
                        <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label> 
                        <div class="form-field"> 
                            <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">'.$row['sazetak'].'</textarea> 
                        </div> 
                    </div> 
                    <div class="form-item"> 
                        <label for="content">Sadržaj vijesti:</label> 
                        <div class="form-field"> 
                            <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">'.$row['tekst'].'</textarea> 
                        </div> 
                    </div> 
                    <div class="form-item"> 
                        <label for="pphoto">Slika:</label> 
                        <div class="form-field">
                            <input type="file" class="input-text" id="pphoto" value="'.$row['slika'].'" name="pphoto"/> 
                            <br>
                            <img src="' . UPLPATH . $row['slika'] . '" width=100px>
                        </div> 
                    </div> 
                    <div class="form-item"> 
                        <label for="category">Kategorija vijesti:</label> 
                        <div class="form-field"> 
                            <select name="category" id="" class="form-field-textual" value="'.$row['kategorija'].'"> 
                                <option value="sport">sport</option> 
                                <option value="politik">politik</option> 
                            </select> 
                        </div> 
                    </div> 
                    <div class="form-item"> 
                        <label>Spremiti u arhivu: 
                        <div class="form-field">'; 
                            if($row['arhiva'] == 0) { 
                                echo '<input type="checkbox" name="archive" id="archive"/> Arhiviraj?'; 
                            } else { echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?'; 
                            } 
        echo '          </div> 
                        </label> 
                    </div> 

            

                    <div class="form-item"> 
                        <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'"> 
                        <button type="reset" value="Poništi">Poništi</button> 
                        <button type="submit" name="update" value="Prihvati"> Izmjeni</button> 
                        <button type="submit" name="delete" value="Izbriši"> Izbriši</button> 
                    </div> 
                </form>';
             } 
         } else if ($uspjesnaPrijava == true && $admin == false) { 
            echo '<p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</p>'; 
        } else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
            echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>'; 
        } else if ($uspjesnaPrijava == false) {
            ?> 
            <?php
                echo "Kriva lozinka ili korisnik ne postoji u bazi";
                echo "<br><br><br><br><br>";
                echo "<a href = 'registracija.php' class='register'>REGISTRACIJA</a>";?> 
        <?php } ?> 

        <?php
        if (isset($_POST['update'])) {
            $title = $_POST['title'];
            $about = $_POST['about'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $archive = isset($_POST['archive']) ? 1 : 0;
            $id = $_POST['id'];

            
            $pphoto = $_FILES['pphoto']['name'];
            $target_dir = UPLPATH;
            $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
            move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);

            $query = "UPDATE vijesti1 SET naslov='$title', sazetak='$about', tekst='$content', slika='$pphoto', kategorija='$category', arhiva='$archive' WHERE id=$id";
            mysqli_query($dbc, $query);
        }

        
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $query = "DELETE FROM vijesti1 WHERE id=$id";
            mysqli_query($dbc, $query);
        }
        ?>

    </div>

    <footer>
        <h2 class="naslov">Borna Škunca</h2>
    </footer>
    
    
</body>
</html>

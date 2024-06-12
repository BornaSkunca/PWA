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
    
    <div id="glavniDiv">
        <header>
            <nav>
            <a href="index.php">HOME</a>
                <a href="kategorija.php?kategorija=politik">POLITIK</a>
                <a href="kategorija.php?kategorija=sport">SPORT</a>
                <a href="administracija.php">ADMINISTRACIJA</a>
            </nav>
            <hr>
            <h1 class="naslov">Frankfurter Allgemeine</h1>
        </header>

        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-item">
                <span id="porukaTitle" class="bojaPoruke"></span>
                <label for="title">Naslov vjesti</label>
                <div class="form-field">
                    <input type="text" name="title" id="title" class="formfield-textual">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaAbout" class="bojaPoruke"></span>
                <label for="about">Kratki sadržaj vjesti (do 150 znakova)</label>
                <div class="form-field">
                    <textarea name="about" id="about" cols="30" rows="10" class="form-field-textual"></textarea>
                </div>
            </div>
            <div class="form-item">
                <span id="porukaContent" class="bojaPoruke"></span>
                <label for="content">Sadržaj vjesti</label>
                <div class="form-field">
                    <textarea name="content" id="content" cols="30" rows="10"class="form-field-textual"></textarea>
                </div>
            </div>
            <div class="form-item">
                <span id="porukaSlika" class="bojaPoruke"></span>
                <label for="pphoto">Slika: </label>
                <div class="form-field">
                    <input type="file" class="input-text" id="pphoto" name="pphoto"/>
                </div>
            </div>
            <div class="form-item">
                <span id="porukaKategorija" class="bojaPoruke"></span>
                <label for="category">Kategorija vjesti</label>
                <div class="form-field">
                    <select name="category" id="category" class="form-fieldtextual">
                        <option value="" disabled selected>Odabir kategorije</option>
                        <option value="sport">Sport</option>
                        <option value="politik">Politik</option>
                    </select>
                </div>
            </div>
            <div class="form-item">
                <label>Spremiti u arhivu:
                <div class="form-field">
                     <input type="checkbox" name="archive" id="archive">
                </div>
                </label>
            </div>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati"id="slanje">Prihvati</button>
            </div>
        </form>

    </div>

    <script type="text/javascript">

        document.getElementById("slanje").onclick = function(event) {

            var slanjeForme = true;

            var poljeTitle = document.getElementById("title");
            var title = document.getElementById("title").value;
            if (title.length < 5 || title.length > 50) {
                slanjeForme = false;
                poljeTitle.style.border="1px dashed red";
                document.getElementById("porukaTitle").innerHTML="Naslov vjesti mora imati između 5 i 50 znakova!<br>";
            } else {
                poljeTitle.style.border="1px solid green";
                document.getElementById("porukaTitle").innerHTML="";
            }


            var poljeAbout = document.getElementById("about");
            var about = document.getElementById("about").value;
            if (about.length < 10 || about.length > 150) {
                slanjeForme = false;
                poljeAbout.style.border="1px dashed red";
                document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 150 znakova!<br>";
                } else {
                    poljeAbout.style.border="1px solid green";
                    document.getElementById("porukaAbout").innerHTML="";
                }

            var poljeContent = document.getElementById("content");
            var content = document.getElementById("content").value;
            if (content.length == 0) {
                slanjeForme = false;
                poljeContent.style.border="1px dashed red";
                document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
            } else {
                poljeContent.style.border="1px solid green";

                document.getElementById("porukaContent").innerHTML="";
            }

            var poljeSlika = document.getElementById("pphoto");
            var pphoto = document.getElementById("pphoto").value;
            if (pphoto.length == 0) {
                slanjeForme = false;
                poljeSlika.style.border="1px dashed red";
                document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
            } else {
                poljeSlika.style.border="1px solid green";
                document.getElementById("porukaSlika").innerHTML="";
            }

            var poljeCategory = document.getElementById("category");
            if(document.getElementById("category").selectedIndex == 0) {
                slanjeForme = false;
                poljeCategory.style.border="1px dashed red";

                document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
            } else {
                poljeCategory.style.border="1px solid green";
                document.getElementById("porukaKategorija").innerHTML="";
            }

            if (slanjeForme != true) {
                event.preventDefault();
            }

        };
    </script>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $picture = $_FILES['pphoto']['name']; 
        $title=$_POST['title']; 
        $about=$_POST['about']; 
        $content=$_POST['content']; 
        $category=$_POST['category']; 
        $date=date('d.m.Y.'); 
        if(isset($_POST['archive'])){ 
            $archive=1; 
        }else{ $archive=0; }
        $target_dir = 'img/'.$picture; 
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir); 
        $query = "INSERT INTO vijesti1 (datum, naslov, sazetak, tekst, slika, kategorija, arhiva ) VALUES ('$date', '$title', '$about', '$content', '$picture', '$category', '$archive')"; 
        $result = mysqli_query($dbc, $query) or die('Error querying databese.'); 
        mysqli_close($dbc);

        echo "Succes adding item to table!";
}
    ?>



    <footer>
        <h2 class="naslov">Borna Škunca</h2>
    </footer>
    
    
</body>
</html>

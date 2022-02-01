<?php

    require_once "data.php";

    if(array_key_exists("stranka", $_GET)){//if znamenající zobrazení naší podstránky např. kontakt
        $idAktualniStranky = $_GET["stranka"];

        if(array_key_exists($idAktualniStranky, $seznamStranek)){

        }else{
            $idAktualniStranky = "404";
        }

    }else{
        $idAktualniStranky = array_keys($seznamStranek)[0];//pokud neexistuje parametr stranka v GETu, automaticky nastavíme první stránku v seznamu, array_keys nám vrátí všechny klíče 
    }                                                      //pomocí [0] vybereme z pole první klíč na seznamu
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seznamStranek[$idAktualniStranky]->getTitulek(); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"><!--vloženo z google fonts-->
    <link rel="shortcut icon" href="img/chef.png" type="image/x-icon">
</head>
<body>
    <header>
       <div class="container">

           <div class="headertop">
               <a href="tel:+420606123456">(+420) 606 123 456</a>
               <div class="ikony">
                <a href="#" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram-square"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter-square"></i></a>
               </div>
           </div>

           <a href="domu" class="logo">Prima<br />penzion</a>

           <div class="menu">
               <ul>
                    <?php
                        foreach($seznamStranek as $id => $stranka){
                            if($stranka->getMenu() != ""){
                                echo "<li><a href='$id'>{$stranka->getMenu()}</a></li>";
                            }
                        }
                    ?>
                   <!-- <li><a href="?stranka=domu">Domů</a></li>
                   <li><a href="?stranka=kontakt">Kontakt</a></li>
                   <li><a href="?stranka=rezervace">Rezervace</a></li>
                   <li><a href="?stranka=galerie">Galerie</a></li>
                   <li><a href="#">Blog</a></li> -->
               </ul>
           </div>
       </div>

       <img src="img/<?php echo $seznamStranek[$idAktualniStranky]->getObrazek(); ?>" alt="Penzion" />

    </header>

<?php

    require_once "./vendor/shortcode-init.php";
    $zprocesovanyObsah = ShortcodeProcessor::process($seznamStranek[$idAktualniStranky]->getObsah());

    echo $zprocesovanyObsah;

    // require_once "$idAktualniStranky.html";

?>

    <footer>
        <div class="pata">

            <div class="menu">
                <ul>
                    <?php
                        foreach($seznamStranek as $id => $stranka){
                            if($stranka->getMenu() != ""){
                                echo "<li><a href='$id'>{$stranka->getMenu()}</a></li>";
                            }
                        }
                    ?>
                    <!-- <li><a href="?stranka=domu">Domů</a></li>
                    <li><a href="?stranka=kontakt">Kontakt</a></li>
                    <li><a href="?stranka=rezervace">Rezervace</a></li>
                    <li><a href="?stranka=galerie">Galerie</a></li>
                    <li><a href="#">Blog</a></li> -->
                </ul>
            </div>

            <a href="domu" class="logo">Prima<br />Penzion</a>

            <div class="pataText">
                <p><i class="fas fa-map-pin"></i>
                    <a href="https://goo.gl/maps/K22c9UdYjDP7XVAT9" target="_blank">PrimaPenzion, Jablonského 2, Praha 7</a></p>
                <p><i class="fas fa-phone-alt"></i>
                    <a href="tel:773348790">773 348 790</a></p>
                <p><i class="fas fa-at fa-spin"></i>
                    <b>info@primapenzion.cz</b></p>
            </div>

            <div class="ikony">
                <a href="#" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram-square"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter-square"></i></a>
               </div>

        </div>
        <div class="copy">
            &copy; Copyright 2021
        </div>
    </footer>

    <script src="./vendor/jquery/jquery-3.6.0.min.js"></script>

    <?php
    
        require_once "./vendor/photoswipe-init.php";
    
    ?>
    
</body>
</html>
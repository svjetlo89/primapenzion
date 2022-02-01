<?php

    session_start();
    $chybneId = "";

    require_once "data.php";//připojíme seznam stránek

    if(array_key_exists("login-submit", $_POST)){//přihlášení uživatele
        
        if($_POST["username"] == "admin" && $_POST["heslo"] == "papousek90"){//kontrola údajů
            $_SESSION["uzivatel"] = $_POST["username"];//pokud souhlasí údaje vytvoříme session
        }
    }

    if(array_key_exists("logout", $_GET)){//odhlášení uživatele
        unset($_SESSION["uzivatel"]);//funkce která smaže položku v poli
        header("Location:?");//vyčištění URL od parametru pomocí header location, který nás přesměruje na stejnou stránku ale bez parametru
    }

    if(array_key_exists("stranka", $_GET)){//editace pro uživatele
        $idStranky = $_GET["stranka"];
        $instanceAktualniStranky = $seznamStranek[$idStranky];
    }

    if(array_key_exists("pridat", $_GET)){//uživatel chce přidat novou stránku
        $instanceAktualniStranky = new Stranka("", "", "", "");
    }

    if(array_key_exists("update-submit", $_POST)){//aktualizace webu pro uživatele
        $noveIdStranky = $_POST["input_id"];//aktualizace metadat
        $novyTitulekStranky = $_POST["input_titulek"];
        $noveMenuStranky = $_POST["input_menu"];
        $novyObrazekStranky = $_POST["input_obrazek"];

        $noveIdStranky = trim($noveIdStranky);//validace id pomocí funkce, která odebere všechny mezery před a po

        if($noveIdStranky == ""){
            $chybneId = "ID nemůže být prázdné";
        }else{
            $instanceAktualniStranky->setId($noveIdStranky);//nastavení dat z formuláře do instance
            $instanceAktualniStranky->setTitulek($novyTitulekStranky);
            $instanceAktualniStranky->setMenu($noveMenuStranky);
            $instanceAktualniStranky->setObrazek($novyObrazekStranky);

            $instanceAktualniStranky->aktualizovatDb($novyObrazekStranky);//převedení instance do DB

            $novyObsahStranky = $_POST["obsah-stranky"];//aktualizace obsahu
            $instanceAktualniStranky->setObsah($novyObsahStranky);

            header("Location:?stranka=$noveIdStranky");
        }
   
    }

    if(array_key_exists("delete", $_GET)){//smazání stránky pro uživatele
        $idStrankyKeSmazani = $_GET["delete"];//z URL zjistíme jaké id chce smazat
        $seznamStranek[$idStrankyKeSmazani]->smazSe();//sáhneme si na danou instanci pomocí zísakného id, která je uložena v poli $seznamStranek a zavoláme metodu smazSe()
        header("Location:?");//po smazání stránky chceme vyčistit URL
    }

    if(array_key_exists("novePoradi", $_POST)){//uživatel chce aktualizovat pořadí stránek
        Stranka::aktualizovatPoradiDb($_POST["novePoradi"]);//::se volá statická metoda
        exit;//protože se jedná o if, který obsluhuje ajax tak není třeba vykreslovat stránku a zavoláme exit, který přeruší generování html
    }

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>

    <?php
    
        if(array_key_exists("uzivatel", $_SESSION)){
            echo "Jste přihlášen.";
            echo "<a href='?logout=true'>Odhlásit se</a>";
            echo "<ul id='ul-stranek'>";
            foreach($seznamStranek as $instance){
                echo "<li id='{$instance->getId()}'>
                        <a href='?stranka={$instance->getId()}'>{$instance->getId()}</a>
                        <a href='?delete={$instance->getId()}'>[smazat]</a>
                    </li>";
            }
            echo "</ul>";

            echo "<a href='?pridat=true'>Nová stránka</a>";

            echo "<hr>";

            if(isset($instanceAktualniStranky)){//isset nám vrátí boolean a říká jestli proměnná existuje nebo ne
                
                echo $chybneId;

                ?>

                    <form method="post">
                        <label for="">ID: </label>
                        <input type="text" name="input_id" id="" value="<?php echo htmlspecialchars($instanceAktualniStranky->getId()); ?>">
                        <label for="">Titulek: </label>
                        <input type="text" name="input_titulek" id="" value="<?php echo htmlspecialchars($instanceAktualniStranky->getTitulek()); ?>">
                        <label for="">Menu: </label>
                        <input type="text" name="input_menu" id="" value="<?php echo htmlspecialchars($instanceAktualniStranky->getMenu()); ?>">
                        <label for="">Obrázek: </label>
                        <input type="text" name="input_obrazek" id="" value="<?php echo htmlspecialchars($instanceAktualniStranky->getObrazek()); ?>">
                        <textarea name="obsah-stranky" id="moucha" cols="30" rows="50">
                            <?php 
                                if($instanceAktualniStranky->getId() != ""){
                                    echo htmlspecialchars($instanceAktualniStranky->getObsah());
                                }
                            ?>
                        </textarea>
                        <input type="submit" name="update-submit" value="Aktualizovat web">
                    </form>

                <?php
            }

        }else{
            ?>        
            <form action="" method="post">
                <label for="">ID:</label>
                <input type="text" name="username" id="">
                <label for="">PW:</label>
                <input type="password" name="heslo" id="">
                <input type="submit" name="login-submit" value="Přihlásit se">
            </form>
            <?php
        }
    ?>

    <script src="./vendor/jquery/jquery-3.6.0.min.js"></script>

    <script src="./vendor/jquery-ui-1.13.1/jquery-ui.min.js"></script>

    <script src="./vendor/tinymce/js/tinymce/tinymce.min.js"></script>
    
    <script>
        //selector: #idtextareay
        tinymce.init({
            selector: "#moucha",
            plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
            image_advtab: true ,
            external_filemanager_path:"./vendor/filemanager/",
            external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"},
            filemanager_title:"Responsive Filemanager",
            entity_encoding:'raw',
            verify_html: false,
            content_css: "./css/style.css",
        });
    </script>

    <script src="./js/admin.js"></script>

</body>
</html>
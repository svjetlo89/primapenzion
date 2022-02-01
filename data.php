<?php

    //---k funkčnímu kódu je nutné vytvořit databázi a udělat import--//

    $db = new PDO(//vytvoření instance databáze
        "mysql:host=localhost;dbname=penzion;charset=utf8",//parametr kam se připojíme a jakou databázi použijeme
        "root",//přihlašovací jméno do databáze
        "",//heslo do databáze
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)//paramatr k zakomentování pomocí kterého vypisujeme chyby
    );

    class Stranka{
        protected $id;
        protected $titulek;
        protected $menu;
        protected $obrazek;
        protected $oldId;

        function __construct($argId, $argTitulek, $argMenu, $argObrazek){
            $this->id = $argId;
            $this->titulek = $argTitulek;
            $this->menu = $argMenu;
            $this->obrazek = $argObrazek;
        }

        static function aktualizovatPoradiDb($argSerazenePole){//statická metoda třídy Stranka
            foreach($argSerazenePole as $index => $idStranky){//dostali jsem pole seřazených id poté proiterujeme pole a pro každou položku uděláme update
                $query = $GLOBALS["db"]->prepare("UPDATE stranka SET poradi=? WHERE id=?");
                $query->execute([$index, $idStranky]);//po dokončení foreach máme tabulku v sql seřazenou tak jak uživatel chce
            }
        }

        function getId(){
            return $this->id;
        }

        function setId($argId){
            $this->oldId = $this->id;//před tím než si nové id přepíšeme, uložíme si staré
            $this->id = $argId;//přepis id
        }

        function getTitulek(){
            return $this->titulek;
        }

        function setTitulek($argTitulek){
            $this->titulek = $argTitulek;
        }

        function getMenu(){
            return $this->menu;
        }

        function setMenu($argMenu){
            $this->menu = $argMenu;
        }

        function getObrazek(){
            return $this->obrazek;
        }

        function setObrazek($argObrazek){
            $this->obrazek = $argObrazek;
        }

        function getObsah(){
            $query = $GLOBALS["db"]->prepare("SELECT * FROM stranka WHERE id=?");
            $query->execute([$this->id]);
            $row = $query->fetch();//pro jeden řádek použijeme fetch místo fetchAll
            return $row["obsah"];
            // return file_get_contents("$this->id.html");
        }

        function setObsah($novyObsah){
            $query = $GLOBALS["db"]->prepare("UPDATE stranka SET obsah=? WHERE id=?");
            $query->execute([$novyObsah, $this->id]);
            // file_put_contents($this->id.".html", $novyObsah);
        }

        function smazSe(){
            $query = $GLOBALS["db"]->prepare("DELETE FROM stranka WHERE id=?");//místo $db musíme použít $GLOBALS["db"], ptž uvnitř classy nevidíme proměnné, které jsou definované venku
            $query->execute([$this->id]);
        }

        function aktualizovatDb(){
            if($this->oldId != ""){
                $query = $GLOBALS["db"]->prepare("UPDATE stranka SET id=?, titulek=?, menu=?, obrazek=? WHERE id=?");
                $query->execute([$this->id, $this->titulek, $this->menu, $this->obrazek, $this->oldId]);
            }else{
                $query = $GLOBALS["db"]->prepare("SELECT MAX(poradi) AS 'max_poradi' FROM stranka");
                $query->execute();
                $row = $query->fetch();
                $nejyvssiAktualniPoradi = $row["max_poradi"];

                $query = $GLOBALS["db"]->prepare("INSERT stranka SET id=?, titulek=?, menu=?, obrazek=?, poradi=?");
                $query->execute([$this->id, $this->titulek, $this->menu, $this->obrazek, $nejyvssiAktualniPoradi + 1]);
            }
            
        }
    }

    $seznamStranek = [];//vytvoření prázdného pole
    $query = $db->prepare("SELECT * FROM stranka ORDER BY poradi");//připravíme příkaz do DB
    $query->execute();//spustíme příkaz
    $rowsStranka = $query->fetchAll();//vytáhneme data

    foreach($rowsStranka as $rowStranka){//do pole $seznamStranek vložíme instanci kde klíč bude id a hodnota bude nová instance
        $seznamStranek[$rowStranka["id"]] = new Stranka($rowStranka["id"],$rowStranka["titulek"],$rowStranka["menu"],$rowStranka["obrazek"]);
    }


    // $seznamStranek = [
    //     "domu" => new Stranka("domu", "PrimaPenzion", "Domů", "primapenzion-main.jpg"),
    //     "kontakt" => new Stranka("kontakt", "Kontakt", "Napište nám", "primapenzion-pool-min.jpg"),
    //     "rezervace" => new Stranka("rezervace", "Rezervace", "Chci pokoj", "primapenzion-room.jpg"),
    //     "galerie" => new Stranka("galerie", "Galerie", "Fotogalerie", "primapenzion-room2.jpg"),
    // ]


    // $seznamStranek = [
    //         "domu" => ["PrimaPenzion", "Domů", "primapenzion-main.jpg"],
    //         "kontakt" => ["Kontakt", "Napište nám", "primapenzion-pool-min.jpg"],
    //         "rezervace" => ["Rezervace", "Chci pokoj", "primapenzion-room.jpg"],
    //         "galerie" => ["Galerie", "Fotogalerie", "primapenzion-room2.jpg"]
    //     ];

?>
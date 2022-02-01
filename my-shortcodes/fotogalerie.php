<div class="foto">

    <?php

        $slozka = "./vendor/source/galerie";
        $polozky = scandir($slozka);

        foreach($polozky as $polozka){
            if($polozka == "." || $polozka == ".."){

            }else{
                echo "<a href='$slozka/$polozka'><img src='$slozka/$polozka' alt='$polozka' /></a>";
            }   
        }
    ?>
    
</div>

<!-- <img src="img/img1-min.jpg" alt="foto1" /> 
<img src="img/img2-min.jpg" alt="foto2" /> 
<img src="img/img3-min.jpg" alt="foto3" /> 
<img src="img/img4-min.jpg" alt="foto4" /> 
<img src="img/img5-min.jpg" alt="foto5" /> 
<img src="img/img6-min.jpg" alt="foto6" /> 
<img src="img/img7-min.jpg" alt="foto7" /> 
<img src="img/img8-min.jpg" alt="foto8" /> -->
<?php

    if(array_key_exists("kontakt-submit", $_POST)){
        if(strlen($_POST["jmeno"]) < 2){
            echo "<div>Moc krátké jméno!</div>";
        }
        if(strlen($_POST["prijmeni"]) < 2){
            echo "<div>Moc krátké příjmení!</div>";
        }
        if(strlen($_POST["mail"]) < 2){
            echo "<div>Moc krátký email!</div>";
        }
        if(strlen($_POST["vzkaz"]) < 2){
            echo "<div>Moc krátký vzkaz!</div>";
        }
    }

?>

<form id="holub" action="#" method="post">
    <input type="text" name="jmeno" placeholder="Jméno" />
    <div class="jmeno-error error-form"></div>
    <input type="text" name="prijmeni" placeholder="Příjmení" /> 
    <div class="prijmeni-error error-form"></div>
    <input type="email" name="mail" placeholder="E-mail" /> 
    <div class="email-error error-form"></div>
    <textarea name="vzkaz" placeholder="Napište nám"></textarea>
    <div class="vzkaz-error error-form"></div>
    <input type="submit" name="kontakt-submit" />
</form>

<script>

    function validateEmail(email){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return re.test(String(email).toLowerCase());
    }

    //js kód který validuje formulář
    let tlacitko = document.querySelectorAll("[name=kontakt-submit]")[0];

    tlacitko.addEventListener("click", (event) => {
        event.preventDefault();//zabrání odeslání formuláře

        let validni = true;//proměnná říkající zda jsou všechna data správná

        document.querySelectorAll(".error-form").forEach((element) => {//promazání chybových hlášek
            element.innerHTML = "";
        })

        let inputJmeno = document.querySelectorAll("[name=jmeno]")[0];//validace inputů
        let inputPrijmeni = document.querySelectorAll("[name=prijmeni]")[0];
        let inputEmail = document.querySelectorAll("[name=mail]")[0];
        let inputVzkaz = document.querySelectorAll("[name=vzkaz]")[0];

        console.log(inputJmeno.value);
        console.log(inputPrijmeni.value);
        console.log(inputEmail.value);
        console.log(inputVzkaz.value);

        if(inputJmeno.value.length < 2){
            document.querySelectorAll(".jmeno-error")[0].innerHTML = "Jméno je nevalidní";
            validni = false;
        }

        if(inputPrijmeni.value.length < 2){
            document.querySelectorAll(".prijmeni-error")[0].innerHTML = "Příjmení je nevalidní";
            validni = false;
        }

        if(validateEmail(inputEmail.value) == false){
            document.querySelectorAll(".email-error")[0].innerHTML = "Email je nevalidní";
            validni = false;
        }

        if(inputVzkaz.value.length < 2){
            document.querySelectorAll(".vzkaz-error")[0].innerHTML = "Vzkaz je nevalidní";
            validni = false;
        }

        if(validni == true){
            let formular = document.querySelectorAll("#holub")[0];
            formular.submit();
        }


    })
</script>
$("#ul-stranek").sortable({//proměníme ul s id "ul-stranek" na sortable list
    update: () => {//update nám říká co se má stát pokud dojde ke změně pořadí li

        let serazenePole = $("#ul-stranek").sortable("toArray");//zde se nám uloží pole seřazených id
        console.log(serazenePole);

        $.$.ajax({//pošleme ajaxový požadavek na server
            type: "post",
            url: "admin.php",
            data: {
                novePoradi: serazenePole
            }
        });
    }
});


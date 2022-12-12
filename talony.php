<?php
require_once('db.php');

$stmt = $db->prepare('SELECT id, imie, nazwisko, klasa, ilosc FROM talony ORDER BY nazwisko');
$stmt->execute();
$produkty = $stmt->fetchAll();


$imie = $_POST["imie"] ?? null;
$nazwisko = $_POST["nazwisko"] ?? null;
$klasa = $_POST["klasa"] ?? null;
$dodany = FALSE;

if($imie != null && $nazwisko != null && $klasa != null){
    foreach($produkty as $p){
        if($imie == $p['imie'] && $nazwisko == $p['nazwisko'] && $klasa == $p['klasa']){
            $stmt = $db->prepare('UPDATE talony SET ilosc=:ilosc_talonow WHERE id=:id');
            $stmt->execute([
                'ilosc_talonow' => $p['ilosc'] + 1,
                'id' => $p['id'], 
            ]);
            $dodany = TRUE;
            header("Location: talony.php");
        }
    }
    if(!$dodany){
        $stmt = $db->prepare('INSERT INTO talony(imie, nazwisko, ilosc, klasa) VALUES (:imie, :nazwisko, :ilosc, :klasa)');
        $stmt->execute([
            'imie' => $imie,
            'nazwisko' => $nazwisko,
            'ilosc' => 1,
            'klasa' => $klasa,
        ]);
        header("Location: talony.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script
    src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous"></script>

    <style>

        input#nazwisko {
            width: 300px;
            height: 70px;
            font-size: 40px;
            margin: 0px;
            text-align: center;
        }
        input#imie {
            width: 300px;
            height: 70px;
            font-size: 40px;
            margin: 0px;
            text-align: center;
        }
        input#klasa {
            width: 100px;
            height: 70px;
            font-size: 40px;
            margin: 0px;
            text-align: center;
        }

        div.scrollbar_div2 {
            height: 350px;
            width: 700px;  
            border-style: solid;
        }

    </style>

</head>
<body>
    <form action="talony.php" method="post">
        <input type="text" id="imie" name="imie" placeholder="Imie" title="Type in a name">
        <input type="text" id="nazwisko" name="nazwisko" onkeyup="myFunction()" placeholder="Nazwisko" title="Type in a name">
        <input type="text" id="klasa" name="klasa" placeholder="Klasa" title="Type in a name">
        <button>Dodaj talon</button>
    </form>

        <div class="scrollbar_div2">
            <div id="lista">
                <?php

                    #tu będzie for który wypisuje wszystkie produkty z bazydanych

                    foreach($produkty as $p){
                ?>

                        <li><a id='<?= "{$p['id']}" ?>'> <?= "{$p['nazwisko']}" ?> <?= "{$p['imie']}" ?> <?= "{$p['klasa']}" ?>: <?= "{$p['ilosc']}" ?></a></li>

                <?php
                    }

                ?>
            </div>
        </div>

<script>

function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("nazwisko");
    filter = input.value.toUpperCase();
    ul = document.getElementById("lista");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

</script>
</body>
</html>
<?php
require_once('db.php');

$id = $_POST['id'] ?? null;
$nazwa = $_POST['nazwa'] ?? null;
$delete = $_POST['usun'] ?? null;

if($id != null && $delete == null){
    $stmt = $db->prepare('SELECT id, nazwa FROM remaining_items WHERE id=:id ORDER BY nazwa');
    $stmt->execute([
        'id' => $id,
    ]);
    $produkty = $stmt->fetchAll();
    
    $delete = null;

} elseif($id != null && $delete == 1){
    $stmt = $db->prepare('INSERT INTO used_items (id, nazwa) values (:id, :nazwa)');
    $stmt->execute([
        'id' => $id,
        'nazwa' => $nazwa,
    ]);

    $stmt = $db->prepare('DELETE FROM remaining_items WHERE id=:id');
    $stmt->execute([
        'id' => $id,
    ]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
    <title>Renament</title>
</head>
<body>
<form action="index.php" method="post">
    <input type="number" name="id" placeholder="Wpisz numer">
</form>  

<div class="scrollbar_div">
    <div id="lista">
        <?php

            #tu będzie for który wypisuje wszystkie produkty z bazydanych
            if($id != null && $delete == null){
                foreach($produkty as $p){
        ?>

                <li><a id='<?= "{$p['id']}" ?>'> <?= "{$p['nazwa']}" ?> </a></li>

        <?php
                }
            }
        ?>
    </div>
</div>
    <form action="index.php" method="post">
        <input type="hidden" name="id" value=<?php if($id != null && $delete == null) echo $p['id'];?>>
        <input type="hidden" name="nazwa" value=<?php if($id != null && $delete == null) echo $p['nazwa']; ?>>
        <input type="hidden" name="usun" value="1">
        <button>Usuń</button>
    </form>

    <button>Nie usuwaj</button>
</body>
</html>
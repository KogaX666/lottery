<?php
require_once('db.php');

$id = $_POST['id'] ?? null;
$nazwa = $_POST['nazwa'] ?? null;
$delete = $_POST['usun'] ?? null;
$produkty = null;

if($id != null && $delete == null){
    $stmt = $db->prepare('SELECT id, nazwa FROM remaining_items WHERE id=:id ORDER BY nazwa');
    $stmt->execute([
        'id' => $id,
    ]);
    $produkty = $stmt->fetchAll();
    
    $delete = null;

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
    <title>Lottery</title>
</head>
<body>
<form action="index.php" method="post">
    <input type="number" name="id" placeholder="Wpisz numer">
</form>  

<div class="scrollbar_div">
    <div id="lista">
        <?php
            if($produkty == null){
                echo "<h3>Produktu o takim id nie ma w bazie</h3>";
            
            #tu będzie for który wypisuje wszystkie produkty z bazydanych
            }elseif($id != null && $delete == null){
                foreach($produkty as $p){
        ?>

                <li><a id='<?= "{$p['id']}" ?>'> <?= "{$p['id']} {$p['nazwa']}" ?> </a></li>

        <?php
                }
            }
        ?>
    </div>
</div>
<div class="buttons">
    <form action="delete.php" method="post">
        <input type="hidden" name="id" value=<?php if($produkty != null && $delete == null) echo $p['id'];?>>
        <input type="hidden" name="nazwa" value=<?php if($produkty != null && $delete == null) echo $p['nazwa']; ?>>
        <input type="hidden" name="usun" value="1">
        <button class="usun">Usuń</button>
    </form>

    <form action="index.php" method="post">
        <input type="hidden" name="id" value="0">
        <button class="nieusun">Nie usuwaj</button>
    </form>
</div>

    <a href="add.php"><button>Dodaj z pliku</button></a>

</body>
</html>
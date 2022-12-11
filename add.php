<?php
require_once('db.php');

$url = $_POST["url"] ?? null;
$liczba = null;
$id = array();
$nazwa = array();


if($url != null){
    $myfile = fopen($url, "r") or die("Unable to open file!");
    while(!feof($myfile)) {
        $str = fgets($myfile);
        $temp = "";
        for($i = 0; $i < strlen($str); $i++){
            if($str[$i] != " " && $liczba == null){
                $temp = $temp.$str[$i];
            } else if($liczba){
                $temp = $temp.$str[$i];

                if($str[$i] == "\n"){
                    array_push($nazwa, $temp);
                    $liczba = null;
                }

            } else {
                array_push($id, $temp);
                $liczba = TRUE;
                $temp = "";
            }

        }
    }
    fclose($myfile);
    for($i = 0; $i < count($id); $i++){
        $stmt = $db->prepare('INSERT INTO remaining_items (id, nazwa) values (:id, :nazwa)');
        $stmt->execute([
            'id' => $id[$i],
            'nazwa' => $nazwa[$i],
        ]);
    }
    header("Location: index.php")
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="add.php" method="post">

        <input type="text" name="url" id="url">
        <button type="submit">Dodaj z lokalizacji</button>

    </form>

</body>
</html>
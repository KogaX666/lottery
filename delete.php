<?php
require_once('db.php');

$id = $_POST['id'] ?? null;
$nazwa = $_POST['nazwa'] ?? null;

$stmt = $db->prepare('INSERT INTO used_items (id, nazwa) values (:id, :nazwa)');
$stmt->execute([
    'id' => $id,
    'nazwa' => $nazwa,
]);

$stmt = $db->prepare('DELETE FROM remaining_items WHERE id=:id');
$stmt->execute([
    'id' => $id,
]);

header("Location: index.php");
?>
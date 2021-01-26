<?php
session_start();

$text = $_POST['text'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=marlindev_1level_9task', 'root', 'root');
} catch ( PDOException $e ) {
    echo "Error: " . $e->getMessage() . '<br/>';
    die;
}

$sql = "INSERT INTO content (text) VALUES (:text)";
$stmt = $pdo->prepare( $sql );
$stmt->execute( [ 'text' => $text ] );

header( 'Location: /level-1/task_9.php');
<?php
session_start();

$text = $_POST['text'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=marlindev_1level_9task', 'root', 'root');
} catch ( PDOException $e ) {
    echo "Error: " . $e->getMessage() . '<br/>';
    die;
}

$sql = "SELECT * FROM content WHERE text=:text";
$stmt = $pdo->prepare( $sql );
$stmt->execute( [ 'text' => $text ] );
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ( !empty($result) ) {
    $_SESSION['danger'] = "You should check in on some of those fields below.";
    header( "Location: /level-1/task_10.php" );
    exit;
}

$_SESSION['success'] = "Text has been inserted in database.";

$sql = "INSERT INTO content (text) VALUES (:text)";
$stmt = $pdo->prepare( $sql );
$stmt->execute( [ 'text' => $text ] );

header( 'Location: /level-1/task_10.php');
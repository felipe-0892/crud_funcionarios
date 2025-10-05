<?php

include 'config/db.php';

$id = $_GET['id'];
$sql = "DELETE FROM funcionarios WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../dashboard.php");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "crud_funcionarios"; 


$conn = new mysqli($servername, $username, $password, $dbname);
// echo "Conexão bem-sucedida!";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
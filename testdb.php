<?php
require 'db.php';

$sql = "SELECT 1";
$result = $conn->query($sql);

if ($result) {
    echo "<h1>¡Conexión exitosa a AlwaysData!</h1>";
} else {
    echo "Error al ejecutar consulta.";
}
?>

<?php
// Configuración de cabeceras para CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Ledesma160403"; // Tu contraseña de MySQL (si la tienes)
$dbname = "taskmaster";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'error' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Consulta SQL
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

// Procesar resultados
if ($result->num_rows > 0) {
    $tasks = [];
    while($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    echo json_encode($tasks);
} else {
    echo json_encode([]); // Devuelve array vacío si no hay tareas
}

$conn->close();
?>
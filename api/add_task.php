<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Conexión a la base de datos (mismo código que en get_task.php)
$conn = new mysqli("localhost", "root", "", "taskmaster");
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'error' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Leer datos del POST
$data = json_decode(file_get_contents("php://input"), true);

// Validar y sanitizar
if (empty($data['text'])) {
    die(json_encode([
        'success' => false,
        'error' => 'Text is required'
    ]));
}

$text = $conn->real_escape_string($data['text']);

// Insertar en la base de datos
$sql = "INSERT INTO tasks (text) VALUES ('$text')";
if ($conn->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Insert failed: ' . $conn->error
    ]);
}

$conn->close();
?>
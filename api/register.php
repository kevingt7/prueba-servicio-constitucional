<?php
include 'db.php';

$response = ['status' => 'error', 'message' => 'Error en el registro'];

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param('ss', $email, $password);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Usuario registrado con éxito'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error al registrar usuario'];
    }
    $stmt->close();
}

echo json_encode($response);
?>

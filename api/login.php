<?php
header('Content-Type: application/json');
session_start();
include 'db.php';

$response = ['status' => 'error', 'message' => 'Inicio de sesión fallido'];

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $response = ['status' => 'success', 'message' => 'Inicio de sesión exitoso', 'user_id' => $user['id']];
    } else {
        $response = ['status' => 'error', 'message' => 'Correo o contraseña incorrectos'];
    }
    $stmt->close();
}

echo json_encode($response);
?>
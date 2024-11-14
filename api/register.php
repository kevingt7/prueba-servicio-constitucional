<?php  
header('Content-Type: application/json');  
session_start();  
include 'db.php';  

// Verifica que se reciban los datos
if (isset($_POST['email']) && isset($_POST['password'])) {  
    $email = $_POST['email'];  
    $password = $_POST['password'];  

    // Prepara la consulta para verificar si el correo ya está registrado
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Si ya existe un usuario con ese correo, no permite registrar
    if ($result->num_rows > 0) {
        $response = ['status' => 'error', 'message' => 'El correo ya está registrado'];
    } else {
        // Si el correo no está registrado, inserta el nuevo usuario
        $stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $email, $password);
        
        if ($stmt->execute()) {
            // Registro exitoso
            $response = ['status' => 'success', 'message' => 'Usuario registrado con éxito'];
        } else {
            // Error al registrar
            $response = ['status' => 'error', 'message' => 'Error al registrar usuario'];
        }
    }
    // Cierra la declaración preparada
    $stmt->close();
} else {
    // Si faltan datos
    $response = ['status' => 'error', 'message' => 'Faltan datos para el registro'];
}

// Envía la respuesta en formato JSON al cliente
echo json_encode($response);
?>

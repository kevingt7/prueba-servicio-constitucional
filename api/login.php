<?php  
header('Content-Type: application/json');  
session_start();    
include 'db.php';   
// Verifica que se reciban los campos 
if (isset($_POST['email']) && isset($_POST['password'])) {  
    // Almacena los datos recibidos en variables  
    $email = $_POST['email'];  
    $password = $_POST['password'];  
 
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");  
    $stmt->bind_param('ss', $email, $password); // vincula los parámetros a la consulta  
    $stmt->execute(); // Ejecuta

    // obtiene el resultado de la consulta  
    $result = $stmt->get_result();  
    $user = $result->fetch_assoc(); // extrae la información del usuario asociada a los resultados  

    // Verifica si se encontró un usuario  
    if ($user) {  
        // si se encuentra el usuario, guarda su ID en la sesión  
        $_SESSION['user_id'] = $user['id'];  
        // respuesta de éxito con el ID del usuario  
        $response = [  
            'status' => 'success',  
            'message' => 'Inicio de sesión exitoso',  
            'user_id' => $user['id']  
        ];  
    } else {  
        // Si no se encuentra, establece el mensaje de error correspondiente  
        $response = ['status' => 'error', 'message' => 'Correo o contraseña incorrectos'];  
    }  

    // Cierra la declaración preparada  
    $stmt->close();  
}  

// Envía la respuesta en formato JSON al cliente  
echo json_encode($response);  
?>
<?php
session_start();
include 'db.php';

$response = ['status' => 'error', 'message' => 'Acción no válida'];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_task':
                if (isset($_POST['task'])) {
                    $task = $_POST['task'];
                    $stmt = $conn->prepare("INSERT INTO tasks (user_id, description, completed) VALUES (?, ?, 0)");
                    $stmt->bind_param('is', $user_id, $task);

                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Tarea añadida'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Error al añadir tarea'];
                    }
                    $stmt->close();
                }
                break;

            case 'get_tasks':
                $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $tasks = $result->fetch_all(MYSQLI_ASSOC);
                $response = ['status' => 'success', 'tasks' => $tasks];
                $stmt->close();
                break;

            case 'update_task':
                if (isset($_POST['task_id'], $_POST['completed'])) {
                    $task_id = $_POST['task_id'];
                    $completed = $_POST['completed'];

                    $stmt = $conn->prepare("UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?");
                    $stmt->bind_param('iii', $completed, $task_id, $user_id);

                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Tarea actualizada'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Error al actualizar tarea'];
                    }
                    $stmt->close();
                }
                break;

            case 'delete_task':
                if (isset($_POST['task_id'])) {
                    $task_id = $_POST['task_id'];

                    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
                    $stmt->bind_param('ii', $task_id, $user_id);

                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Tarea eliminada'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Error al eliminar tarea'];
                    }
                    $stmt->close();
                }
                break;
        }
    }
}

echo json_encode($response);
?>

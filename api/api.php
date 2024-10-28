<?php
include 'db.php';
session_start();

$response = ['status' => 'error', 'message' => 'Invalid action'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'register':
            if (isset($_POST['email'], $_POST['password'])) {
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $password);

                if ($stmt->execute()) {
                    $response = ['status' => 'success', 'message' => 'User registered successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to register user'];
                }

                $stmt->close();
            }
            break;

        case 'login':
            if (isset($_POST['email'], $_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $response = ['status' => 'success', 'message' => 'Login successful'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid email or password'];
                }

                $stmt->close();
            }
            break;

        case 'add_task':
            if (isset($_SESSION['user_id'], $_POST['task'])) {
                $user_id = $_SESSION['user_id'];
                $task = $_POST['task'];

                $stmt = $conn->prepare("INSERT INTO tasks (user_id, description, completed) VALUES (?, ?, 0)");
                $stmt->bind_param("is", $user_id, $task);

                if ($stmt->execute()) {
                    $response = ['status' => 'success', 'message' => 'Task added successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to add task'];
                }

                $stmt->close();
            }
            break;

        case 'get_tasks':
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];

                $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $tasks = $result->fetch_all(MYSQLI_ASSOC);

                $response = ['status' => 'success', 'tasks' => $tasks];

                $stmt->close();
            }
            break;

        case 'update_task':
            if (isset($_POST['task_id'], $_POST['completed'])) {
                $task_id = $_POST['task_id'];
                $completed = $_POST['completed'];

                $stmt = $conn->prepare("UPDATE tasks SET completed = ? WHERE id = ?");
                $stmt->bind_param("ii", $completed, $task_id);

                if ($stmt->execute()) {
                    $response = ['status' => 'success', 'message' => 'Task updated'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to update task'];
                }

                $stmt->close();
            }
            break;

        case 'delete_task':
            if (isset($_POST['task_id'])) {
                $task_id = $_POST['task_id'];

                $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
                $stmt->bind_param("i", $task_id);

                if ($stmt->execute()) {
                    $response = ['status' => 'success', 'message' => 'Task deleted'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete task'];
                }

                $stmt->close();
            }
            break;

        default:
            $response = ['status' => 'error', 'message' => 'Unknown action'];
    }
}

echo json_encode($response);
?>

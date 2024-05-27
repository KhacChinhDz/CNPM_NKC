<?php
include 'db_connect.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $delete = $conn->query("DELETE FROM users WHERE id = $id");

    if ($delete) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không thể xóa người dùng.']);
    }
}
?>

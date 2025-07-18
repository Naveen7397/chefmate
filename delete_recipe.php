<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM saved_recipes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Recipe deleted successfully.'); window.location.href='saved_recipes.php';</script>";
    } else {
        echo "<script>alert('Failed to delete.'); window.location.href='saved_recipes.php';</script>";
    }
    $stmt->close();
}
?>

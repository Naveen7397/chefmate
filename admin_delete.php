<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM saved_recipes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Recipe deleted successfully.'); window.location.href='admin_panel.php';</script>";
    } else {
        echo "<script>alert('Failed to delete.'); window.location.href='admin_panel.php';</script>";
    }

    $stmt->close();
}
?>

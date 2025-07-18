<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $recipe = $_POST['recipe'];

    $stmt = $conn->prepare("INSERT INTO saved_recipes (user_id, title, ingredients, recipe, saved_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isss", $user_id, $title, $ingredients, $recipe);

    if ($stmt->execute()) {
        echo "<script>alert('Recipe saved successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error saving recipe.'); window.location.href='dashboard.php';</script>";
    }
    $stmt->close();
} else {
    header("Location: dashboard.php");
    exit;
}
?>

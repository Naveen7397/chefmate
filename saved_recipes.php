<?php
session_start();
include "includes/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Handle Delete Action
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM saved_recipes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    header("Location: saved_recipes.php");
    exit();
}

// ✅ Handle Mark as Cooked
if (isset($_GET['cooked_id'])) {
    $cooked_id = intval($_GET['cooked_id']);
    $stmt = $conn->prepare("UPDATE saved_recipes SET cooked = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cooked_id, $user_id);
    $stmt->execute();
    header("Location: saved_recipes.php");
    exit();
}

// ✅ Handle Mark as Favorite
if (isset($_GET['favorite_id'])) {
    $favorite_id = intval($_GET['favorite_id']);
    $stmt = $conn->prepare("UPDATE saved_recipes SET favorite = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $favorite_id, $user_id);
    $stmt->execute();
    header("Location: saved_recipes.php");
    exit();
}

// ✅ Fetch Saved Recipes
$stmt = $conn->prepare("SELECT id, recipe_name, ingredients, saved_at, cooked, favorite FROM saved_recipes WHERE user_id = ? ORDER BY saved_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Saved Recipes - ChefMate</title>
<style>
body {font-family: Arial, sans-serif; background:#f8f8f8; padding:20px; margin:0;}
.container {max-width:800px; margin:0 auto; background:#fff; padding:20px; border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.recipe {border-bottom:1px solid #ddd; padding:10px 0; display:flex; justify-content:space-between; align-items:center;}
h2 {color:#e67e22; text-align:center;}
<h2>❤️ Saved Recipes</h2>
<p style="text-align:center;">
    <a href="favorites.php" style="color:#e67e22; font-weight:bold; text-decoration:none;">⭐ View Favorite Recipes</a>
</p>

h3 {color:#333; margin:0;}
p {color:#555; margin:5px 0;}
.time {font-size:12px; color:#999;}
.delete-btn {background:#ff4d4d; color:#fff; padding:5px 10px; text-decoration:none; border-radius:5px; font-size:13px;}
.delete-btn:hover {background:#e60000;}
.cooked-btn {background:#4CAF50; color:#fff; padding:5px 10px; text-decoration:none; border-radius:5px; font-size:13px; margin-right:5px;}
.cooked-btn:hover {background:#388E3C;}
.favorite-btn {background:#FFD700; color:#000; padding:5px 10px; text-decoration:none; border-radius:5px; font-size:13px; margin-right:5px;}
.favorite-btn:hover {background:#e6c200;}
.status {color:green; font-weight:bold;}
.favorite-status {color:#e6c200; font-weight:bold;}
.back {display:block; text-align:center; margin-top:20px; text-decoration:none;
background:#e67e22; color:#fff; padding:10px; border-radius:5px;}
.back:hover {background:#cf711f;}
</style>
</head>
<body>
<div class="container">
<h2>❤️ Saved Recipes</h2>
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<div class='recipe'>";
        echo "<div>";
        echo "<h3>".$row['recipe_name']."</h3>";
        echo "<p><strong>Ingredients:</strong> ".$row['ingredients']."</p>";
        echo "<p class='time'>Saved on: ".$row['saved_at']."</p>";
        if($row['cooked'] == 1){
            echo "<p class='status'>✅ Cooked</p>";
        }
        if($row['favorite'] == 1){
            echo "<p class='favorite-status'>⭐ Favorite</p>";
        }
        echo "</div>";
        echo "<div>";
        if($row['cooked'] == 0){
            echo "<a class='cooked-btn' href='saved_recipes.php?cooked_id=".$row['id']."'>✅ Mark Cooked</a> ";
        }
        if($row['favorite'] == 0){
            echo "<a class='favorite-btn' href='saved_recipes.php?favorite_id=".$row['id']."'>⭐ Mark Favorite</a> ";
        }
        echo "<a class='delete-btn' href='saved_recipes.php?delete_id=".$row['id']."' onclick='return confirm(\"Delete this recipe?\");'>🗑 Delete</a>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No saved recipes yet.</p>";
}
?>
<a href="index.php" class="back">⬅ Back to Home</a>
</div>
<?php include "includes/footer.php"; ?>

</body>
</html>

<?php
session_start();
include "includes/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch only Favorite Recipes (Latest First)
$stmt = $conn->prepare("SELECT recipe_name, ingredients, saved_at, image FROM saved_recipes WHERE user_id = ? AND favorite = 1 ORDER BY saved_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>⭐ Favorite Recipes - ChefMate</title>
<style>
body {font-family: Arial, sans-serif; background:#f8f8f8; margin:0; padding:20px;}
.container {max-width:1000px; margin:0 auto;}
h2 {color:#e67e22; text-align:center; margin-bottom:20px;}
.grid {display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px;}
.card {background:#fff; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1); overflow:hidden; transition:transform 0.2s;}
.card:hover {transform:scale(1.03);}
.card img {width:100%; height:150px; object-fit:cover;}
.card-content {padding:10px;}
.card h3 {font-size:18px; margin:0; color:#333;}
.card p {font-size:14px; color:#555; margin:5px 0;}
.time {font-size:12px; color:#999;}
.back {display:block; text-align:center; margin-top:20px; text-decoration:none;
background:#e67e22; color:#fff; padding:10px; border-radius:5px; width:200px; margin-left:auto; margin-right:auto;}
.back:hover {background:#cf711f;}
</style>
</head>
<body>
<div class="container">
<h2>⭐ Favorite Recipes</h2>
<div class="grid">
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $img = (!empty($row['image'])) ? $row['image'] : "images/default.jpg"; // fallback image
        echo "<div class='card'>";
        echo "<img src='".$img."' alt='".$row['recipe_name']."'>";
        echo "<div class='card-content'>";
        echo "<h3>".$row['recipe_name']."</h3>";
        echo "<p><strong>Ingredients:</strong> ".substr($row['ingredients'],0,40)."...</p>";
        echo "<p class='time'>⭐ Marked Favorite on: ".$row['saved_at']."</p>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p style='grid-column:1/-1; text-align:center;'>No favorite recipes yet.</p>";
}
?>
</div>
<a href="saved_recipes.php" class="back">⬅ Back to Saved Recipes</a>
</div>
<?php include "includes/footer.php"; ?>

</body>
</html>

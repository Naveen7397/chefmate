<?php
session_start();
include "includes/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Delete recipe if requested
if(isset($_GET['delete'])){
    $delete = $conn->prepare("DELETE FROM saved_recipes WHERE user_id = ? AND recipe_name = ?");
    $delete->bind_param("is", $_SESSION['user_id'], $_GET['delete']);
    $delete->execute();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT recipe_name, ingredients FROM saved_recipes WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Saved Recipes - ChefMate</title>
<style>
body {font-family: Arial, sans-serif; background:#f8f8f8; padding:20px;}
.container {max-width:800px; margin:0 auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.recipe {border-bottom:1px solid #ddd; padding:15px 0; display:flex; align-items:center; justify-content:space-between;}
.recipe img {width:80px; height:80px; border-radius:5px; object-fit:cover; margin-right:15px; border:1px solid #ccc;}
.recipe h3 {color:#333; margin:0;}
.recipe p {color:#666; font-size:14px; margin:5px 0;}
.delete-btn {background:#ff4d4d; color:#fff; padding:5px 10px; border-radius:5px; text-decoration:none; font-size:13px;}
.delete-btn:hover {background:#d93636;}
h2 {color:#e67e22; text-align:center;}
.back {display:block; text-align:center; margin-top:20px; text-decoration:none; background:#e67e22; color:#fff; padding:10px; border-radius:5px;}
.back:hover {background:#cf711f;}
</style>
</head>
<body>
<div class="container">
<h2>Saved Recipes</h2>
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $img_name = strtolower(str_replace(' ', '_', $row['recipe_name'])) . ".jpg";
        echo "<div class='recipe'>
                <div style='display:flex;align-items:center;'>
                    <img src='images/$img_name' alt='".$row['recipe_name']."'>
                    <div>
                        <h3>".$row['recipe_name']."</h3>
                        <p><strong>Ingredients:</strong> ".$row['ingredients']."</p>
                    </div>
                </div>
                <a class='delete-btn' href='view_recipes.php?delete=".urlencode($row['recipe_name'])."'>Delete</a>
              </div>";
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

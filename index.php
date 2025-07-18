<?php
session_start();
include "includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ChefMate - Home</title>
<style>
body {font-family: Arial, sans-serif; background:#f8f8f8; margin:0; padding:0;}
.header {background:#e67e22; color:#fff; padding:15px; text-align:center; font-size:24px;}
.container {max-width:1100px; margin:20px auto; padding:20px; background:#fff; border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.grid {display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px;}
.card {background:#fff; border:1px solid #eee; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.1);}
.card img {width:100%; height:150px; object-fit:cover;}
.card-body {padding:10px; text-align:center;}
.card-body h3 {font-size:18px; color:#333; margin:5px 0;}
.view-btn {display:inline-block; margin-top:5px; padding:8px 12px; background:#e67e22; color:#fff;
text-decoration:none; border-radius:5px; font-size:14px;}
.view-btn:hover {background:#cf711f;}
.nav {text-align:right; margin-bottom:10px;}
.nav a {margin:0 5px; color:#e67e22; text-decoration:none; font-weight:bold;}
</style>
</head>
<body>

<div class="header">🍽️ ChefMate</div>

<div class="container">
<div class="nav">
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="saved_recipes.php">❤️ Saved Recipes</a> | 
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> | 
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>

<h2 style="color:#e67e22;">Popular Recipes</h2>
<div class="grid">
<?php
$dishes = [
    "Paneer Butter Masala","Biryani","Dosa","Curry","Egg Curry","Fish Fry",
    "Aloo Paratha","Mutton Curry","Idli Sambar","Masala Dosa","Chicken65",
    "Rasam","Pongal","Chole Bhature","Pav Bhaji","Paneer Tikka",
    "Gobi Manchurian","Fried Rice","Veg Kurma","Rava Kesari"
];

foreach($dishes as $dish){
    $img = "images/".strtolower(str_replace(' ','_',$dish)).".jpg";
    echo "<div class='card'>
            <img src='$img' alt='$dish'>
            <div class='card-body'>
                <h3>$dish</h3>
                <a class='view-btn' href='recipe_details.php?dish=".urlencode($dish)."'>View Recipe</a>
            </div>
          </div>";
}
?>
</div>
</div>
<?php include "includes/footer.php"; ?>

</body>
</html>

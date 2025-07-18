<?php
session_start();
include "includes/db.php";

if (!isset($_GET['dish'])) {
    header("Location: index.php");
    exit();
}

$dish = $_GET['dish'];

// 🔥 Full 20 Recipes Data
$recipes = [
    "Paneer Butter Masala" => [
        "ingredients" => ["Paneer - 200g", "Butter - 2 tbsp", "Tomato puree - 1 cup", "Cream - 2 tbsp", "Spices"],
        "steps" => ["Heat butter, add spices", "Add tomato puree & cook 5 mins", "Add paneer & cream", "Serve hot with naan"]
    ],
    "Biryani" => [
        "ingredients" => ["Basmati Rice - 2 cups", "Chicken/Mutton - 500g", "Onion - 2 sliced", "Biryani masala - 2 tbsp", "Ghee"],
        "steps" => ["Cook rice 70% separately", "Cook meat with masala", "Layer rice & meat", "Dum cook 15 mins"]
    ],
    "Dosa" => [
        "ingredients" => ["Dosa batter - 2 cups", "Oil - 2 tsp", "Sambar", "Coconut Chutney"],
        "steps" => ["Heat tawa, pour batter", "Spread thin & cook till crispy", "Serve hot with sambar & chutney"]
    ],
    "Curry" => [
        "ingredients" => ["Vegetables/Meat - 250g", "Onion - 1 chopped", "Tomato - 1", "Curry powder - 1 tbsp"],
        "steps" => ["Fry onion & tomato", "Add curry powder & veggies", "Cook till soft", "Serve with rice"]
    ],
    "Egg Curry" => [
        "ingredients" => ["Eggs - 4 boiled", "Onion - 1", "Tomato - 1", "Masala - 1 tbsp"],
        "steps" => ["Fry onion, tomato, masala", "Add eggs & simmer 5 mins", "Serve with rice or chapati"]
    ],
    "Fish Fry" => [
        "ingredients" => ["Fish pieces - 4", "Chili powder - 1 tsp", "Turmeric", "Oil for frying"],
        "steps" => ["Marinate fish with masala", "Shallow fry both sides", "Serve hot with lemon"]
    ],
    "Aloo Paratha" => [
        "ingredients" => ["Wheat dough", "Boiled potato - 2", "Spices", "Butter"],
        "steps" => ["Mash potato with spices", "Stuff inside dough", "Roll & roast with butter"]
    ],
    "Mutton Curry" => [
        "ingredients" => ["Mutton - 500g", "Onion - 2", "Curry masala", "Oil"],
        "steps" => ["Fry onion & masala", "Add mutton & cook till tender", "Serve with rice"]
    ],
    "Idli Sambar" => [
        "ingredients" => ["Idli batter", "Toor dal - 1/2 cup", "Tamarind", "Sambar powder"],
        "steps" => ["Steam idlis", "Cook dal with sambar powder", "Add tamarind & veggies", "Serve with hot idli"]
    ],
    "Masala Dosa" => [
        "ingredients" => ["Dosa batter", "Potato masala", "Oil"],
        "steps" => ["Make dosa, fill potato masala", "Fold & roast", "Serve with chutney"]
    ],
    "Chicken65" => [
        "ingredients" => ["Chicken - 500g", "Chili powder - 1 tsp", "Cornflour", "Oil for frying"],
        "steps" => ["Marinate chicken", "Deep fry till crispy", "Serve hot"]
    ],
    "Rasam" => [
        "ingredients" => ["Tamarind water", "Rasam powder", "Tomato", "Coriander"],
        "steps" => ["Boil tamarind water with rasam powder", "Add tomato & coriander", "Serve with rice"]
    ],
    "Pongal" => [
        "ingredients" => ["Rice - 1 cup", "Moong dal - 1/2 cup", "Pepper", "Ghee", "Curry leaves"],
        "steps" => ["Cook rice & dal soft", "Add pepper, ghee", "Serve hot"]
    ],
    "Chole Bhature" => [
        "ingredients" => ["Chickpeas - 1 cup", "Onion", "Tomato", "Bhature dough"],
        "steps" => ["Cook chole masala", "Deep fry bhature", "Serve together"]
    ],
    "Pav Bhaji" => [
        "ingredients" => ["Mixed veggies", "Pav buns", "Butter", "Bhaji masala"],
        "steps" => ["Cook veggies with masala", "Mash well", "Toast pav in butter", "Serve with onion & lemon"]
    ],
    "Paneer Tikka" => [
        "ingredients" => ["Paneer cubes", "Curd - 2 tbsp", "Tikka masala", "Capsicum"],
        "steps" => ["Marinate paneer", "Grill or roast", "Serve hot with mint chutney"]
    ],
    "Gobi Manchurian" => [
        "ingredients" => ["Cauliflower florets", "Cornflour", "Soy sauce", "Chili sauce"],
        "steps" => ["Fry gobi till crispy", "Toss in sauce", "Serve hot"]
    ],
    "Fried Rice" => [
        "ingredients" => ["Cooked rice", "Veggies/Chicken", "Soy sauce", "Pepper"],
        "steps" => ["Stir fry veggies", "Add rice & sauce", "Toss well & serve"]
    ],
    "Veg Kurma" => [
        "ingredients" => ["Mixed vegetables", "Coconut paste", "Kurma masala"],
        "steps" => ["Cook veggies with masala", "Add coconut paste", "Serve with chapati"]
    ],
    "Rava Kesari" => [
        "ingredients" => ["Rava - 1 cup", "Sugar - 1 cup", "Ghee", "Cashews", "Kesari color"],
        "steps" => ["Roast rava in ghee", "Add sugar & water", "Cook till thick", "Garnish with cashews"]
    ]
];

// Get ingredients & steps
$ingredients = isset($recipes[$dish]) ? $recipes[$dish]['ingredients'] : ["No details found"];
$steps = isset($recipes[$dish]) ? $recipes[$dish]['steps'] : ["No steps available"];

// Handle Save Recipe
if (isset($_POST['save_recipe']) && isset($_SESSION['user_id'])) {
    $ingredients_str = implode(", ", $ingredients);
    $stmt = $conn->prepare("INSERT INTO saved_recipes (user_id, recipe_name, ingredients) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $_SESSION['user_id'], $dish, $ingredients_str);
    $stmt->execute();
    $msg = "✅ Recipe saved successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($dish); ?> - Recipe Details</title>
<style>
body {font-family: Arial, sans-serif; background:#f8f8f8; margin:0; padding:0;}
.container {max-width:1000px; margin:30px auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.header-img {width:100%; height:300px; object-fit:cover; border-radius:8px;}
h2 {color:#e67e22; margin-top:10px;}
.flex {display:flex; justify-content:space-between; margin-top:20px;}
.column {width:48%;}
.column h3 {color:#333; margin-bottom:10px;}
ul {list-style-type:square; padding-left:20px; color:#555;}
.steps li {margin-bottom:8px;}
.save-btn {display:inline-block; background:#e67e22; color:#fff; padding:10px 15px; margin-top:15px; text-decoration:none; border-radius:5px;}
.save-btn:hover {background:#cf711f;}
.msg {color:green; margin-top:10px;}
.back {display:inline-block; margin-top:15px; text-decoration:none; color:#e67e22;}
</style>
</head>
<body>
<div class="container">
<img class="header-img" src="images/<?php echo strtolower(str_replace(' ', '_', $dish)); ?>.jpg" alt="<?php echo htmlspecialchars($dish); ?>">
<h2><?php echo htmlspecialchars($dish); ?></h2>

<div class="flex">
    <div class="column">
        <h3>Ingredients</h3>
        <ul>
            <?php foreach ($ingredients as $ing) echo "<li>$ing</li>"; ?>
        </ul>
    </div>
    <div class="column">
        <h3>Steps</h3>
        <ul class="steps">
            <?php foreach ($steps as $step) echo "<li>$step</li>"; ?>
        </ul>
    </div>
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <form method="post">
        <button class="save-btn" name="save_recipe">💾 Save Recipe</button>
    </form>
    <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>
<?php else: ?>
    <p><a href="login.php" class="save-btn">🔑 Login to Save</a></p>
<?php endif; ?>

<a class="back" href="index.php">⬅ Back to Home</a>
</div>
</body>
</html>

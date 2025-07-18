<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ChefMate - Recipe Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: #fff0e5;
      font-family: 'Poppins', sans-serif;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-card {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(255, 107, 107, 0.3);
      max-width: 500px;
      width: 100%;
    }
    h2 {
      text-align: center;
      color: #ff6b6b;
      margin-bottom: 20px;
    }
    label {
      display: block;
      font-weight: 500;
      margin-bottom: 10px;
      color: #444;
    }
    select, textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 10px;
      margin-bottom: 20px;
      resize: vertical;
      font-size: 16px;
    }
    button {
      width: 100%;
      background: #ff6b6b;
      color: white;
      border: none;
      padding: 14px;
      border-radius: 25px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #e64545;
    }
  </style>
</head>
<body>

<div class="form-card">
  <h2>🍲 Smart Recipe Recommender</h2>
  <form method="POST" action="get_recipe.php">
    <label for="category">Select Category:</label>
    <select name="category" id="category" required>
      <option value="">-- Choose --</option>
      <option value="veg">🌿 Veg</option>
      <option value="nonveg">🍗 Non-Veg</option>
    </select>

    <label for="ingredients">Enter Ingredients:</label>
    <textarea name="ingredients" id="ingredients" rows="4" placeholder="e.g., tomato, onion, potato" required></textarea>

    <button type="submit">🔍 Get Recipe</button>
  </form>
</div>

</body>
</html>

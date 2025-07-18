<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include('includes/db.php');
$user_id = $_SESSION['user_id'];

// Get recipes for current user
$stmt = $conn->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Recipes - ChefMate</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fef6e4;
      padding: 40px;
    }
    .top {
      text-align: right;
      margin-bottom: 20px;
    }
    .recipe-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 20px;
    }
    .card {
      background: white;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 0 12px rgba(255, 204, 112, 0.3);
    }
    .card h3 {
      color: #ff6b6b;
    }
    .card p {
      text-align: left;
      white-space: pre-wrap;
      font-size: 14px;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="top">
    <a href="dashboard.php">← Back to Dashboard</a> |
    <a href="logout.php">Logout</a>
  </div>

  <h2>🍴 Your Saved Recipes</h2>

  <div class="recipe-container">
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="card">
        <h3><?php echo htmlspecialchars($row['recipe_title']); ?></h3>
        <strong>Ingredients:</strong>
        <p><?php echo htmlspecialchars($row['ingredients']); ?></p>
        <strong>Recipe:</strong>
        <p><?php echo htmlspecialchars($row['recipe']); ?></p>
        <small>Saved on: <?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></small>
      </div>
    <?php } ?>
  </div>

</body>
</html>

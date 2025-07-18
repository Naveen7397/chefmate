<?php
session_start();
include("includes/db.php");
include("includes/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user'] = $row['email'];
    $_SESSION['user_id'] = $row['id'];
    echo "<p style='color:green;'>Login successful!</p>";
    echo "<script>setTimeout(() => { window.location.href = 'index.php'; }, 1000);</script>";
  } else {
    echo "<p style='color:red;'>Invalid email or password.</p>";
  }
}
?>
<h2>Login to ChefMate</h2>
<form method="POST">
  <label>Email:</label><br>
  <input type="email" name="email" required><br><br>
  <label>Password:</label><br>
  <input type="password" name="password" required><br><br>
  <input type="submit" value="Login">
</form>
<?php include("includes/footer.php"); ?>

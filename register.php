<?php
include("includes/db.php");
include("includes/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Registration successful!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
}
?>
<h2>Register to ChefMate</h2>
<form method="POST">
  <label>Username:</label><br>
  <input type="text" name="username" required><br><br>
  <label>Email:</label><br>
  <input type="email" name="email" required><br><br>
  <label>Password:</label><br>
  <input type="password" name="password" required><br><br>
  <input type="submit" value="Register">
</form>
<?php include("includes/footer.php"); ?>

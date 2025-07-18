<?php
include('includes/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - ChefMate</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f0f5;
            padding: 40px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        h2 {
            text-align: center;
            color: #ff6b6b;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background: #ff6b6b;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📊 Admin Panel - Saved Recipes</h2>
        <table>
            <tr>
    <th>👤 Username</th>
    <th>🍽️ Recipe Title</th>
    <th>📆 Saved At</th>
    <th>🗑️ Action</th>
</tr>


            <?php
             $sql = "SELECT sr.id, sr.title, sr.saved_at, u.username FROM saved_recipes sr JOIN users u ON sr.user_id = u.id ORDER BY sr.saved_at DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
            <tr>
    <td><?php echo htmlspecialchars($row['username']); ?></td>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><?php echo date("d M Y, h:i A", strtotime($row['saved_at'])); ?></td>
    <td>
        <form method="post" action="admin_delete.php" onsubmit="return confirm('Are you sure to delete this recipe?');">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button style="background:#e64545;color:#fff;border:none;padding:6px 12px;border-radius:5px;">Delete</button>
        </form>
    </td>
</tr>

            <?php endwhile; else: ?>
            <tr><td colspan="3">No saved recipes found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>

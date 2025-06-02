<?php
// admin/manage_products.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once('../config/database.php');

$action = $_GET['action'] ?? '';
$error = '';

if ($action === 'create') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);

        if ($name === '' || $price <= 0) {
            $error = 'Please enter a valid name and price.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO products (name, description, price) VALUES (?, ?, ?)');
            $stmt->execute([$name, $description, $price]);
            header('Location: manage_products.php');
            exit;
        }
    }
} elseif ($action === 'edit') {
    $id = intval($_GET['id'] ?? 0);
    // Fetch product data
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo 'Product not found.';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);

        if ($name === '' || $price <= 0) {
            $error = 'Please enter a valid name and price.';
        } else {
            $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?');
            $stmt->execute([$name, $description, $price, $id]);
            header('Location: manage_products.php');
            exit;
        }
    }
} elseif ($action === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: manage_products.php');
    exit;
}

// Fetch all products for listing
$stmt = $pdo->query('SELECT id, name, description, price FROM products');
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
</head>
<body>
  <h2>Products</h2>
  <a href="manage_products.php?action=create">Add New Product</a>
  <?php if ($action === 'create'): ?>
    <h3>Add Product</h3>
    <?php if ($error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="">
      <label>Name:
        <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>">
      </label><br>
      <label>Description:
        <textarea name="description"><?= htmlspecialchars($description ?? '') ?></textarea>
      </label><br>
      <label>Price:
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($price ?? '') ?>">
      </label><br>
      <button type="submit">Save</button>
    </form>
    <p><a href="manage_products.php">Back to Product List</a></p>

  <?php elseif ($action === 'edit'): ?>
    <h3>Edit Product #<?= $product['id'] ?></h3>
    <?php if ($error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="">
      <label>Name:
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>">
      </label><br>
      <label>Description:
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>
      </label><br>
      <label>Price:
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>">
      </label><br>
      <button type="submit">Update</button>
    </form>
    <p><a href="manage_products.php">Back to Product List</a></p>
  <?php else: ?>
    <table cellpadding="5" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $prod): ?>
          <tr>
            <td><?= $prod['id'] ?></td>
            <td><?= htmlspecialchars($prod['name']) ?></td>
            <td><?= htmlspecialchars($prod['description']) ?></td>
            <td><?= $prod['price'] ?></td>
            <td>
              <a href="manage_products.php?action=edit&id=<?= $prod['id'] ?>">Edit</a> |
              <a href="manage_products.php?action=delete&id=<?= $prod['id'] ?>"
                 onclick="return confirm('Are you sure you want to delete this product?');">
                Delete
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
  <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>

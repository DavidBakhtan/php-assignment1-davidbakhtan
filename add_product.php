<?php
// File: add_product.php
include 'database.php';

// Fetch categories for dropdown
$cats = $pdo->query('SELECT categoryID, name FROM categories')->fetchAll();

$errors = [];
$name = '';
$price = '';
$categoryID = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name'] ?? '');
    $price      = trim($_POST['price'] ?? '');
    $categoryID = $_POST['categoryID'] ?? '';

    // Validation
    if ($name === '') {
        $errors[] = 'Please enter a product name.';
    }
    if ($price === '' || !is_numeric($price) || $price <= 0) {
        $errors[] = 'Please enter a valid price (greater than 0).';
    }
    if ($categoryID === '' || !filter_var($categoryID, FILTER_VALIDATE_INT)) {
        $errors[] = 'Please select a category.';
    }

    // Insert if no errors
    if (empty($errors)) {
        $stmt = $pdo->prepare('
            INSERT INTO products (name, price, categoryID)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([$name, $price, $categoryID]);
        header('Location: product_list.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Add Product</title>
  <style>
    body { font-family: Arial, sans-serif; background: #fafbfc; margin: 0; padding: 0; }
    .container { width: 90%; max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
    header, footer { text-align: center; background: #6c757d; color: #fff; padding: 10px 0; }
    form label { display: block; margin-bottom: 10px; }
    form input, form select { width: 100%; padding: 8px; margin-top: 4px; }
    button { background: #28a745; color: #fff; border: none; padding: 10px 20px; cursor: pointer; }
    .back { background: #6c757d; }
    .errors { color: #dc3545; margin-bottom: 20px; }
    .errors ul { list-style: inside disc; }
  </style>
</head>
<body>
  <div class="container">
    <header><h1>Add New Product</h1></header>

    <?php if (!empty($errors)): ?>
      <div class="errors">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post">
      <label>
        Name:
        <input type="text" name="name" required value="<?= htmlspecialchars($name) ?>">
      </label>

      <label>
        Price (CAD):
        <input type="number" name="price" step="0.01" min="0.01" required value="<?= htmlspecialchars($price) ?>">
      </label>

      <label>
        Category:
        <select name="categoryID" required>
          <option value="">-- Select Category --</option>
          <?php foreach ($cats as $c): ?>
            <option value="<?= $c['categoryID'] ?>"
              <?= $c['categoryID'] == $categoryID ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <button type="submit">Add Product</button>
      <a href="product_list.php" class="back"><button type="button" class="back">Back to List</button></a>
      <a href="index.php" class="back"><button type="button" class="back">Back to Menu</button></a>
    </form>

    <footer>&copy; 2025 SportsPro Inc.</footer>
  </div>
</body>
</html>

<?php
include 'database.php';

// ---- Optional: handle actual delete action ----
// Uncomment this block if you want clicking Delete to remove the row

if (isset($_GET['delete'])) {
    $delId = (int) $_GET['delete'];
    if ($delId > 0) {
        $pdo->prepare('DELETE FROM products WHERE productID = ?')
            ->execute([$delId]);
        header('Location: product_list.php');
        exit;
    }
}


$stmt = $pdo->query(
    'SELECT p.productID, p.name, p.price, c.name AS categoryName
     FROM products p
     JOIN categories c ON p.categoryID = c.categoryID'
);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef1f5; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 800px; margin: 40px auto; background: #fff; padding: 20px; box-shadow: 0 0 12px rgba(0,0,0,0.1); }
        header, footer { text-align: center; background: #343a40; color: #fff; padding: 15px 0; }
        .buttons { margin: 20px 0; text-align: center; }
        .buttons a { display: inline-block; margin: 0 10px; padding: 8px 16px; background: #28a745; color: #fff; text-decoration: none; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #495057; color: #fff; }
        a.edit { background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; text-decoration: none; }
        a.delete { background: #dc3545; color: #fff; padding: 4px 8px; border-radius: 4px; text-decoration: none; margin-left: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <header><h1>Product List</h1></header>
        <div class="buttons">
            <a href="index.php">Back to Menu</a>
            <a href="add_product.php">Add Product</a>
        </div>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price (CAD)</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['productID'] ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= number_format($p['price'],2) ?></td>
                        <td><?= htmlspecialchars($p['categoryName']) ?></td>
                        <td>
                            <a class="edit"   href="edit_product.php?id=<?= $p['productID'] ?>">Edit</a>
                            <a class="delete" href="product_list.php?delete=<?= $p['productID'] ?>"
                                onclick="return confirm('Are you sure you want to delete this product?');">
                              Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
        <footer>&copy; 2025 SportsPro Inc.</footer>
    </div>
</body>
</html>

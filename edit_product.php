<?php
include 'database.php';
$id = $_GET['id'] ?? null;
if (!$id) exit('No product specified.');
$cats = $pdo->query('SELECT categoryID, name FROM categories')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $categoryID = $_POST['categoryID'];
    $pdo->prepare('UPDATE products SET name=?, price=?, categoryID=? WHERE productID=?')
        ->execute([$name, $price, $categoryID, $id]);
    header('Location: product_list.php'); exit;
}
$stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) exit('Product not found.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product #<?=$id?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #fafbfc; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
        header, footer { text-align: center; background: #6c757d; color: #fff; padding: 10px 0; }
        form label { display: block; margin-bottom: 10px; }
        form input, form select { width: 100%; padding: 8px; margin-top: 4px; }
        button { background: #28a745; color: #fff; border: none; padding: 10px 20px; cursor: pointer; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <header><h1>Edit Product #<?=$id?></h1></header>
        <main>
            <form method="post">
                <label>Name:
                    <input type="text" name="name" required value="<?=htmlspecialchars($product['name'])?>">
                </label>
                <label>Price (CAD):
                    <input type="number" name="price" step="0.01" min="0.01" required value="<?=number_format($product['price'],2)?>">
                </label>
                <label>Category:
                    <select name="categoryID">
                        <?php foreach ($cats as $c): ?>
                            <option value="<?=$c['categoryID']?>" <?= $c['categoryID']==$product['categoryID'] ? 'selected' : '' ?>>
                                <?=htmlspecialchars($c['name'])?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button type="submit">Update Product</button>
            </form>
        </main>
        <footer>&copy; 2025 SportsPro Inc.</footer>
    </div>
</body>
</html>

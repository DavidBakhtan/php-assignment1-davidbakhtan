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
<head><meta charset="UTF-8"><title>Edit Product</title></head>
<body>
<h1>Edit Product #<?=$id?></h1>
<form method="post">
    <label>Name:<input type="text" name="name" required value="<?=htmlspecialchars($product['name'])?>"></label><br>
    <label>Price:<input type="number" name="price" step="0.01" min="0.01" required value="<?=number_format($product['price'],2)?>"></label><br>
    <label>Category:
        <select name="categoryID">
            <?php foreach ($cats as $c): ?>
                <option value="<?=$c['categoryID']?>" <?= $c['categoryID']==$product['categoryID'] ? 'selected' : '' ?>><?=htmlspecialchars($c['name'])?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <button type="submit">Update Product</button>
</form>
</body>
</html>

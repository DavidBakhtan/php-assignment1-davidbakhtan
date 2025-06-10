<?php
include 'database.php';
$stmt = $pdo->query('SELECT p.productID, p.name, p.price, p.categoryID, c.name AS categoryName FROM products p JOIN categories c ON p.categoryID = c.categoryID');
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Products</title></head>
<body>
<h1>Product List</h1>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Edit</th></tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?=$p['productID']?></td>
        <td><?=htmlspecialchars($p['name'])?></td>
        <td><?=number_format($p['price'],2)?></td>
        <td><?=htmlspecialchars($p['categoryID'])?></td>
        <td><a href="edit_product.php?id=<?=$p['productID']?>">Edit</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
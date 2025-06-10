<?php
include 'database.php';
$stmt = $pdo->query('SELECT p.productID, p.name, p.price, p.categoryID, c.name AS categoryName FROM products p JOIN categories c ON p.categoryID = c.categoryID');
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
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #495057; color: #fff; }
        a.button { display: inline-block; padding: 6px 12px; background: #ffc107; color: #000; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <header><h1>Product List</h1></header>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price (CAD)</th>
                        <th>Category</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?=$p['productID']?></td>
                        <td><?=htmlspecialchars($p['name'])?></td>
                        <td><?=number_format($p['price'],2)?></td>
                        <td><?=htmlspecialchars($p['categoryName'])?></td>
                        <td><a class="button" href="edit_product.php?id=<?=$p['productID']?>">Edit</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
        <footer>&copy; 2025 SportsPro Inc.</footer>
    </div>
</body>
</html>

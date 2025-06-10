<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise 2-1</title>
    <style>.errors { color: red; }</style>
</head>
<body>
<?php
$errors = [];
$price    = '';
$discount = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price    = trim($_POST['price'] ?? '');
    $discount = trim($_POST['discount'] ?? '');

    // Validation
    if ($price === '') {
        $errors[] = 'Please enter a price.';
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors[] = 'Price must be a positive number.';
    }
    if ($discount === '') {
        $errors[] = 'Please enter a discount percentage.';
    } elseif (!is_numeric($discount) || $discount < 0 || $discount > 100) {
        $errors[] = 'Discount must be between 0 and 100.';
    }

    // Calculate if valid
    if (empty($errors)) {
        $discounted = $price * (1 - $discount / 100);
        $taxRate    = 0.08;
        $taxAmount  = $discounted * $taxRate;
        $total      = $discounted + $taxAmount;
    }
}
?>
<h1>Exercise 2-1</h1>
<form method="post">
    <label>Price: <input type="number" name="price" step="0.01" min="0.01" required value="<?=htmlspecialchars($price)?>"></label><br>
    <label>Discount (%): <input type="number" name="discount" step="0.01" min="0" max="100" required value="<?=htmlspecialchars($discount)?>"></label><br>
    <button type="submit">Calculate</button>
</form>
<?php if (!empty($errors)): ?>
    <ul class="errors">
        <?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?>
    </ul>
<?php elseif (isset($total)): ?>
    <h2>Results</h2>
    <p>Original Price: <?=number_format($price,2)?></p>
    <p>Discounted Price: <?=number_format($discounted,2)?></p>
    <p>Sales Tax Rate: <?=($taxRate * 100)?>%</p>
    <p>Sales Tax Amount: <?=number_format($taxAmount,2)?></p>
    <p><strong>Total After Tax: <?=number_format($total,2)?></strong></p>
<?php endif; ?>
</body>
</html>

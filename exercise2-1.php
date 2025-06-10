<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 2-1</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        header, footer { text-align: center; padding: 10px 0; background: #007BFF; color: #fff; }
        form input { width: calc(100% - 12px); padding: 5px; margin-bottom: 10px; }
        button { background: #28a745; color: #fff; border: none; padding: 10px 20px; cursor: pointer; }
        .errors { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <header><h1>Exercise 2-1</h1></header>
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

            if (empty($errors)) {
                $discounted = $price * (1 - $discount / 100);
                $taxRate    = 0.08;
                $taxAmount  = $discounted * $taxRate;
                $total      = $discounted + $taxAmount;
            }
        }
        ?>
        <main>
            <form method="post">
                <label for="price">Price (CAD):</label>
                <input type="number" id="price" name="price" step="0.01" min="0.01" required value="<?=htmlspecialchars($price)?>">

                <label for="discount">Discount (%):</label>
                <input type="number" id="discount" name="discount" step="0.01" min="0" max="100" required value="<?=htmlspecialchars($discount)?>">

                <button type="submit">Calculate</button>
                <a href="index.php" class="back"><button type="button" class="back">Back to Menu</button></a>
            </form>

            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <ul>
                        <?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif (isset($total)): ?>
                <section>
                    <h2>Results</h2>
                    <p>Original Price: <?=number_format($price,2)?> CAD</p>
                    <p>Discounted Price: <?=number_format($discounted,2)?> CAD</p>
                    <p>Sales Tax Rate: <?=($taxRate * 100)?>%</p>
                    <p>Sales Tax Amount: <?=number_format($taxAmount,2)?> CAD</p>
                    <p><strong>Total After Tax: <?=number_format($total,2)?> CAD</strong></p>
                </section>
            <?php endif; ?>
        </main>
        <footer>&copy; 2025 SportsPro Inc.</footer>
    </div>
</body>
</html>
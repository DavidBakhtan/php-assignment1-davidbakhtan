<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 2-2</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 20px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
        header, footer { text-align: center; padding: 10px; background: #17a2b8; color: #fff; }
        input, select { width: 100%; padding: 8px; margin: 8px 0; }
        button { background: #007bff; color: #fff; border: none; padding: 8px 16px; cursor: pointer; }
        .result { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <header><h1>Exercise 2-2</h1></header>
        <?php
        $result = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $num1 = $_POST['num1'] ?? '';
            $num2 = $_POST['num2'] ?? '';
            $op   = $_POST['operation'] ?? '';
            if (is_numeric($num1) && is_numeric($num2)) {
                switch ($op) {
                    case 'add': $result = $num1 + $num2; break;
                    case 'sub': $result = $num1 - $num2; break;
                    case 'mul': $result = $num1 * $num2; break;
                    case 'div':
                        $result = ($num2 != 0) ? $num1 / $num2 : 'Cannot divide by zero.';
                        break;
                    default: $result = 'Select an operation.';
                }
            } else {
                $result = 'Both inputs must be numeric.';
            }
            // clear
            $num1 = $num2 = '';
        }
        ?>
        <main>
            <form method="post">
                <label for="num1">Number 1:</label>
                <input type="text" id="num1" name="num1" value="">

                <label for="num2">Number 2:</label>
                <input type="text" id="num2" name="num2" value="">

                <label for="operation">Operation:</label>
                <select id="operation" name="operation">
                    <option value="">-- Choose --</option>
                    <option value="add">Add</option>
                    <option value="sub">Subtract</option>
                    <option value="mul">Multiply</option>
                    <option value="div">Divide</option>
                </select>

                <button type="submit">Compute</button>
            </form>

            <?php if ($result !== ''): ?>
                <div class="result">Result: <?=htmlspecialchars($result)?></div>
            <?php endif; ?>
        </main>
        <footer>&copy; 2025 SportsPro Inc.</footer>
    </div>
</body>
</html>

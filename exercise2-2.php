<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Exercise 2-2</title></head>
<body>
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
                if ($num2 != 0) $result = $num1 / $num2;
                else $result = 'Cannot divide by zero.';
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
<h1>Exercise 2-2</h1>
<form method="post">
    <input type="text" name="num1" value=""><br>
    <input type="text" name="num2" value=""><br>
    <select name="operation">
        <option value="">--Choose--</option>
        <option value="add">Add</option>
        <option value="sub">Subtract</option>
        <option value="mul">Multiply</option>
        <option value="div">Divide</option>
    </select><br>
    <button type="submit">Compute</button>
</form>
<?php if ($result !== ''): ?><h2>Result: <?=htmlspecialchars($result)?></h2><?php endif; ?>
</body>
</html>

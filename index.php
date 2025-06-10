<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Assignment 1 Dashboard</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&display=swap');
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    .hero {
      max-width: 800px;
      width: 90%;
    }
    .hero h1 {
      font-size: 4rem;
      margin-bottom: 0.5rem;
      animation: fadeInDown 1s ease-out;
    }
    .hero p {
      font-size: 1.25rem;
      margin-bottom: 2rem;
      opacity: 0.8;
      animation: fadeInUp 1s ease-out;
    }
    /* Updated buttons layout to flex for inline placement */
    .buttons {
      display: flex;
      justify-content: center;
      gap: 1rem;
    }
    .buttons a {
      display: block;
      padding: 1rem 1.5rem;
      background: rgba(255,255,255,0.2);
      border-radius: 8px;
      text-decoration: none;
      color: #fff;
      font-weight: 600;
      transition: background 0.3s, transform 0.3s;
    }
    .buttons a:hover {
      background: rgba(255,255,255,0.35);
      transform: translateY(-5px);
    }
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    footer {
      position: absolute;
      bottom: 20px;
      width: 100%;
      text-align: center;
      font-size: 0.875rem;
      opacity: 0.6;
    }
  </style>
</head>
<body>
  <div class="hero">
    <h1>Assignment 1 Dashboard</h1>
    <p>Choose an exercise to launch</p>
    <div class="buttons">
      <a href="exercise2-1.php">Exercise 2‑1</a>
      <a href="exercise2-2.php">Exercise 2‑2</a>
      <a href="product_list.php">Product List</a>
      <a href="add_product.php">Add New Product</a>
    </div>
  </div>
  <footer>&copy; 2025 SportsPro Inc.</footer>
</body>
</html>

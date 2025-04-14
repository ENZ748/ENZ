<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    .email-container {
      background-color: #ffffff;
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }
    .logo {
      text-align: center;
      margin-bottom: 30px;
    }
    .logo img {
      max-width: 150px;
      height: auto;
    }
    .header {
      text-align: center;
      font-size: 22px;
      font-weight: bold;
      color: #00539C;
      margin-bottom: 20px;
    }
    .message {
      font-size: 16px;
      line-height: 1.6;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="logo">
    <img src="{{ asset('EnzLogo.png') }}" alt="Enz Logo" class="logo">
    </div>
    <div class="header">Welcome to EN Inventory Supplies</div>
    <div class="message">
      Your account has been successfully registered with <strong>EN Inventory Supplies</strong>. We’re excited to have you on board!
    </div>
  </div>
</body>
</html>

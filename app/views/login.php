<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styleReLo.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<section id="login">
  <h2>Login</h2>
  <form action="index.php?page=login" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username">
      <span class="error"><?php echo $data['usernameErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
      <span class="error"><?php echo $data['passwordErr']; ?></span>
    </div>

    <input type="submit" value="Login">
  </form>
</section>
</body>
</html>

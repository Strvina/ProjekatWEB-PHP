<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styleReLo.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<section id="register">
  <h2>Register</h2>
  <form action="index.php?page=register" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php echo $data['username']; ?>">
      <span class="error"><?php echo $data['usernameErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>">
      <span class="error"><?php echo $data['nameErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="surname">Surname:</label>
      <input type="text" id="surname" name="surname" value="<?php echo $data['surname']; ?>">
      <span class="error"><?php echo $data['surnameErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>">
      <span class="error"><?php echo $data['emailErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
      <span class="error"><?php echo $data['passwordErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="retypePassword">Retype password:</label>
      <input type="password" id="retypePassword" name="retypePassword">
      <span class="error"><?php echo $data['retypePasswordErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" value="<?php echo $data['dob']; ?>">
      <span class="error"><?php echo $data['dobErr']; ?></span>
    </div>

    <div class="form-group">
      <label for="gender">Gender:</label>
      <div class="radio-group">
        <label>
          <input type="radio" name="gender" value="male" <?php echo ($data['gender'] === 'male') ? 'checked' : ''; ?>> Male
        </label>
        <label>
          <input type="radio" name="gender" value="female" <?php echo ($data['gender'] === 'female') ? 'checked' : ''; ?>> Female
        </label>
        <label>
          <input type="radio" name="gender" value="other" <?php echo ($data['gender'] === 'other') ? 'checked' : ''; ?>> Other
        </label>
      </div>
    </div>

    <input type="submit" value="Register">
  </form>
</section>
</body>
</html>
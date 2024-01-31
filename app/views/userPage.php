<!DOCTYPE html>
<html>
<head>
  <title>Language Solution</title>
  <link rel="stylesheet" href="css/style.css?v=1">
  <link rel="stylesheet" href="css/tables.css?v=1">
  <script src="script.js"></script>
  
</head>
<body>

<header>
  <div class="header-left">
    <h1>Language solution</h1>
  </div>
  <div class="header-center">
        <a href="#" class="button">Home</a>
        <a href="#aboutus" class="button">About us</a>
        <a href="#languages" class="button">Languages</a>
        <a href="#study-formats" class="button">Study Formats</a> 
  </div>
  <div class="header-right">
  <a href="index.php?page=logout" class="button">Log out</a>
  </div>
</header>

  <section id="home">
   <?php
if (isset($_SESSION['username'])) {
  $loggedInUsername = $_SESSION['username'];
  echo "Welcome, $loggedInUsername!";
} else {
  echo "Welcome, Guest";
}
   ?>
    <p>Choose a language and study format to start your language learning journey.</p>
  </section>

  <section id="languages">
    <h2>Languages </h2>
    <ul>
    <?php
    require_once "connection.php";
    global $conn;
    $query = "SELECT language_name FROM language";
    $result = mysqli_query($conn, $query);
    
    while ($row = mysqli_fetch_assoc($result)) { ?>
    <li><a href="#"><?php echo $row['language_name']; ?></a></li>
    <?php } ?>
    </ul>
  </section>

  <section id="study-formats">
  <h2>Study Format</h2>
  <ul>
    <?php
    $query = "SELECT format_name FROM studyformat";
    $result = mysqli_query($conn, $query);
    
    while ($row = mysqli_fetch_assoc($result)) { ?>
      <li><a href="#"><?php echo $row['format_name']; ?></a></li>
    <?php } ?>
  </ul>
</section>
  
  <section id="language-selection">
  <h2>I want to study</h2>
  <form action="index.php?page=userPage" method="post" class="format-form">
  <input type="hidden" name="form-type" value="user-choice-form">
   <div class="form-group">
    <label for="language">Language:</label>
    <select id="language" name="language" required>
      <option value="">Choose a language</option>
      <?php
      $query = "SELECT language_name FROM language";
      $result = mysqli_query($conn, $query);
      
        while ($row = mysqli_fetch_assoc($result)) { ?>
        <option value="<?php echo $row['language_name']; ?>"><?php echo $row['language_name']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
  <label for="format">Format of Learning:</label>
  <select id="format" name="format" required>
    <option value="">Choose a format</option>
    <?php
    $query = "SELECT format_name, price FROM studyformat";
    $result = mysqli_query($conn, $query);
     while ($row = mysqli_fetch_assoc($result)) { ?>
      <option value="<?php echo $row['format_name']; ?>"><?php echo $row['format_name'] . ' (€' . $row['price'] . ')'; ?></option>
    <?php } ?>
  </select>
</div>

    <div class="form-group">
      <input type="submit" value="Submit" class="submit-button">
    </div>
  </form>

  <section id="suggest">
  <h2>Suggest a Language</h2>
  <p>If you would like to suggest a language or a new study format that is not listed, please fill out the form below:</p>

  <form action="index.php?page=userPage" method="post">
  <input type="hidden" name="form-type" value="user-suggestion-form">
    <div class="form-group">
      <label for="suggestion">Write the suggestion: </label>
      <textarea id="suggestion" name="suggestion" rows="4" cols="50"></textarea>
    </div>
    
    <div class="form-group">
      <input type="submit" value="Submit Suggestion" class="submit-button">
    </div>
  </form>
</section>


  <div id="registered-users">
    <h2>Available groups </h2>
    <?php
     $queryLanguages = "SELECT language_name, language_id FROM language";
     $resultLanguages = mysqli_query($conn, $queryLanguages);
   
     while ($rowLanguage = mysqli_fetch_assoc($resultLanguages)) {
       $languageId = $rowLanguage['language_id'];
       $language = $rowLanguage['language_name'];
   
       $query = "
         SELECT u.name, u.surname, u.gender
         FROM UserChoice uc
         JOIN Users u ON uc.users_id = u.users_id
         JOIN Language l ON uc.language_id = l.language_id
         WHERE uc.format_id = 5 AND l.language_id = $languageId;
       ";
   
       $result = mysqli_query($conn, $query);
   
       $numUsers = mysqli_num_rows($result);
   
       if ($numUsers > 0) {
         echo '<div class="language-group">';
         echo "<h2>{$language} Language Group</h2>";
   
         echo "<table>";
         echo "<tr><th>Name</th><th>Surname</th><th>Gender</th></tr>";
         while ($row = mysqli_fetch_assoc($result)) {
           echo "<tr>";
           echo "<td class='center-align'>{$row['name']}</td>";
           echo "<td class='center-align'>{$row['surname']}</td>";
           echo "<td class='center-align'>{$row['gender']}</td>";
           echo "</tr>";
         }
         echo "</table>";
   
         if ($numUsers < 6) {
          echo '<form action="index.php?page=userPage" method="post">';
          echo '<input type="hidden" name="form-type" value="user-table-form">';
                echo '<input type="hidden" name="language" value="' . $language . '">';
                echo '<input type="hidden" name="format" value="Group Coaching">';
                echo '<button type="submit" class="add-button" data-remaining-spaces="' . (6 - $numUsers) . '">I want to join this group <span class="space-placeholder"></span></button>';
                echo '</form>';
         } else {
           echo '<p class="full-message">Group is full</p>';
         }
   
         echo '</div>';
       }
     }
     ?>
  </div>
     
</section>

  
</section>
  <footer>
    <p>&copy; 2023 Language Solution. All rights reserved.</p>
  </footer>
  <script>
    window.addEventListener('load', handleScroll);
  </script>
</body>
</html>

  



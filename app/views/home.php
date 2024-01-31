<!DOCTYPE html>
<html>
<head>
  <title>Language Solution</title>
  <script src="https://kit.fontawesome.com/39ef460d90.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css?v=1">
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
    <a href="index.php?page=register" class="button">Register</a>
    <a href="index.php?page=login" class="button">Login</a>
  </div>
</header>

  <section id="aboutus">
    <h2>Empowering Your Journey to Multilingual Mastery</h2>
    <p>At LanguageSolution, we are committed to providing comprehensive language learning solutions tailored to your needs. <br> Our proven methodology combines cutting-edge technology with expert instruction to ensure an immersive and effective learning experience.</p>
  </section>

  <section id="languages">
    <h2><i class="fa-solid fa-chevron-down"></i> Languages we have to offer <i class="fa-solid fa-chevron-down"></i></h2>
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
  <h2>Study Formats</h2>
  <ul>
    <?php
    $query = "SELECT format_name FROM studyformat";
    $result = mysqli_query($conn, $query);
    
    while ($row = mysqli_fetch_assoc($result)) { ?>
      <li><a href="#"><?php echo $row['format_name']; ?></a></li>
    <?php } ?>
  </ul>
</section>
<section id="testimonials">
  <h2>What Our Users Say</h2>
  <div class="testimonial">
    <p>"LanguageSolution helped me achieve fluency in Spanish within months. I highly recommend it!"</p>
    <p>- Maria S., Language Enthusiast</p>
  </div>
  <div class="testimonial">
    <p>"I joined a language group here and made great friends while learning. Such a fantastic experience!"</p>
    <p>- John D., Language Learner</p>
  </div>
</section>

<section id="blog">
  <h2>Language Learning Tips</h2>
  <div class="blog-post">
    <h3>Mastering Pronunciation: Tips for Language Learners</h3>
    <p>Learn how to perfect your pronunciation with these expert tips.</p>
    <a href="#" class="contact-link">Read More</a>
  </div>
  <div class="blog-post">
    <h3>Exploring Cultural Nuances in Language Learning</h3>
    <p>Discover the importance of understanding culture while learning a new language.</p>
    <a href="#" class="contact-link">Read More</a>
  </div>
</section>

<section id="contact">
  <h2>Contact Us</h2>
  <p>If you have any questions or feedback, feel free to get in touch with us.</p>
  <a class="contact-link" href="https://www.facebook.com">Facebook</a>
  <a class="contact-link" href="https://www.twitter.com">Twitter</a>
  <a class="contact-link" href="https://www.instagram.com">Instagram</a>
</section>


</section>
<footer>
    <p>&copy; 2023 Language Solution. All rights reserved. <a href="index.php?page=register" class="register-link">Register and Start Learning</a></p>
</footer>

  <script>
    window.addEventListener('load', handleScroll);
  </script>
</body>
</html>




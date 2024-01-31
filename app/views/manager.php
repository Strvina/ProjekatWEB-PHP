<?php
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo '<p>' . htmlspecialchars($message) . '</p>';
}
?>
<a href="index.php?page=logout" class="button">Log out</a>
<h1>Manager Page</h1>

<h1>Dodaj nove jezike i formate ucenja</h1>
<form method="POST" action="index.php?page=add_language">
                  <input type="text" name="language_name" placeholder="Language Name" required>
                  <button type="submit" name="add_language">Add Language</button>
            </form>
      
            <form method="POST" action="index.php?page=add_study_format">
                  <input type="text" name="format_name" placeholder="Format Name" required>
                  <input type="number" name="price" placeholder="Price" required>
                  <button type="submit" name="add_study_format">Add Study Format</button>
            </form>

          <h2>Suggestions</h2>
          <table>
              <thead>
                  <tr>
                      <th>UserName</th>
                      <th>Suggestion Text</th>
                      <th>Submission Date</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($suggestions as $suggestion): ?>
                      <tr>
                          <td><?php echo $suggestion->getUserName(); ?></td>
                          <td><?php echo $suggestion->getSuggestionText(); ?></td>
                          <td><?php echo $suggestion->getSubmissionDate(); ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
            
<h2>User Choices</h2>
<table style="border-collapse: collapse; width: 100%; text-align:center;">
  <thead>
    <tr>
      <th>User ID</th>
      <th>User Name</th>
      <th>User Level</th>
      <th>Promote/Demote</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
    <tr>
      <td><?php echo $user['users_id']; ?></td>
      <td><?php echo $user['username']; ?></td>
      <td><?php echo $user['role']; ?></td>
      <td>
        <form action="index.php?page=promote_user" method="post">
          <input type="hidden" name="users_id" value="<?php echo $user['users_id']; ?>">
          <select name="promotion">
            <option value="user">Promote to User</option>
            <option value="manager">Promote to Manager</option>
          </select>
          <button type="submit" name="promote_user">Promote/Demote</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


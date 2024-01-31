
<a href="index.php?page=logout" class="button">Log out</a>
<h1>Admin Page</h1>
<h1>Add new languages and study formats</h1>
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
            
<h2>Users</h2>
<table style="border-collapse: collapse; width: 100%; text-align:center;">
  <thead>
    <tr>
      <th>User ID</th>
      <th>User Name</th>
      <th>Name</th>
      <th>Surname</th>
      <th>User Level</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
    <tr>
      <td><?php echo $user['users_id']; ?></td>
      <td><?php echo $user['username']; ?></td>
      <td><?php echo $user['name']; ?></td>
      <td><?php echo $user['surname']; ?></td>
      <td><?php echo $user['role']; ?></td>
      <td>
            <form method="POST" action="index.php?page=edit_user">
                  <input type="hidden" name="users_id" value="<?php echo $user['users_id']; ?>">
                  <input type="hidden" name="users_id" value="<?php echo $user['users_id']; ?>">
                  <label for="username">Username:</label>
                  <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
                  <label for="name">Name:</label>
                  <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
                  <label for="surname">Surname:</label>
                  <input type="text" name="surname" value="<?php echo $user['surname']; ?>" required><br>
                  <label for="role">Role:</label>
                  <input type="text" name="role" value="<?php echo $user['role']; ?>" required><br>
                  <button type="submit" name="edit_user">Update User</button>
            </form>
      </td> 
      <td>
            <form method="POST" action="index.php?page=delete_user">
                  <input type="hidden" name="users_id" value="<?php echo $user['users_id']; ?>">
                  <button type="submit" name="delete_user">Delete</button>
            </form>
      </td>
      <td>
          
      </td>
    </tr>
    <?php endforeach; ?>
    
<table style="border-collapse: collapse; width: 100%; text-align:center;">
<h2>User Choices</h2>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Language</th>
            <th>Study Format</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userChoices as $choice): ?>
        <tr>
            <td><?php echo $choice['users_id']; ?></td>
            <td><?php echo $choice['username']; ?></td>
            <td><?php echo $choice['language_name']; ?></td>
            <td><?php echo $choice['format_name']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

  </tbody>
</table>

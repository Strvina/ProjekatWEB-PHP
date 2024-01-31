<form action="admin.php" method="post">
    <input type="hidden" name="action" value="promote_user">
    <input type="hidden" name="users_id" value="<?php echo $_GET['users_id']; ?>">
    <label for="new_role">Select new role:</label>
    <select name="new_role" id="new_role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
        <option value="manager">Manager</option>
    </select>
    <input type="submit" name="promote_user" value="Promote">
</form>

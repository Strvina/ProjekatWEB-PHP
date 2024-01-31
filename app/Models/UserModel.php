<?php

namespace App\Models;



class UserModel
{
    private $username;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $dob;
    private $gender;
    private $role;

    public function __construct($username, $name, $surname, $email, $password, $dob, $gender, $role)
    {
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->role = $role;
    }

    public static function getAllUsers($conn) {
        $query = "SELECT * FROM users";
        $result = $conn->query($query);
    
        $users = [];
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new UserModel($row['users_id'], $row['username'], $row['name'], $row['surname'], $row['email'], $row['password'], $row['dob'], $row['gender']);
                $users[] = $user;
            }
        }
    
        return $users;
    }

   

    public static function findByUsername($conn, $username)
{
    $escapedUsername = $conn->real_escape_string($username);

    $query = "
    SELECT users_id, username, name,  surname, password, email, gender, dob, role
        FROM users 
        WHERE username = '$escapedUsername'
        LIMIT 1;
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = new UserModel(
            $row['users_id'],
            $row['username'],
            $row['name'],
            $row['surname'],
            $row['email'],
            $row['password'],
            $row['dob'],
            $row['gender'],
            $row['role']
        );
        return $user;
    } else {
        return null;
    }
}

public static function findByUserId($userId, $conn)
{
    $userId = (int)$userId;

    $query = "
        SELECT username, name, surname, email, password, dob, gender, role
        FROM users 
        WHERE users_id = $userId
        LIMIT 1;
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = new UserModel(
            $row['username'],
            $row['name'],
            $row['surname'],
            $row['email'],
            $row['password'],   
            $row['dob'],
            $row['gender'],
            $row['role']
        );
        return $user;
    } else {
        return null;
    }
}

public static function insertUserChoice($conn, $userId, $format, $language) {
    $insertQuery = "INSERT INTO UserChoice (users_id, format_id, language_id, submission_date)
                    VALUES ($userId, '$format', '$language', NOW())";

    if (mysqli_query($conn, $insertQuery)) {
        return true;
    } else {
        return false;
    }
}

public static function insertUserSuggestion($conn, $userId, $language) {
    $insertQuery = "INSERT INTO usersuggestions (users_id, suggestion_text, submission_date)
                    VALUES ($userId, '$language', NOW())";

    if (mysqli_query($conn, $insertQuery)) {
        return true;
    } else {
        return false;
    }
}


public function delete($userId, $conn)
{
    
    $query = "DELETE FROM users WHERE users_id = $userId";

    if ($conn->query($query)) {
        return true;
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

public function editUserInfo($newUsername, $newName, $newSurname, $newRole, $userId, $conn)
{
    $newUsername = $conn->real_escape_string($newUsername);
    $newName = $conn->real_escape_string($newName);
    $newSurname = $conn->real_escape_string($newSurname);
    $newRole = $conn->real_escape_string($newRole);
    
    $query = "UPDATE users 
              SET username='$newUsername', name='$newName', surname='$newSurname', role='$newRole' 
              WHERE users_id = $userId";

    if ($conn->query($query)) {
        $this->username = $newUsername;
        $this->name = $newName;
        $this->surname = $newSurname;
        $this->role = $newRole;
        return true;
    } else {
        return false;
    }
}

public function updateRole($newRole,$userId, $conn)
{
    $newRole = $conn->real_escape_string($newRole);

    if ($this->role === 'admin') {
        return false;
    }

    $query = "UPDATE users SET role = '$newRole' WHERE users_id = $userId";

    if ($conn->query($query)) {
        $this->role = $newRole;
        return true;
    } else {
        return false;
    }
}


}

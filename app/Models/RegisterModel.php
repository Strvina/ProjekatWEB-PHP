<?php

class RegisterModel
{
    private $conn;
    private $username;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $dob;
    private $gender;
    private $role;

    public function __construct($conn, $username, $name, $surname, $email, $password, $dob, $gender, $role) {
        $this->conn=$conn;
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->role = $role;
    }
    
    

    public function registerUser($username, $name, $surname, $email, $password, $dob, $gender)
    {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, name, surname, email, password, dob, gender) 
                  VALUES ('$username', '$name', '$surname', '$email', '$hashedPassword', '$dob', '$gender')";

        if ($this->conn->query($query)) {
            return "User registered successfully!";
        } else {
            return "Error during registration. Please try again.";
        }
    }

    public function isUsernameRegistered($username)
    {
        $query = "SELECT COUNT(*) FROM users WHERE username = '$this->username'";
        $result = $this->conn->query($query);
        
        $count = $result->fetch_row()[0];
        
        return $count > 0;
    }
    public function isEmailRegistered($email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = '$this->email'";
        $result = $this->conn->query($query);
        
        $count = $result->fetch_row()[0];
        
        return $count > 0;
    }
}
?>


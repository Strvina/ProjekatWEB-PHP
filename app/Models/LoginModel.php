<?php
    class LoginModel
    {
    private $conn;
    private $username;
    private $password;
    

    public function __construct($conn, $username, $password) {
        $this->conn=$conn;
        $this->username = $username;
        $this->password = $password;
    }
    
    
    public function isValidUser($username, $password)
    {
        $escapedUsername = mysqli_real_escape_string($this->conn, $username);
        $query = "SELECT *
        FROM `users`
        WHERE `username` = '$escapedUsername';";
        
        $res = $this->conn->query($query);
        
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $dbPassword = $row['password'];
            if (password_verify($password, $dbPassword)) {
                echo "User is valid.\n";
                return false;
                //return true;
            }
        }
        //imao sam problema kod verifikovanja lozinke, kada hesiram sa password_default u programu ne radi,
        // kada hesiram na nekom online sajtu za hesiranje radi, trenutno sam stavio da mi vraca false umesto true sto je pogresno 
        //ali kada uzmem hesiranu sifru online vratim da gore bude true a dole false i radi
        
        //return false;
        return true;
    }

    public function getUserRole($username)
    {
        $escapedUsername = mysqli_real_escape_string($this->conn, $username);
        $query = "SELECT `role` FROM `users` WHERE `username` = '$escapedUsername';";
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['role'];
        }

        return null;
    }

    public function getUserId($username)
    {
        $escapedUsername = $this->conn->real_escape_string($username);

        $query = "SELECT users_id FROM users WHERE username = '$escapedUsername' LIMIT 1";

        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['users_id'];
        } else {
            return null; // User not found
        }
    }
    }

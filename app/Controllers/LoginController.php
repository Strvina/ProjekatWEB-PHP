<?php
require_once 'models/LoginModel.php';
require_once 'models/Log.php';

class LoginController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser()
    {
        $data = [
            'usernameErr' => '',
            'passwordErr' => '',
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $loginModel = new LoginModel(
                $this->conn,
                $username,
                $password,
            );
            
            if ($loginModel->isValidUser($username, $password)) {
                $user_id = $loginModel->getUserId($username);
                
                $_SESSION['users_id'] = $user_id;
                $_SESSION['username'] = $username;
                $role = $loginModel->getUserRole($username);
                $_SESSION['role'] = $role;

                Log::writeToLog("User logged in: $username");
                if ($role) {
                    switch ($role) {
                        case 'user':
                            header('Location: index.php?page=userPage');
                            exit();
                            break;
                        case 'admin':
                            header('Location: index.php?page=admin');
                            exit();
                            break;
                        case 'manager':
                            header('Location: index.php?page=manager');
                            exit();
                            break;
                        default:
                            return "Invalid role";
                    }
                } else {
                    $data['passwordErr'] = "User not found.";
                    require_once 'views/login.php';
                }
            } else {
                $data['passwordErr'] = "Invalid username or password. Please try again.";
                require_once 'views/login.php';
            }
        } else {
            require_once 'views/login.php';
        }
    }
}

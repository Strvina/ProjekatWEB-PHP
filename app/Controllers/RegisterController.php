<?php

require_once 'models/RegisterModel.php';

class RegisterController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleFormSubmission()
    {
        $data = [
            'username' => '',
            'name' => '',
            'surname' => '',
            'email' => '',
            'dob' => '',
            'gender' => '',
            'usernameErr' => '',
            'nameErr' => '',
            'surnameErr' => '',
            'emailErr' => '',
            'passwordErr' => '',
            'retypePasswordErr' => '',
            'dobErr' => '',
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data['username'] = $_POST["username"] ?? '';
            $data['name'] = $_POST["name"] ?? '';
            $data['surname'] = $_POST["surname"] ?? '';
            $data['email'] = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';
            $retypePassword = $_POST["retypePassword"] ?? '';
            $data['dob'] = $_POST["dob"] ?? '';
            $data['gender'] = $_POST["gender"] ?? '';

            $isValid = true;

            if (empty($data['username'])) {
                $data['usernameErr'] = "Username is required";
                $isValid = false;
            }

            if (empty($data['name'])) {
                $data['nameErr'] = "Name is required";
                $isValid = false;
            }

            if (empty($data['surname'])) {
                $data['surnameErr'] = "Surname is required";
                $isValid = false;
            }

            if (empty($data['email'])) {
                $data['emailErr'] = "Email is required";
                $isValid = false;
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailErr'] = "Invalid email format";
                $isValid = false;
            }

            if (empty($password)) {
                $data['passwordErr'] = "Password is required";
                $isValid = false;
            } elseif (strlen($password) < 6) {
                $data['passwordErr'] = "Password should be at least 6 characters long";
                $isValid = false;
            } elseif ($password !== $retypePassword) {
                $data['retypePasswordErr'] = "Passwords do not match";
                $isValid = false;
            }

            if (empty($data['dob'])) {
                $data['dobErr'] = "Date of Birth is required";
                $isValid = false;
            }

            if ($isValid) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $registerModel = new RegisterModel(
                    $this->conn,
                    $data['username'],
                    $data['name'],
                    $data['surname'],
                    $data['email'],
                    $hashedPassword,
                    $data['dob'],
                    $data['gender'],
                    $data['role']
                );


                $isUsernameRegistered = $registerModel->isUsernameRegistered($data['username']);
                $isEmailRegistered = $registerModel->isEmailRegistered($data['email']);

                if ($isUsernameRegistered && $isEmailRegistered) {
                    $data['usernameErr'] = 'Username is already taken';
                    $data['emailErr'] = 'Email is already registered';
                } elseif ($isUsernameRegistered) {
                    $data['usernameErr'] = 'Username is already taken';
                } elseif ($isEmailRegistered) {
                    $data['emailErr'] = 'Email is already registered';
                }
                 else {
                    $registrationResult = $registerModel->registerUser(
                        $data['username'],
                        $data['name'],
                        $data['surname'],
                        $data['email'],
                        $hashedPassword,
                        $data['dob'],
                        $data['gender']
                        
                    );

                    if ($registrationResult == true) {
                        Log::writeToLog("User registered in: " . $data['username']);

                        header("Location: index.php?page=login");
                        exit();
                    }
        }
    }
}
require_once 'views/register.php';
}
}
?>
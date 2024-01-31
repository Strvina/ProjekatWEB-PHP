<?php

use App\Models\LanguageModel;
use App\Models\UserModel;
use App\Models\SuggestionModel;

require_once 'models/Log.php';

class HomeController 
{
    public function index() 
    {
        require_once 'views/home.php';
    }

    public function userPage() 
    {
        require_once 'views/userPage.php';
    }

    public function promote_user() 
    {
        require_once 'views/promote_user.php';
    }
    public function logout()
    {
        session_unset();
        session_destroy();
        require_once 'views/home.php'; 
        exit();
    }

    private function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function isManager()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'manager';

}

function handleUserChoiceForm() {
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["language"]) && isset($_POST["format"])) {
            $language = $_POST["language"];
            $format = $_POST["format"];

            $languageQuery = "SELECT language_id FROM Language WHERE language_name = '$language'";
            $formatQuery = "SELECT format_id FROM StudyFormat WHERE format_name = '$format'";

            $languageResult = $conn->query($languageQuery);
            $formatResult = $conn->query($formatQuery);

            if ($languageResult && $formatResult) {
                $languageRow = $languageResult->fetch_assoc();
                $formatRow = $formatResult->fetch_assoc();

                $languageId = $languageRow["language_id"];
                $formatId = $formatRow["format_id"];

                if (isset($_SESSION['users_id'])) {
                    $userId = $_SESSION['users_id'];
                    $username = $_SESSION['username'];

                    $checkQuery = "SELECT * FROM UserChoice WHERE users_id = $userId AND format_id = $formatId AND language_id = $languageId";
                    $checkResult = $conn->query($checkQuery);

                    if ($checkResult->num_rows > 0) {
                        echo "Already Enrolled!!!";
                    } else {
                        $insertQuery = "INSERT INTO UserChoice (users_id, format_id, language_id) VALUES ($userId, $formatId, $languageId)";
                        if ($conn->query($insertQuery)) {
                            echo "You have successfully enrolled to learn $language with $format.";
                            Log::writeToLog("The $username has chosen to learn $language with $format");
                        } else {
                            echo "Error inserting user choice.";
                        }
                    }
                } else {
                    echo "User not logged in.";
                }
            } else {
                echo "Language or format not found.";
            }
        } else {
            echo "Language and format not provided.";
        }
    }
}
    
    function handleUserSuggestion() {
        global $conn;
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $suggestion = $_POST["suggestion"];

                if (isset($_SESSION['users_id'])) {
                    $userId = $_SESSION['users_id'];
                    $username = $_SESSION['username'];
    
                        $insertQuery = "INSERT INTO UserSuggestions (user_id, suggestion_text) VALUES ($userId, '$suggestion')";
                        if ($conn->query($insertQuery)) {
                            echo "You have successfully written a suggestion!";
                            Log::writeToLog("The $username has written suggestions for $suggestion");
                        } else {
                            echo "Error inserting user suggestion.";
                        }
                } else {
                    echo "User not logged in.";
                }  
        }
    }
    
   

    public function showManagerPage()
    {
        global $conn;
        $languages = LanguageModel::getAllLanguages($conn);
        $userss = UserModel::getAllUsers($conn);
        $suggestions = SuggestionModel::getAllSuggestions($conn);

        $query = "SELECT users.users_id,users.username, users.name,users.surname, users.role FROM users";
        $result = $conn->query($query);

        $users = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        $queryUserChoice = "SELECT uc.*, l.language_name, sf.format_name
        FROM UserChoice uc
        JOIN Language l ON uc.language_id = l.language_id
        JOIN StudyFormat sf ON uc.format_id = sf.format_id";
        
        $result1 = $conn->query($queryUserChoice);

        $userChoices = [];

        if ($result1 && $result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                $userChoices[] = $row;
            }
        }

        require_once 'views/manager.php';
    }

    public function showAdminPage()
    {
        global $conn;
        $languages = LanguageModel::getAllLanguages($conn);
        $users = UserModel::getAllUsers($conn);
        $suggestions = SuggestionModel::getAllSuggestions($conn);

        $query = "SELECT users.users_id,users.username, users.name,users.surname, users.role FROM users";
        $result = $conn->query($query);

        $users = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        $queryUserChoice = "SELECT uc.*, u.username AS username, l.language_name, sf.format_name
        FROM UserChoice uc
        JOIN Users u ON uc.users_id = u.users_id
        JOIN Language l ON uc.language_id = l.language_id
        JOIN StudyFormat sf ON uc.format_id = sf.format_id;";
        
        $result1 = $conn->query($queryUserChoice);

        $userChoices = [];

        if ($result1 && $result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                $userChoices[] = $row;
            }
        }

        require_once 'views/admin.php';
    }

public function deleteUser()
{
    global $conn;

    if ($this->isAdmin()) {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_user'])) {
            $userId = $_POST["users_id"];

            $deleteUserChoiceQuery = "DELETE FROM UserChoice WHERE users_id = $userId";
            $deleteUserSuggestionQuery = "DELETE FROM usersuggestions WHERE user_id = $userId";
            if ($conn->query($deleteUserChoiceQuery) && $conn->query($deleteUserSuggestionQuery)){

                $user = UserModel::findByUserId($userId, $conn);

                if ($user && $user->delete($userId, $conn)) {
                    header('Location: index.php?page=admin');
                    Log::writeToLog("Admin deleted user with ID: " . $userId);
                    exit();
                } else {
                    echo "Error deleting user.";
                }
            } else {
                echo "Error deleting related user choices.";
            }
        }
    } else {
        echo "You don't have permission to delete users.";
    }
}

public function editUser()
{
    global $conn;

    if ($this->isAdmin() && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_user'])) {
        $userId = $_POST["users_id"];
        $newUsername = $_POST["username"];
        $newName = $_POST["name"];
        $newSurname = $_POST["surname"];
        $newRole = $_POST["role"];
        var_dump($userId,$newUsername,$newName, $newSurname, $newRole );
        $user = UserModel::findByUserId($userId, $conn);

        if ($user && $user->editUserInfo($newUsername, $newName, $newSurname, $newRole, $userId, $conn)) {
            header('Location: index.php?page=admin');
            Log::writeToLog("Admin edited user with ID: " . $userId . " - New Name: " . $newName . ", New Surname: " . $newSurname . ", New Role: " . $newRole);
            exit();
        } else {
            echo "Error updating user.";
        }
    }
}

public function promoteUser()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['promote_user'])) {
        $userId = $_POST["users_id"];
        $promotionOption = $_POST["promotion"];

        $user = UserModel::findByUserId($userId, $conn);
        if ($user) {
            if ($promotionOption === "manager") {
                $newRole = "manager";
            } elseif ($promotionOption === "user") {
                $newRole = "user";
            } else {
                $newRole = $user->getRole();
            }

            if ($user->updateRole($newRole, $userId, $conn)) {
                header('Location: index.php?page=manager');
                Log::writeToLog("Manager promoted: " . $userId);
                exit();
            } else {
                header('Location: index.php?page=manager&message=' . urlencode("You can't change admin's role"));
                Log::writeToLog("Admin promoted: " . $userId);
            }
        } else {
            echo "User not found.";
        }
    }
}

public function addLanguage()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_language'])) {
        $languageName = $_POST['language_name'];

        $query = "INSERT INTO language (language_name) VALUES ('$languageName')";
        if ($conn->query($query)) {
            if ($this->isManager()) {

                header('Location: index.php?page=manager');
                Log::writeToLog("Manager added a new language: " . $languageName);
                exit();
            } else {
                header('Location: index.php?page=admin');
                Log::writeToLog("Admin added a new language: " . $languageName);
                exit();
            }
        } else {
            echo "Error adding language. Please try again.";
        }
    }
}

public function addStudyFormat()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_study_format'])) {
        $formatName = $_POST['format_name'];
        $price = $_POST['price'];

        $query = "INSERT INTO studyformat (format_name, price) VALUES ('$formatName', $price)";
        if ($conn->query($query)) {
            if ($this->isManager()) {
                header('Location: index.php?page=manager');
                Log::writeToLog("Manager added a new study format: " . $languageName);
                exit();
            } else {
                header('Location: index.php?page=admin');
                Log::writeToLog("Admin added a new study format: " . $languageName);
                exit();
            }
        } else {
            echo "Error adding study format. Please try again.";
        }
    }
}





}
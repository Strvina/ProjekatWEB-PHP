<?php
namespace App\Models;
class SuggestionModel {
    private $suggestionId;
    private $user_id;
    private $suggestionText;
    private $submissionDate;

    public function __construct($suggestionId, $user_id, $suggestionText, $submissionDate) {
        $this->suggestionId = $suggestionId;
        $this->user_id = $user_id;
        $this->suggestionText = $suggestionText;
        $this->submissionDate = $submissionDate;
    }

    public function getSuggestionId()
    {
        return $this->suggestionId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getSuggestionText()
    {
        return $this->suggestionText;
    }

    public function getSubmissionDate()
    {
        return $this->submissionDate;
    }

    private function fetchUserNameById($userId)
    {
        global $conn;

        $query = "SELECT name FROM users WHERE users_id = $userId";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['name'];
        }

        return 'Unknown User';
    }

    public function getUserName()
    {
        return $this->fetchUserNameById($this->user_id);
    }

    

    public static function getAllSuggestions($conn) {
        $query = "SELECT s.suggestion_id, s.user_id, u.name AS user_name, s.suggestion_text, s.submission_date
        FROM usersuggestions s
        JOIN users u ON s.user_id = u.users_id";
        $result = $conn->query($query);
    
        $suggestions = [];
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $suggestion = new SuggestionModel($row['suggestion_id'], $row['user_id'], $row['suggestion_text'], $row['submission_date']);
                $suggestions[] = $suggestion;
            }
        }
    
        return $suggestions;
    }
}

?>

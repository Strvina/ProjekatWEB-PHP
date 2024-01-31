<?php

namespace App\Models;

require_once 'connection.php';

class LanguageModel
{
    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public static function getAllLanguages($conn) {
        $query = "SELECT * FROM language";
        $result = $conn->query($query);

        $languages = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $language = new LanguageModel($row['language_id'], $row['language_name']);
                $languages[] = $language;
            }
        }

        return $languages;
    }
    
}

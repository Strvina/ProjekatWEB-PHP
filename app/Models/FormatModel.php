<?php

namespace App\Models;

class FormatModel
{
    private $id;
    private $name;
    private $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getAllFormats($conn) {
        $query = "SELECT * FROM studyformat";
        $result = $conn->query($query);

        $formats = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $format = new FormatModel($row['format_name'], $row['format_price']);
                $formats[] = $format;
            }
        }

        $conn->close();

        return $formats;
}
}

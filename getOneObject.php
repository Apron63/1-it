<?php

require_once 'db.php';

$connection = new db();
if (null === $connection) {
    return null;
}

$content = '';

if (isset($_GET['id'], $_GET['tableName'])) {
    $id = (int)$_GET['id'];
    $tableName = $_GET['tableName'];
    $stmt = $connection->dbcon->prepare("SELECT * FROM {$tableName} WHERE id = :id");
    $stmt->bindParam(':id', $id);
    if ($res = $stmt->execute()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    switch ($tableName) {
        case 'news':
            $content = '<p>Id: ' . $row['id'] . '</p>'
                . '<p>Наименование: ' . $row['name'] . '</p>'
                . '<p>Текст: ' . $row['intro_text'] . '</p>'
                . '<img src="' . $row['thumb'] . '" style="height:150px; width=auto;">';
            break;

        case 'photo_album':
            $content = '<p>Id: ' . $row['id'] . '</p>'
                . '<p>Наименование: ' . $row['name'] . '</p>'
                . '<p>Текст: ' . $row['description'] . '</p>'
                . '<img src="' . $row['thumb'] . '" style="height:150px; width=auto;">';
            break;

        case 'contact':
            $content = '<p>Id: ' . $row['id'] . '</p>'
                . '<p>Наименование: ' . $row['name'] . '</p>'
                . '<p>Город: ' . $row['city'] . '</p>'
                . '<p>Адрес: ' . $row['address'] . '</p>';
            try {
                $networks = json_decode($row["social_networks"], JSON_UNESCAPED_UNICODE, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
            }
            foreach ($networks as $item) {
                $content .= '<div>'
                    . '<p><a href="' . $item['url'] . '">' . $item['name'] . '</a></p>'
                    . '</div>';
            }
            break;
    }
}

echo $content;

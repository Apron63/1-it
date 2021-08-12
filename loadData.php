<?php

require_once 'db.php';
require_once 'config.php';

$connection = new db();

if (null === $connection) {
    return null;
}

$config = new config();

prepareTable($connection, 'news');
loadData($connection, $config->newsUrl, 'news');

prepareTable($connection, 'photo_album');
loadData($connection, $config->photoAlbumsUrl, 'photo_album');

prepareTable($connection, 'contact');
loadData($connection, $config->contactsUrl, 'contact');

header("Location: /");
die();

/**
 * @param $connection
 * @param $tableName
 */
function prepareTable($connection, $tableName)
{
    $sql = "TRUNCATE TABLE {$tableName}";
    $connection->dbcon->exec($sql);
}

/**
 * @param $connection
 * @param string $url
 * @param string $tableName
 */
function loadData($connection, $url = '', $tableName = '')
{
    $data = file_get_contents($url);
    if (null !== $data) {
        try {
            $result = json_decode($data, JSON_UNESCAPED_UNICODE, 512, JSON_THROW_ON_ERROR);
            if (!empty($result)) {
                if ($tableName === 'contact') {
                    loadRow($connection, $result['data'], $tableName);
                } else {
                    foreach ($result['data'] as $row) {
                        loadRow($connection, $row, $tableName);
                    }
                }
            }
        } catch (JsonException $e) {
            die('Cannot encode remote data.');
        }
    }
}

/**
 * @param $connection
 * @param $row
 * @param $tableName
 * @throws JsonException
 */
function loadRow($connection, $row, $tableName)
{
    switch ($tableName) {
        case 'news':
            $sql =
                "INSERT INTO {$tableName} (
                    id, 
                    name,
                    intro_text, 
                    image, 
                    thumb, 
                    shared_url, 
                    created_at, 
                    views_count, 
                    favorites_count, 
                    comments_count, 
                    is_viewed, 
                    is_favorited 
                ) VALUES (
                    {$row['id']},
                    '{$row['name']}',
                    '{$row['intro_text']}',
                    '{$row['image']}',
                    '{$row['thumb']}',
                    '{$row['shared_url']}',
                    '" . date("Y-m-d H:i:s", $row['created_at']) . "',
                    " . (int)$row['views_count'] . ",
                    " . (int)$row['favorites_count'] . ",
                    " . (int)$row['comments_count'] . ",
                    " . (int)$row['is_viewed'] . ",
                    " . (int)$row['is_favorited'] . "
            )";
            break;

        case 'photo_album':
            $sql =
                "INSERT INTO {$tableName} (
                    id, 
                    name,
                    description, 
                    image, 
                    thumb, 
                    created_at 
                ) VALUES (
                    {$row['id']},
                    '{$row['name']}',
                    '{$row['description']}',
                    '{$row['image']}',
                    '{$row['thumb']}',
                    '" . date("Y-m-d H:i:s", $row['created_at']) . "'
            )";
            break;

        case 'contact':
            $sql =
                "INSERT INTO {$tableName} (
                    id, 
                    name,
                    city, 
                    address, 
                    longitude, 
                    latitude,
                    phone,
                    fax,
                    email,
                    social_networks 
                ) VALUES (
                    {$row['id']},
                    '{$row['name']}',
                    '{$row['city']}',
                    '{$row['address']}',
                    '{$row['longitude']}',
                    '{$row['latitude']}',
                    '{$row['phone']}',
                    '{$row['fax']}',
                    '{$row['email']}',
                    '" . json_encode($row["social_networks"], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) . "'
            )";
            break;
        default:
            $sql = '';
            break;
    }

    if (!empty($sql)) {
        $connection->dbcon->exec($sql);
    }
}


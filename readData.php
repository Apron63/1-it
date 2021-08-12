<?php

require_once 'db.php';
require_once 'config.php';

$connection = new db();

if (null === $connection) {
    return null;
}

$whereString = ' WHERE 1';
parse_str($_SERVER['QUERY_STRING'], $urlParams);

if (!empty($urlParams['term'])) {
    $whereString .= " AND name LIKE '%{$urlParams['term']}%'";
}

if (!empty($urlParams['dir'])) {
    if ($urlParams['dir'] === "asc") {
        $whereString .= ' ORDER BY created_at ASC';
    } elseif ($urlParams['dir'] === "desc") {
        $whereString .= ' ORDER BY created_at DESC';
    }
}

$news = [];
$sql = "SELECT * FROM news";

if (isset($urlParams['table']) && $urlParams['table'] === 'news') {
    $sql .= $whereString;
}
$stmt = $connection->dbcon->prepare($sql);

if ($res = $stmt->execute()) {
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $news[] = $res;
    }
}

$album = [];
$sql = 'SELECT * FROM photo_album';

if (isset($urlParams['table']) && $urlParams['table'] === 'album') {
    $sql .= $whereString;
}
$stmt = $connection->dbcon->prepare($sql);

if ($res = $stmt->execute()) {
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $album[] = $res;
    }
}

$contact = [];
$stmt = $connection->dbcon->prepare("SELECT * FROM contact");

if ($res = $stmt->execute()) {
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $contact[] = $res;
    }
}

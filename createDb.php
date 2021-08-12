<?php

require_once 'db.php';

$connection = new db();
if (null === $connection->dbcon) {
    exit(1);
}

$sql = 'CREATE TABLE IF NOT EXISTS `news` ( 
            `id` INT NOT NULL, 
            `name` VARCHAR(255) NOT NULL, 
            `intro_text` VARCHAR(255) NOT NULL, 
            `image` VARCHAR(255), 
            `thumb` VARCHAR(255), 
            `shared_url` VARCHAR(255), 
            `created_at` DATETIME, 
            `views_count` INT, 
            `favorites_count` INT, 
            `comments_count` INT, 
            `is_viewed` TINYINT, 
            `is_favorited` TINYINT, 
            PRIMARY KEY (`ID`))
        ';
$connection->dbcon->exec($sql);
echo 'Table NEWS has been created.' . PHP_EOL;

$sql = 'CREATE TABLE IF NOT EXISTS `photo_album` ( 
            `id` INT NOT NULL, 
            `name` VARCHAR(255) NOT NULL, 
            `description` TEXT, 
            `image` VARCHAR(255), 
            `thumb` VARCHAR(255), 
            `created_at` DATETIME, 
            PRIMARY KEY (`ID`))
        ';
$connection->dbcon->exec($sql);
echo 'Table PHOTO_ALBUM has been created.' . PHP_EOL;

$sql = 'CREATE TABLE IF NOT EXISTS `contact` ( 
            `id` INT NOT NULL, 
            `name` VARCHAR(255) NOT NULL, 
            `city` VARCHAR(255), 
            `address` VARCHAR(255), 
            `longitude` FLOAT, 
            `latitude` FLOAT, 
            `phone` VARCHAR(255), 
            `fax` VARCHAR(255), 
            `email` VARCHAR(255), 
            `social_networks` JSON, 
            PRIMARY KEY (`ID`))
        ';
$connection->dbcon->exec($sql);
echo 'Table CONTACT has been created.' . PHP_EOL;

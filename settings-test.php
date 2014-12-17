<?php

global $db;

$dsn = 'mysql:host=localhost;dbname=pratthom_files';

$db = new PDO($dsn, 'pratthom', 'jAMANJI22p1RAP!RA');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


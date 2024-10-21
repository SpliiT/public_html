<?php
require_once 'db.php';
session_start();

$stmt = $pdo->query('SELECT * FROM events');
$events = $stmt->fetchAll();

include 'header.php';
include 'events_list.php';
include 'footer.php';

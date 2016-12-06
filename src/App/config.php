<?php
use App\Model\Database\SQLiteConnection;

$config = array();

$sqlLite = new SQLiteConnection();
$config['dbConnection'] = $sqlLite->connect();
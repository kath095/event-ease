<?php
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'event_ease';
$dbport = '3306';
$mysqli = new mysqli($host,$dbuser,$dbpass,$dbname,$dbport);

if($mysqli -> connect_errno){
    die("Database connection Error");
}
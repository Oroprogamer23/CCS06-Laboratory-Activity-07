<?php
session_start();
require "vendor/autoload.php"; 
use App\QuestionManager;

$manager = new QuestionManager;
if($_SERVER["REQUEST_METHOD"] == "POST" and isset ($_POST['download'])){
	
	$manager->downloadtestresult($_SESSION['answers']);
}
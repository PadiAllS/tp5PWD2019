<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
define ("SITE_ROOT", '/');

if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit();
} 
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_ROOT ?>css/style.css">
    <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type='text/javascript' src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </head>
  <body>
  <?php
   require_once 'menu.php';
  ?>

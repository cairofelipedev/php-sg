<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'config/DatabaseConfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location:login");
endif;

require_once 'config/classes/Url.class.php';
require_once 'config/classes/Helper.php';

$URI = new URI();

$url = explode("/", $_SERVER['REQUEST_URI']);
$idPost = $url[3];

if (empty($idPost)) {
  header("Location: ../posts");
}

$stmt_delete = $DB_con->prepare('DELETE FROM posts WHERE id =:uid');
$stmt_delete->bindParam(':uid', $_GET[$idPost]);
$stmt_delete->execute();
header("Location: ../posts");
?>

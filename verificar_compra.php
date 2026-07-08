<?php
session_start();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id_evento = $_GET['id'];
$_SESSION['checkout_evento_id'] = $id_evento;

if (isset($_SESSION['usuario_id'])) {
    header("Location: comprar.php?id=" . $id_evento);
} else {
    header("Location: login.php");
}
exit;
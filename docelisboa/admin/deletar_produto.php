<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

include("../backend/bd.php");

if (isset($_GET['delete'])) {
    $codproduto = $_GET['delete'];

    $sql = "DELETE FROM produto WHERE codproduto = $codproduto";

    if ($conexao->query($sql) === TRUE) {
        header('Location: painel.php');
    } else {
        echo json_encode(["success" => false, "error" => $conexao->error]);
    }
}
?>

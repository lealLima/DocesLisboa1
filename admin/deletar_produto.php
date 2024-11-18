<?php
include("../backend/bd.php");

if (isset($_GET['delete'])) {
    $codproduto = $_GET['delete'];

    // Preparar a consulta para excluir o produto
    $sql = "DELETE FROM produto WHERE codproduto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $codproduto);

    if ($stmt->execute()) {
        // Redirecionar para a página de lista de produtos após a exclusão
        header("Location: lista_produtos.php?message=Produto excluído com sucesso");
        exit();
    } else {
        echo "Erro ao excluir o produto. Tente novamente.";
    }

    $stmt->close();
}
?>

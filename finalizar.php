<?php
session_start();
include("./backend/bd.php");

if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Seu carrinho está vazio.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o pedido (ex: salvar no banco de dados)

    // Limpar o carrinho após a finalização
    unset($_SESSION['carrinho']);
    echo "Pedido finalizado com sucesso!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
</head>
<body>

<h2>Finalizar Compra</h2>

<form action="finalizar.php" method="POST">
    <ul>
        <?php foreach ($_SESSION['carrinho'] as $item): ?>
            <li><?php echo $item['nome']; ?> - Quantidade: <?php echo $item['quantidade']; ?> - Preço: R$<?php echo number_format($item['preco'], 2, ',', '.'); ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Finalizar Pedido</button>
</form>

</body>
</html>

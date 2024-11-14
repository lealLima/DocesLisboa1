<?php
session_start();

if (isset($_GET['remove'])) {
    $codProduto = $_GET['remove'];

    // Remove o produto específico do carrinho
    foreach ($_SESSION['carrinho'] as $index => $produto) {
        if ($produto['codproduto'] == $codProduto) {
            unset($_SESSION['carrinho'][$index]);
            break;
        }
    }
}

// Exibe o carrinho atualizado (pode ser chamado por AJAX)
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        echo '
        <div class="cart-item">
            <span class="fas fa-times" onclick="removerItem(\'' . $item['codproduto'] . '\')"></span>
            <img src="data:image/jpeg;base64,' . base64_encode($item['imagem']) . '" alt="' . htmlspecialchars($item['nome'], ENT_QUOTES) . '">
            <div class="content">
                <h3>' . htmlspecialchars($item['nome'], ENT_QUOTES) . '</h3>
                <div class="price">R$' . number_format($item['preco'], 2, ',', '.') . '</div>
            </div>
        </div>';
    }
    echo '<a href="finalizar_compra.php" class="btn">comprar</a>';
} else {
    echo '<p>Carrinho vazio</p>';
}
?>

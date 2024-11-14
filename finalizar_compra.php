<?php
session_start();

// Verifique se o carrinho não está vazio
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = []; // Se não existir, inicializa o carrinho
}

// Adiciona o produto ao carrinho
if (isset($_GET['add'])) {
    $codProduto = $_GET['add'];
    $quantidade = isset($_GET['quantidade']) ? $_GET['quantidade'] : 1;

    // Conecte-se ao banco de dados e obtenha os detalhes do produto
    include("./backend/bd.php");

    $sql = "SELECT * FROM produto WHERE codproduto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $codProduto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();

        // Verifica se o produto já está no carrinho
        $produtoEncontrado = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['codproduto'] == $produto['codproduto']) {
                $item['quantidade'] += $quantidade; // Incrementa a quantidade
                $produtoEncontrado = true;
                break;
            }
        }

        // Se o produto não foi encontrado, adiciona ao carrinho com a quantidade inicial
        if (!$produtoEncontrado) {
            $produto['quantidade'] = $quantidade;
            $_SESSION['carrinho'][] = $produto;
        }
    }
}

// Remover produto do carrinho
if (isset($_GET['remove'])) {
    $codProduto = $_GET['remove'];

    // Encontra o índice do produto no carrinho e o remove
    foreach ($_SESSION['carrinho'] as $index => $item) {
        if ($item['codproduto'] == $codProduto) {
            unset($_SESSION['carrinho'][$index]);
            break;
        }
    }
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Incluindo Tailwind CSS -->
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-4">Carrinho de Compras</h1>
        
        <!-- Verifica se o carrinho está vazio -->
        <?php if (empty($_SESSION['carrinho'])): ?>
            <div class="bg-red-200 p-4 text-center text-red-700 rounded-md mb-4">
                Seu carrinho está vazio!
            </div>
        <?php else: ?>
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full table-auto text-left text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">Produto</th>
                            <th class="px-6 py-3">Quantidade</th>
                            <th class="px-6 py-3">Preço</th>
                            <th class="px-6 py-3">Subtotal</th>
                            <th class="px-6 py-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrinho'] as $produto): ?>
                            <tr class="border-b">
                                <td class="px-6 py-3"><?php echo htmlspecialchars($produto['nome']); ?></td>
                                <td class="px-6 py-3"><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                                <td class="px-6 py-3">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                <td class="px-6 py-3">R$ <?php echo number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.'); ?></td>
                                <td class="px-6 py-3">
                                    <a href="carrinho.php?remove=<?php echo $produto['codproduto']; ?>" class="text-red-600 hover:text-red-800">Remover</a>
                                </td>
                            </tr>
                            <?php $total += $produto['preco'] * $produto['quantidade']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>                        
            <div class="mt-6 flex justify-between items-center">
                <p class="text-lg font-semibold">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
                <a href="checkout.php" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Finalizar Compra</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

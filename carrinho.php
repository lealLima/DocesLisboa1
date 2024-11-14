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

// Aumentar quantidade
if (isset($_GET['increase'])) {
    $codProduto = $_GET['increase'];
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['codproduto'] == $codProduto) {
            $item['quantidade']++;
            break;
        }
    }
}

// Diminuir quantidade
if (isset($_GET['decrease'])) {
    $codProduto = $_GET['decrease'];
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['codproduto'] == $codProduto && $item['quantidade'] > 1) {
            $item['quantidade']--;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Incluindo Tailwind CSS -->
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Container principal -->
    <div class="container mx-auto p-6">

        <!-- Título do Carrinho -->
        <h1 class="text-4xl font-semibold text-center text-gray-800 mb-8">Carrinho de Compras</h1>
        
        <!-- Verifica se o carrinho está vazio -->
        <?php if (empty($_SESSION['carrinho'])): ?>
            <div class="bg-red-200 p-4 text-center text-red-700 rounded-md mb-8">
                Seu carrinho está vazio!
            </div>
        <?php else: ?>
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-6">
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
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3"><?php echo htmlspecialchars($produto['nome']); ?></td>
                                <td class="px-6 py-3 flex items-center">
                                    <a href="carrinho.php?decrease=<?php echo $produto['codproduto']; ?>" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-300">-</a>
                                    <span class="mx-2"><?php echo htmlspecialchars($produto['quantidade']); ?></span>
                                    <a href="carrinho.php?increase=<?php echo $produto['codproduto']; ?>" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-300">+</a>
                                </td>
                                <td class="px-6 py-3">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                <td class="px-6 py-3">R$ <?php echo number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.'); ?></td>
                                <td class="px-6 py-3">
                                    <a href="carrinho.php?remove=<?php echo $produto['codproduto']; ?>" class="text-red-600 hover:text-red-800 font-semibold transition duration-300">Remover</a>
                                </td>
                            </tr>
                            <?php $total += $produto['preco'] * $produto['quantidade']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Total e Botão de Finalização -->
            <div class="mt-8 flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <p class="text-xl font-semibold text-gray-800">Total: <span class="text-green-600">R$ <?php echo number_format($total, 2, ',', '.'); ?></span></p>
                <a href="index.php" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">Voltar</a>
                <a href="checkout.php" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">Finalizar Compra</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
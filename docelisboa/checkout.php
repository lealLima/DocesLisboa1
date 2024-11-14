<?php
session_start();
include("./backend/bd.php"); // Arquivo de conexão com o banco de dados

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$total = 0;

// Começa uma transação manualmente
$conexao->autocommit(FALSE); // Desativa o autocommit para controle de transações

try {
    foreach ($_SESSION['carrinho'] as $produto) {
        $nome = $produto['nome'];
        $quantidade = $produto['quantidade'];
        $preco = $produto['preco'];
        $subtotal = $preco * $quantidade;
        $total += $subtotal;

        // Insere o pedido no banco
        $stmt = $conexao->prepare("INSERT INTO pedidos (produto, quantidade, preco, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sidi", $nome, $quantidade, $preco, $subtotal);
        $stmt->execute();
    }

    // Confirma a transação
    $conexao->commit();

    // Limpa o carrinho após finalizar o pedido
    unset($_SESSION['carrinho']);

    echo "";
} catch (mysqli_sql_exception $e) {
    // Em caso de erro, desfaz a transação
    $conexao->rollback();
    echo "Erro ao salvar o pedido: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Pedido Finalizado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-wider">

    <!-- Container principal -->
    <div class="container mx-auto p-8">

        <!-- Cabeçalho -->
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-green-600">Pedido Finalizado</h1>
        </header>

        <!-- Detalhes do Pedido -->
        <section class="bg-white shadow-lg rounded-lg p-6">
            <p class="text-xl text-gray-800">Obrigado por sua compra!</p>
            <p class="mt-4 text-lg text-gray-600">O total foi de:</p>
            <p class="mt-2 text-3xl font-bold text-green-600">
                R$ <?php echo number_format($total, 2, ',', '.'); ?>
            </p>
        </section>

        <!-- Botão para voltar -->
        <div class="text-center mt-8">
            <a href="index.php" class="px-6 py-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition duration-200">
                Voltar para a Página Principal
            </a>
        </div>
        
    </div>

</body>
</html>
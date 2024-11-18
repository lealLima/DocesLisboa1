<?php
include("../backend/bd.php");

// Verificar se o pedido de exclusão foi feito
if (isset($_POST['delete'])) {
    $codproduto = $_POST['codproduto'];
    $sql_delete = "DELETE FROM produto WHERE codproduto = ?";
    $stmt = $conexao->prepare($sql_delete);
    $stmt->bind_param("i", $codproduto);
    if ($stmt->execute()) {
        $message = "Produto excluído com sucesso.";
    } else {
        $message = "Erro ao excluir produto.";
    }
}

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Lista de Produtos</title>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Produtos Disponíveis</h1>

    <!-- Exibir mensagem de sucesso ou erro -->
    <?php if (isset($message)): ?>
        <div class="bg-green-500 text-white px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 bg-gray-200 text-gray-700 text-left text-sm font-semibold">Imagem</th>
                    <th class="px-5 py-3 bg-gray-200 text-gray-700 text-left text-sm font-semibold">Nome</th>
                    <th class="px-5 py-3 bg-gray-200 text-gray-700 text-left text-sm font-semibold">Preço</th>
                    <th class="px-5 py-3 bg-gray-200 text-gray-700 text-left text-sm font-semibold">Estoque</th>
                    <th class="px-5 py-3 bg-gray-200 text-gray-700 text-left text-sm font-semibold">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($produto = $resultado->fetch_assoc()) {
                        echo '
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 border-b border-gray-200">
                                <img src="data:image/jpeg;base64,' . base64_encode($produto['imagem']) . '" alt="' . $produto['nome'] . '" class="w-16 h-16 object-cover rounded shadow">
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 text-gray-700 font-semibold">' . $produto['nome'] . '</td>
                            <td class="px-5 py-4 border-b border-gray-200 text-gray-700">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</td>
                            <td class="px-5 py-4 border-b border-gray-200 text-gray-700">' . $produto['estoque'] . '</td>
                            <td class="px-5 py-4 border-b border-gray-200">
                                <div class="flex space-x-3">
                                    <a href="editar_produto.php?edit=' . $produto['codproduto'] . '" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 shadow transition-colors">Editar</a>
                                    <!-- Formulário para excluir o produto -->
                                    <form action="" method="POST" onsubmit="return confirm(\'Tem certeza que deseja excluir este produto?\')">
                                        <input type="hidden" name="codproduto" value="' . $produto['codproduto'] . '">
                                        <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 shadow transition-colors">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ';
                    }
                } else {
                    echo '
                    <tr>
                        <td colspan="5" class="px-5 py-6 text-center text-gray-500">Nenhum produto encontrado.</td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

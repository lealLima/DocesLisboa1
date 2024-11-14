<?php
session_start();

include("../backend/bd.php");

if (isset($_GET['edit'])) {
    $codproduto = (int) $_GET['edit']; // Converte para inteiro para evitar injeção
    $sql = "SELECT * FROM produto WHERE codproduto = $codproduto";
    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();
    } else {
        echo "<script>alert('Produto não encontrado!'); window.location.href='painel.php';</script>";
        exit();
    }
}

// Função para editar produto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    // Verifica se uma nova imagem foi enviada
    if (!empty($_FILES['imagem']['tmp_name'])) {
        $imagem = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));
        $sql = "UPDATE produto SET nome='$nome', preco='$preco', estoque='$estoque', imagem='$imagem' WHERE codproduto=$codproduto";
    } else {
        // Atualiza sem modificar a imagem
        $sql = "UPDATE produto SET nome='$nome', preco='$preco', estoque='$estoque' WHERE codproduto=$codproduto";
    }

    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Produto atualizado com sucesso!'); window.location.href='painel.php';</script>";
    } else {
        echo "Erro ao atualizar produto: " . $conexao->error;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Editar Produto</title>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!--sidebar-->
        <div class="w-64 bg-gray-800 h-screen text-white p-5">
            <div class="text-2xl font-bold mb-6">Admin Panel</div>
            <ul>
                <li class="mb-4">
                    <a href="painel.php" class="text-white hover:bg-gray-700 p-2 block">Dashboard</a>
                </li>
                <li class="mb-4">
                    <a href="adicionar_produto.php" class="text-white hover:bg-gray-700 p-2 block">Adicionar Produto</a>
                </li>
                <li class="mb-4">
                    <a href="visualizar_produtos.php" class="text-white hover:bg-gray-700 p-2 block">Visualizar
                        Produtos</a>
                </li>
                <li class="mb-4">
                    <a href="pedidos.php" class="text-white hover:bg-gray-700 p-2 block">Pedidos</a>
                </li>
                <li>
                    <a href="index.php" class="text-red-500 hover:bg-gray-700 p-2 block">Voltar</a>
                </li>
            </ul>
        </div>

        <!--conteudo-->
        <div class="flex-1">
            <!-- Navbar -->
            <div class="bg-white p-4 shadow flex justify-between">
                <div class="font-bold text-lg">Painel </div>
                <div class="flex items-center">
                    <div class="text-gray-800">
                        <p><?php echo $_SESSION['admin']; ?></p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="container mx-auto mt-10">
                    <h1 class="text-3xl font-bold mb-6">Editar Produto</h1>
                    <form action="editar_produto.php?edit=<?php echo $codproduto; ?>" method="POST"
                        enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label for="nome" class="block">Nome do Produto:</label>
                            <input type="text" name="nome" id="nome" value="<?php echo $produto['nome']; ?>"
                                class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label for="preco" class="block">Preço:</label>
                            <input type="number" step="0.01" name="preco" id="preco"
                                value="<?php echo $produto['preco']; ?>" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label for="estoque" class="block">Estoque:</label>
                            <input type="number" name="estoque" id="estoque" value="<?php echo $produto['estoque']; ?>"
                                class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label for="imagem" class="block">Imagem:</label>
                            <input type="file" name="imagem" id="imagem" class="w-full border rounded p-2">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar
                            Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
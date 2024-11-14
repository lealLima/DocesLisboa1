<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "doceslisboa";
$conexao = new mysqli($servidor, $usuario, $senha, $dbname);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Função para adicionar produtos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $imagem = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));

    $sql = "INSERT INTO produto (nome, preco, estoque, imagem) VALUES ('$nome', '$preco', '$estoque', '$imagem')";
    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Produto adicionado com sucesso!');</script>";
    } else {
        echo "Erro ao adicionar produto: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Adicionar Produto</title>
</head>
<div class="flex">
    <!-- Sidebar -->
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
                <a href="exibir_produtos.php" class="text-white hover:bg-gray-700 p-2 block">Visualizar Produtos</a>
            </li>
            <li class="mb-4">
                <a href="pedidos.php" class="text-white hover:bg-gray-700 p-2 block">Pedidos</a>
            </li>
            <li>
                <a href="index.php" class="text-red-500 hover:bg-gray-700 p-2 block">Voltar</a>
            </li>
        </ul>
    </div>

    <body class="bg-gray-100">
        <div class="flex-1">
            <div class="bg-white p-4 shadow flex justify-between">
                <div class="font-bold text-lg">Painel de Administração</div>
                <div class="flex items-center">
                    <img src="images/logo.jpg" alt="Admin" class="rounded-full mr-3">
                    <div class="text-gray-800"> 
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="container mx-auto mt-10">
                    <h1 class="text-3xl font-bold mb-6">Adicionar Produto</h1>
                    <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label for="nome" class="block">Nome do Produto:</label>
                            <input type="text" name="nome" id="nome" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label for="preco" class="block">Preço:</label>
                            <input type="number" step="0.01" name="preco" id="preco" class="w-full border rounded p-2"
                                required>
                        </div>
                        <div>
                            <label for="estoque" class="block">Estoque:</label>
                            <input type="number" name="estoque" id="estoque" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label for="imagem" class="block">Imagem:</label>
                            <input type="file" name="imagem" id="imagem" class="w-full border rounded p-2" required>
                        </div>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Adicionar
                            Produto</button>
                    </form>
                </div>
            </div>
        </div>


    </body>

</html>
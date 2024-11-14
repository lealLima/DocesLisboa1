<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Painel Admin</title>
</head>

<body class="bg-gray-100 h-screen flex">
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
                <a href="pedidos.php" class="text-white hover:bg-gray-700 p-2 block">Pedidos</a>
            </li>
            <li>
                <a href="index.php" class="text-red-500 hover:bg-gray-700 p-2 block">Voltar</a>
            </li>
        </ul>
    </div>

    <!-- Conteúdo principal -->
    <div class="flex-1 p-8">

        <!-- Tabela de Produtos -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <tbody>
                    <?php
                    include 'exibir_produtos.php';
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
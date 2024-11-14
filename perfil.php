<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans">

    <div class="container mx-auto my-10 p-8 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Perfil do Usuário</h1>

        <div class="space-y-4">
            <p class="text-lg text-gray-700"><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
            <p class="text-lg text-gray-700"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        </div>

        <div class="mt-8 text-center">
        <a href="index.php" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition duration-300">Voltar</a>  
        <a href="logout.php" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition duration-300">Sair da Conta</a>
        </div>
    </div>

</body>
</html>

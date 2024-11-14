<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if ($email == 'admin@doceslisboa.com' && $senha == $email) {
        $_SESSION['admin'] = $email;
        header('Location: painel.php');
        exit();
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Login Admin</title>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded shadow-md w-1/3">
            <h2 class="text-2xl font-bold mb-4">Login Admin</h2>
            <?php if (isset($erro)) echo "<p class='text-red-500'>$erro</p>"; ?>
            <form action="painel.php" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block">Email:</label>
                    <input type="email" name="email" id="email" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label for="senha" class="block">Senha:</label>
                    <input type="password" name="senha" id="senha" class="w-full border rounded p-2" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
            </form>
            <br>
            <a class="bg-blue-500 text-white px-4 py-2 rounded" href="../index.php">Voltar</a>

        </div>
    </div>
</body>
</html>

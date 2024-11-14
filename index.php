<?php
include("./backend/bd.php");
session_start();

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['add'])) {
    $codProduto = $_GET['add'];
    $sql = "SELECT * FROM produto WHERE codproduto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $codProduto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();
        $_SESSION['carrinho'][] = $produto;
    }
}

$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doces Lisboa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <a href="#" class="logo"><img src="images/logo.jpg" alt=""></a>
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#sobre">Sobre</a>
            <a href="#menu">Menu</a>
            <a href="#contato">Contato</a>
        </nav>
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-shopping-cart text-white cursor-pointer" onclick="toggleSidebar()"></div>

            <!-- Ícone de perfil -->
            <div class="fas fa-user-circle text-white cursor-pointer">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="perfil.php" class="text-white">
                        <i class="fas fa-user-circle"></i>
                    </a>
                <?php else: ?>
                    <!-- Caso o usuário não esteja logado, pode-se adicionar um link para login ou uma ação alternativa -->
                    <a href="login.php" class="text-white">
                        <i class="fas fa-user-circle"></i>
                    </a>
                <?php endif; ?>
            </div>

            <div class="fas fa-bars" id="menu-btn"></div>
        </div>


    </header>

    <!-- CARRINHO -->
    <div id="cartSidebar"
        class="fixed top-0 right-0 w-64 sm:w-72 md:w-96 h-full bg-white shadow-lg transition-transform transform translate-x-full z-50">
        <div class="p-4 border-t">
            <div class="flex justify-between mb-2">
                <span>Total:</span>
                <span id="cartTotal">R$<?php echo number_format($total, 2, ',', '.'); ?></span>
            </div>
            <a href="checkout.php" class="bg-blue-500 text-white px-4 py-2 rounded w-full text-center block">Finalizar
                Compra</a>
        </div>

        <div id="cartItems" class="p-4">
            <?php if (!empty($_SESSION['carrinho'])): ?>
                <?php foreach ($_SESSION['carrinho'] as $item): ?>
                    <div class="flex justify-between items-center mb-2">
                        <span><?php echo htmlspecialchars($item['nome'], ENT_QUOTES); ?></span>
                        <span>R$<?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Carrinho vazio</p>
            <?php endif; ?>
        </div>
        <div class="p-4 border-t">
            <div class="flex justify-between mb-2">
                <span>Total:</span>
                <span id="cartTotal">R$<?php echo number_format($total, 2, ',', '.'); ?></span>
            </div>
            <a href="checkout.php" class="bg-blue-500 text-white px-4 py-2 rounded w-full text-center block">Finalizar
                Compra</a>
        </div>
    </div>
    <!-- Fim do CARRINHO -->

    <!-- HOME -->
    <section class="home" id="home">
        <div class="imghome"></div>
        <div class="content">
            <h3>Adoce seu dia com um doce!</h3>
            <p>A Doces Lisboa trabalha com diversos tipos de doces, podemos alegrar cada momento com um docinho.</p>
            <a href="#menu" class="btn">Garanta o seu!</a>
        </div>
    </section>

 

    <!-- ABA DE SOBRE NÓS -->
    <section class="sobre py-10" id="sobre">
        <h1 class="heading text-7xl text-center md:text-7xl font-bold mb-6">
            <span class="text-7xl">Sobre</span>
            nós
        </h1>
        <div class="flex flex-col md:flex-row items-center justify-center mx-4">
            <div class="image w-full md:w-1/2 mb-6 md:mb-0">
                <img src="images/cheesecake.jpg" alt="Sobre Nós" class="w-full h-auto rounded-lg shadow-lg">
            </div>
            <div class="content w-full md:w-1/2 md:pl-6">
                <h3 class="mb-4 text-4xl text-white md:text-4xl font-sans tracking-normal">
                    Pedro Lisboa era um adolescente de 14 anos que visava um futuro promissor, então na pandemia ele
                    veio testando suas habilidades
                    fazendo doces caseiros,
                    até que um dia pós pandemico ele resolve levar seus doces na escola, onde os colegas o elogiam e
                    pedem para comprar doces.
                    Pedro viu uma oportunidade nisso, e então começa a vender seus doces para colegas de classe, vendo o
                    resultado,
                    ele expande seu negócio para colegas do futebol, parentes, amigos de fora, etc. Ele conquistou uma
                    clientela grande
                    e um bom nome no mercado da confeitaria,
                    seus atendimentos e encomendas podem ser feitos pelo whatsapp ou pelo instagram. Mas o dono percebeu
                    que um site com um
                    cardápio de doces e preços seria mais adequado e fácil para ele e seus clientes.
                </h3>
                <a href="#"
                    class="btn bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition duration-300">Saiba
                    Mais</a>
            </div>
        </div>
    </section>
    <!-- ABA DE SOBRE NÓS -->
    

    
    <!-- MENU -->
    <section class="menu py-10" id="menu">
        <h1 class="heading text-center text-7xl font-bold mb-6"> Nosso <span>menu</span> </h1>
        <div
            class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-center">
            <?php
            $sql = "SELECT * FROM produto";
            $resultado = $conexao->query($sql);
            while ($produto = $resultado->fetch_assoc()) { ?>
                <div
                    class="box flex flex-col items-center bg-white border border-gray-800 hover:bg-gray-400 p-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                    <?php if ($produto['imagem']) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($produto['imagem']); ?>"
                            alt="<?php echo $produto['nome']; ?>" class="w-24 h-24 md:w-32 md:h-32 object-cover rounded mb-4">
                    <?php } else { ?>
                        <p>Imagem não disponível</p>
                    <?php } ?>
                    <h3 class="text-base md:text-lg font-semibold mb-2 text-black"><?php echo $produto['nome']; ?></h3>
                    <div class="price text-lg md:text-xl font-bold mb-4 text-black">
                        R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                    <a href="carrinho.php?add=<?php echo $produto['codproduto']; ?>"
                        class="btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">Adicionar
                        ao Carrinho</a>
                </div>
            <?php } ?>
        </div>

    <!-- ABA DE CONTATO-->
    <section class="contato py-10" id="contato">
        <h1 class="heading text-center text-7xl font-bold mb-6"> <span>Contate - </span> nos </h1>

        <div class="row max-w-lg mx-auto">
            <form action="" class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">entre em contato</h3>
                <div class="inputBox mb-4 flex items-center border rounded">
                    <span class="fas fa-user px-2 text-gray-600"></span>
                    <input type="text" placeholder="nome" class="w-full p-2 border-none outline-none">
                </div>
                <div class="inputBox mb-4 flex items-center border rounded">
                    <span class="fas fa-envelope px-2 text-gray-600"></span>
                    <input type="email" placeholder="email" class="w-full p-2 border-none outline-none">
                </div>
                <div class="inputBox mb-4 flex items-center border rounded">
                    <span class="fas fa-phone px-2 text-gray-600"></span>
                    <input type="number" placeholder="número" class="w-full p-2 border-none outline-none">
                </div>
                <input type="submit" value="contatar"
                    class="btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red -600 transition">
            </form>
        </div>
    </section>
    <!-- ABA DE CONTATO-->

    <!--FOOTER-->
    <section class="footer">
        <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="https://www.instagram.com/doce_lisboa_/" target="_blank" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
            <a href="#" class="fab fa-pinterest"></a>
        </div>

        <div class="links">
            <a href="#home">Home</a>
            <a href="#sobre">Sobre</a>
            <a href="#menu">Menu</a> 
            <a href="#contato">Contato</a>
        </div>
        <a href="admin/index.php" class="btn">Login Admin!</a>


    </section>
    <!--FOOTER-->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('cartSidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        function mostrarCarrinho() {
            var carrinho = document.getElementById('cart-items-container');
            carrinho.classList.toggle('hidden');  // Alterna a exibição do carrinho
        }

        // Função para remover item
        function removerItem(codProduto) {
            fetch(`remover_do_carrinho.php?remove=${codProduto}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('cart-items-container').innerHTML = html;

                    // Atualiza o número de itens no carrinho na navbar
                    let cartCount = document.getElementById('cart-items-container').getElementsByClassName('cart-item').length;
                    document.getElementById('cart-count').textContent = cartCount;
                });
        }

    </script>


</body>

</html>

    <!-- SCRIPT -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('cartSidebar');
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('translate-x-full');
            }
        }
    </script>
</body>

</html>
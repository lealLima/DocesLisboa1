<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";

// Conectando ao banco de dados
$conexao = new mysqli($servidor, $usuario, $senha);

// Verificando a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Criar banco de dados
$conexao->query("CREATE DATABASE IF NOT EXISTS doceslisboa");
$conexao->select_db("doceslisboa");

// Criar tabelas
$conexao->query("CREATE TABLE IF NOT EXISTS contato (
    codcontato INT AUTO_INCREMENT PRIMARY KEY,
    redes_sociais VARCHAR(255),
    tel VARCHAR(15)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS endereco (
    codendereco INT AUTO_INCREMENT PRIMARY KEY,
    rua VARCHAR(200),
    cidade VARCHAR(100),
    numero INT NOT NULL,
    cep VARCHAR(10)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS loja (
    codloja INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200),
    codendereco INT,
    FOREIGN KEY (codendereco) REFERENCES endereco(codendereco)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS cliente (
    codcliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200),
    email VARCHAR(200),
    senha VARCHAR(200),
    codcontato INT,
    codendereco INT,
    cpf VARCHAR(20),
    FOREIGN KEY (codcontato) REFERENCES contato(codcontato),
    FOREIGN KEY (codendereco) REFERENCES endereco(codendereco)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS formapagamento (
    codformapagamento INT AUTO_INCREMENT PRIMARY KEY,
    descricao TEXT
)");

// Aqui adicionamos "IF NOT EXISTS" para evitar o erro
$conexao->query("CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conexao->query("CREATE TABLE IF NOT EXISTS pagamento (
    codpagamento INT AUTO_INCREMENT PRIMARY KEY,
    codformapagamento INT,
    codcliente INT,
    FOREIGN KEY (codformapagamento) REFERENCES formapagamento(codformapagamento),
    FOREIGN KEY (codcliente) REFERENCES cliente(codcliente)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS produto (
    codproduto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200),
    qualidade VARCHAR(50),
    preco DECIMAL(10, 2),
    estoque INT,
    descricao TEXT,
    imagem MEDIUMBLOB
)");

$conexao->query("CREATE TABLE IF NOT EXISTS fornecedor (
    codfornecedor INT AUTO_INCREMENT PRIMARY KEY,
    materiaprima VARCHAR(200),
    marcas VARCHAR(200),
    codloja INT,
    codendereco INT,
    FOREIGN KEY (codloja) REFERENCES loja(codloja),
    FOREIGN KEY (codendereco) REFERENCES endereco(codendereco)    
)");

$conexao->query("CREATE TABLE IF NOT EXISTS venda (
    codvenda INT AUTO_INCREMENT PRIMARY KEY,
    codproduto INT,
    codcliente INT,
    codpagamento INT,
    datavenda DATE,
    quantidade INT,
    FOREIGN KEY (codproduto) REFERENCES produto(codproduto),
    FOREIGN KEY (codcliente) REFERENCES cliente(codcliente),
    FOREIGN KEY (codpagamento) REFERENCES pagamento(codpagamento)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS usuario (
   id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
)");

$emailAdmin = 'admin@doceslisboa.com';
$sqlVerificarAdmin = "SELECT * FROM cliente WHERE email = '$emailAdmin'";
$resultado = $conexao->query($sqlVerificarAdmin);

if ($resultado->num_rows == 0) {
    $nomeAdmin = 'AdministradorDocesLisboa';
    $senhaAdmin = 'admin@doceslisboa.com';

    $sqlInserirAdmin = "INSERT INTO cliente (nome, email, senha) 
                        VALUES ('$nomeAdmin', '$emailAdmin', '$senhaAdmin')";

    if ($conexao->query($sqlInserirAdmin) === TRUE) {
        echo "Admin criado com sucesso.";
    } else {
        echo "Erro ao criar o admin: " . $conexao->error;
    }
}
?>
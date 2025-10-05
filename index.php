<?php
session_start();
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM funcionarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Senha incorreta');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FANESE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: url('/img/background.png') no-repeat center center fixed;
            background-size: cover; /* Faz a imagem ocupar toda a tela */
            background-color: #4caf50; /* Cor de fundo caso a imagem não carregue */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-color: #e8f5e9;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-success {
            background-color: #2e7d32;
        }
        /* Responsividade */
        @media (max-width: 768px) {
            body {
                background: #4caf50;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body text-center">
                        <h2 class="text-success">FANESE</h2>
                        <h4>Login</h4>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Insira o Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Password</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Insira sua Senha" required>
                            </div>
                            <!-- <a href="#">Esqueceu sua senha?</a> -->
                            <button type="submit" class="btn btn-success w-100 mt-3">Entrar</button>
                        </form>
                        <p class="mt-3">Não é cadastrado? <a href="pages/register.php">Cadastre-se</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
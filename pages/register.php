<?php
include 'config/db.php';

$showModal = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $data_contratacao = $_POST['data_contratacao'];
    $role = $_POST['role']; 
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO funcionarios (nome, email, cpf, telefone, cargo, data_contratacao, role, senha) 
            VALUES ('$nome', '$email', '$cpf', '$telefone', '$cargo', '$data_contratacao', '$role', '$senha')";

     if ($conn->query($sql) === TRUE) {
        $showModal = true; 
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: url('/img/background.png') no-repeat center center fixed;
            background-size: cover; 
            background-color: #4caf50; 
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
        .password-toggle {
            position: relative;
        }
        .password-toggle i {
            position: absolute;
            right: 20px;
            top: 55%;
            cursor: pointer;
        }
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
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h4 class="text-center">Cadastre-se</h4>
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o Nome Completo" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com.br" required>
                                </div>
                                <div class="col-md-6 mb-3 password-toggle">
                                    <label for="senha" class="form-label">Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                    <i class="bi bi-eye" id="toggleSenha"></i>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">CPF:</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">Telefone:</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00)00000-0000" maxlength="15" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="data_contratacao" class="form-label">Data de Contratação:</label>
                                    <input type="date" class="form-control" id="data_contratacao" name="data_contratacao" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cargo" class="form-label">Cargo:</label>
                                    <select class="form-select" id="cargo" name="cargo" required>
                                        <option selected disabled>Selecione...</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Funcionario">Funcionário</option>
                                        <option value="Gerente">Gerente</option>
                                        <option value="Analista">Analista</option>
                                        <option value="Desenvolvedor">Desenvolvedor</option>
                                        <option value="Assistente">Assistente</option>
                                        <option value="Estagiario">Estagiário</option>
                                    </select>
                                </div>
                                 <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">Usuário:</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option selected disabled>Selecione...</option>
                                        <option value="admin">Administrador</option>
                                        <option value="user">Usuário</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Cadastre-se</button>
                            <a href="../index.php" class="btn btn-danger">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Sucesso -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="successModalLabel">Cadastro Realizado!</h5>
        </div>
        <div class="modal-body text-center">
            <p>O novo funcionário foi cadastrado com sucesso.</p>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <a href="register.php" class="btn btn-outline-success">OK</a>
            <a href="index.php" class="btn btn-success">Ir para Login</a>
        </div>
        </div>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Máscara de CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length > 11) value = value.slice(0, 11);
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            e.target.value = value;
        });

        // Máscara de Telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length > 11) value = value.slice(0, 11);
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1)$2-$3");
            } else {
                value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, "($1)$2-$3");
            }
            e.target.value = value;
        });

        // Mostrar/ocultar senha
        const toggleSenha = document.getElementById('toggleSenha');
        const senhaInput = document.getElementById('senha');

        toggleSenha.addEventListener('click', () => {
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
                toggleSenha.classList.remove("bi-eye");
                toggleSenha.classList.add("bi-eye-slash");
            } else {
                senhaInput.type = "password";
                toggleSenha.classList.remove("bi-eye-slash");
                toggleSenha.classList.add("bi-eye");
            }
        });
        <?php if ($showModal): ?>
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        <?php endif; ?>
    </script>
</body>
</html>

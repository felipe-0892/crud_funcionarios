<?php
include 'config/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM funcionarios WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $data_contratacao = $_POST['data_contratacao'];
    $role = $_POST['role'];

    $sql = "UPDATE funcionarios 
            SET nome='$nome', email='$email', cpf='$cpf', telefone='$telefone', cargo='$cargo', 
                data_contratacao='$data_contratacao', role='$role' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
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
                        <h4 class="text-center">Editar Funcionário</h4>
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['nome']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">Telefone:</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $row['telefone']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">CPF:</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $row['cpf']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cargo" class="form-label">Cargo:</label>
                                    <select class="form-select" id="cargo" name="cargo" required>
                                        <option <?php if($row['cargo'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
                                        <option <?php if($row['cargo'] == 'Funcionario') echo 'selected'; ?>>Funcionário</option>
                                        <option <?php if($row['cargo'] == 'Gerente') echo 'selected'; ?>>Gerente</option>
                                        <option <?php if($row['cargo'] == 'Analista') echo 'selected'; ?>>Analista</option>
                                        <option <?php if($row['cargo'] == 'Desenvolvedor') echo 'selected'; ?>>Desenvolvedor</option>
                                        <option <?php if($row['cargo'] == 'Assistente') echo 'selected'; ?>>Assistente</option>
                                        <option <?php if($row['cargo'] == 'Estagiario') echo 'selected'; ?>>Estagiário</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="data_contratacao" class="form-label">Data de Contratação:</label>
                                    <input type="date" class="form-control" id="data_contratacao" name="data_contratacao" value="<?php echo $row['data_contratacao']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">Usuário:</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                                        <option value="user" <?php if($row['role'] == 'user') echo 'selected'; ?>>User</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            <a href="../dashboard.php" class="btn btn-danger">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Máscaras de CPF e Telefone -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const telefone = document.getElementById('telefone');
        const cpf = document.getElementById('cpf');

        telefone.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            if (value.length > 6) {
                e.target.value = `(${value.slice(0, 2)})${value.slice(2, 7)}-${value.slice(7)}`;
            } else if (value.length > 2) {
                e.target.value = `(${value.slice(0, 2)})${value.slice(2)}`;
            } else {
                e.target.value = value;
            }
        });

        cpf.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            if (value.length > 9) {
                e.target.value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(6, 9)}-${value.slice(9)}`;
            } else if (value.length > 6) {
                e.target.value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(6)}`;
            } else if (value.length > 3) {
                e.target.value = `${value.slice(0, 3)}.${value.slice(3)}`;
            } else {
                e.target.value = value;
            }
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

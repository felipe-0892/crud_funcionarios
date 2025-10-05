<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
include 'config/db.php';

$sql = "SELECT * FROM funcionarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Administrador</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

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
    margin-top: 50px;
}
.btn-danger {
    background-color: #d32f2f;
}
.table th, .table td {
    background-color: #f5f5f5;
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
    <div class="card">
        <div class="card-body">
            <h4>Dashboard - Administrador</h4>

            <!-- Filtros -->
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <input type="text" id="filterName" class="form-control" placeholder="Filtrar por Nome">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button id="btnFilter" class="btn btn-primary">Pesquisar</button>
                    <button id="btnClear" class="btn btn-secondary">Limpar</button>
                </div>
            </div>

            <table class="table table-striped" id="funcionariosTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Cargo</th>
                        <th>Data Contratação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['nome']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['cpf']; ?></td>
                                <td><?php echo $row['telefone']; ?></td>
                                <td><?php echo $row['cargo']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($row['data_contratacao'])); ?></td>
                                <td>
                                    <a href="pages/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                    <a href="pages/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Nenhum funcionário cadastrado</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end gap-2">
                <button id="generatePdf" class="btn btn-warning">Gerar PDF</button>
                <a href="login.php" class="btn btn-danger">Sair</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para filtrar a tabela
    function filterTable() {
        const nameInput = document.getElementById('filterName').value.toLowerCase();
        const table = document.getElementById('funcionariosTable');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const nome = row.cells[0].innerText.toLowerCase();
            row.style.display = nome.includes(nameInput) ? "" : "none";
        });
    }

    // Botão pesquisar
    document.getElementById('btnFilter').addEventListener('click', filterTable);

    // Botão limpar filtros
    document.getElementById('btnClear').addEventListener('click', () => {
        document.getElementById('filterName').value = "";
        filterTable(); // mostra toda a tabela
    });

    // Filtrar ao apertar Enter no input
    document.getElementById('filterName').addEventListener('keydown', (event) => {
        if (event.key === "Enter") {
            filterTable();
        }
    });

    // Botão gerar PDF
    document.getElementById('generatePdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFontSize(18);
        doc.text("Lista de Funcionários", 14, 22);

        const table = document.getElementById("funcionariosTable");
        const rows = [];
        const headers = [];

        table.querySelectorAll("thead tr th").forEach(th => {
            if(th.innerText !== "Ações") headers.push(th.innerText);
        });

        table.querySelectorAll("tbody tr").forEach(tr => {
            if(tr.style.display !== "none") {
                const row = [];
                tr.querySelectorAll("td").forEach((td,index) => {
                    if(index < headers.length) row.push(td.innerText);
                });
                rows.push(row);
            }
        });

        doc.autoTable({
            head: [headers],
            body: rows,
            startY: 30,
            styles: { fontSize: 10 }
        });

        doc.save("funcionarios.pdf");
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

# Sistema CRUD de Funcionários

> README completo para o sistema PHP de gerenciamento de funcionários (CRUD).

---

## Sumário

- [Visão geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Requisitos](#requisitos)
- [Estrutura do projeto](#estrutura-do-projeto)
- [Banco de dados](#banco-de-dados)
  - [Modelo da tabela `funcionarios`](#modelo-da-tabela-funcionarios)
  - [Comandos úteis (MySQL)](#comandos-úteis-mysql)
- [Instalação e configuração](#instalação-e-configuração)
- [Como usar](#como-usar)
- [Segurança e boas práticas](#segurança-e-boas-práticas)
- [Debug / Troubleshooting](#debug--troubleshooting)
- [Extras / Customizações comuns](#extras--customizações-comuns)
- [Contribuição](#contribuição)
- [Licença](#licença)

---

## Visão geral

Este projeto é um sistema CRUD (Create, Read, Update, Delete) simples para gerenciamento de funcionários, escrito em PHP com front-end usando HTML/CSS/Bootstrap. Serve como base para sistemas administrativos pequenos (intranet, controle de RH básico, etc.).

> Observação: o README assume que o projeto usa um arquivo de configuração `config/db.php` responsável pela conexão com o banco de dados.

---

## Funcionalidades

- Listagem de funcionários.
- Inserção (criação) de novos funcionários.
- Edição de registros existentes.
- Exclusão de funcionários.
- Upload / integração com imagens (se implementado no projeto).
- Validações básicas no front-end (HTML/JS) e no back-end (PHP).

---

## Tecnologias

- PHP (7.x / 8.x - compatível)
- MySQL / MariaDB
- HTML, CSS, JavaScript
- Bootstrap

---

## Requisitos

- Servidor web com PHP (Apache, Nginx, XAMPP, WAMP, etc.)
- MySQL ou MariaDB
- Extensões PHP `mysqli` ou `pdo_mysql`

---

## Estrutura do projeto

```
crud_funcionarios/
├─ config/
│  └─ db.php
├─ public/
│  ├─ index.php
│  ├─ novo.php
│  ├─ editar.php
│  └─ styles.css
├─ src/
│  └─ exec01Mod01.php
├─ assets/
│  └─ img/
└─ README.md
```

---

## Banco de dados

### Modelo da tabela `funcionarios`

```sql
CREATE TABLE funcionarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_completo VARCHAR(60) NOT NULL,
  email VARCHAR(50) UNIQUE NOT NULL,
  cpf VARCHAR(14) UNIQUE NOT NULL,
  telefone VARCHAR(15),
  cargo VARCHAR(20),
  data_contratacao DATE,
  role ENUM('admin','gerente','usuario') NOT NULL DEFAULT 'usuario',
  senha VARCHAR(100) NOT NULL
);
```

### Comandos úteis (MySQL)

```sql
ALTER TABLE funcionarios
  ADD COLUMN role ENUM('admin','gerente','usuario') NOT NULL DEFAULT 'usuario',
  ADD COLUMN senha VARCHAR(100) NOT NULL;
```

---

## Instalação e configuração

1. Extraia o projeto (`crud_funcionários.rar`) na pasta pública do servidor.
2. Crie o banco e importe o schema.
3. Configure `config/db.php`:

```php
<?php
$servername = "localhost";
$username = "appuser";
$password = "sua_senha";
$dbname   = "sistema_funcionarios";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
```

4. Acesse `http://localhost/crud_funcionarios/`.

---

## Segurança e boas práticas

- Use `password_hash()` e `password_verify()` para senhas.
- Use *prepared statements* para evitar SQL Injection.
- Use `htmlspecialchars()` para evitar XSS.
- Adicione tokens CSRF em formulários.
- Restringir acesso por `role` (admin/gerente/usuario).

---

## Contribuição

1. Fork o repositório.
2. Crie uma branch: `git checkout -b feature/minha-feature`.
3. Commit suas mudanças: `git commit -m "Adiciona minha feature"`.
4. Push: `git push origin feature/minha-feature`.
5. Abra um Pull Request.

---

## Licença

Licenciado sob a **MIT License**.

---

## Autor

Desenvolvido por **Felipe Silva Costa**.

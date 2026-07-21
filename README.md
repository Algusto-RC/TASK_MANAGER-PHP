# Sistema de Tarefas - PHP

Gerenciador de tarefas desenvolvido em PHP puro, com foco em organização de código, autenticação de usuários, CRUD e integração segura com MySQL por meio de PDO.

## Tecnologias

- PHP 8.1+
- MySQL
- PDO
- HTML, CSS e JavaScript
- Composer e autoload PSR-4

## Funcionalidades previstas

- Cadastro de usuários
- Login e logout
- Cadastro, edição e exclusão de tarefas
- Filtros por status
- Organização por prioridade
- Validação de formulários
- Proteção contra SQL Injection, XSS e CSRF

## Estrutura atual

```text
app/
├── Config/
│   └── Env.php
└── Database/
    └── Connection.php
bootstrap/
└── app.php
database/
└── schema.sql
public/
└── index.php
scripts/
└── check-database.php
```

## Configuração local

1. Instale as dependências e gere o autoload:

```bash
composer install
```

2. Crie o arquivo de ambiente:

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

No Linux ou macOS:

```bash
cp .env.example .env
```

3. Ajuste as credenciais do MySQL no arquivo `.env`.

4. Crie o banco utilizando `database/schema.sql`.

5. Inicie o servidor local:

```bash
composer serve
```

Acesse `http://localhost:8000`.

## Verificação da conexão

Com o banco configurado, execute:

```bash
composer check:database
```

## Objetivo

Projeto desenvolvido para demonstrar fundamentos de backend com PHP puro, banco de dados relacional, segurança, arquitetura organizada e evolução incremental por commits.

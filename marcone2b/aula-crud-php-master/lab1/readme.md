# 🧪 Lab 1: Sistema de Gerenciamento de Usuários

Neste laboratório, implementaremos um CRUD completo de usuários em PHP utilizando **PDO**.

---

## 💡 O que é PDO? (Entendendo de forma simples)

Imagine que o seu código **PHP** fala "Português" e o **Banco de Dados (MySQL)** fala "Japonês". Para eles se entenderem sem erros, precisamos de um **tradutor e intermediário de confiança**. 

O **PDO** *(PHP Data Objects)* é exatamente esse tradutor!

* **O que ele faz?** Ele pega as informações que você digita na tela, organiza e entrega com segurança para o banco de dados salvar.
* **Por que usamos ele?**
  1. **Segurança:** Ele funciona como um "filtro de segurança". Se um usuário maldoso tentar enviar um código malicioso no formulário (ataque conhecido como *SQL Injection*), o PDO desarma o ataque antes de chegar ao banco.
  2. **Facilidade:** Se um dia você decidir trocar o MySQL por outro banco (como PostgreSQL ou SQLite), não precisará reescrever o código do site todo — o PDO se adapta facilmente.

---

## 💻 Requisitos Prévios

1. Certifique-se de que o **XAMPP** está rodando (**Apache** e **MySQL** ativados).
2. Abra o **phpMyAdmin** (`http://localhost/phpmyadmin`) e execute o script SQL de criação do banco:

```sql
CREATE DATABASE IF NOT EXISTS banco_teste CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE banco_teste;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```

---

## 🚀 Como Executar o Projeto

1. Clone ou baixe este repositório.
2. Mova a pasta do projeto para o diretório raiz do Apache:
   * Windows: `C:\xampp\htdocs\aula-crud-php\`
3. Acesse no navegador: `http://localhost/aula-crud-php/lab1/`

---

## 📝 Atividade Prática (Passo a Passo)

1. **Conexão (`db.php`):** Estude a utilização do bloco `try/catch` para capturar falhas de conexão de forma amigável.
2. **Consultar ([R]ead):** Observe como a instrução `$pdo->query()` busca os registros e os exibe dentro da tabela HTML.
3. **Inserir ([C]reate):** Analise o envio do formulário via `POST` e o uso de `$pdo->prepare()` com etiquetas (`:nome`, `:email`) para garantir a segurança dos dados.
4. **Remover ([D]elete):** Veja a passagem do parâmetro `id` via `GET` e a confirmação em Javascript.
5. **Editar ([U]pdate):** Entenda como a variável `$id_editar` reaproveita o mesmo formulário HTML para atualizar os dados.

---

## 🔥 Desafio Prático

**Objetivo:** Adicionar um novo campo chamado **`telefone`** ao sistema.

**Passos para conclusão:**
1. Execute o comando `ALTER TABLE usuarios ADD COLUMN telefone VARCHAR(20);` no phpMyAdmin.
2. Adicione o campo de texto para **Telefone** no formulário HTML dentro do `index.php`.
3. Altere o código PHP que recebe o `POST` para capturar e salvar o telefone nos comandos `INSERT` e `UPDATE`.
4. Adicione uma nova coluna `<th>` e `<td>` na tabela HTML para exibir o telefone cadastrado.
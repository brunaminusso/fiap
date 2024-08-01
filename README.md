# 🚀 Projeto FIAP

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-000000?style=for-the-badge&logo=composer&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-000000?style=for-the-badge&logo=phpunit&logoColor=white)

Este é um **projeto PHP** para a gestão de turmas, alunos e matrículas. O sistema inclui funcionalidades para criação, edição e exclusão de turmas e alunos, gerenciamento de matrículas, além de login e cadastro de usuário. O projeto foi desenvolvido utilizando PHP com arquitetura **MVC** e **MySQL** como banco de dados. Inclui também **testes unitários** usando PHPUnit para garantir a qualidade do código.

## 📑 Índice

- [Estrutura do Projeto](#estrutura-do-projeto)
- [Instalação](#instalação)
- [Configuração do Banco de Dados](#configuração-do-banco-de-dados)
- [Executando o Servidor](#executando-o-servidor)
- [Rodando os Testes](#rodando-os-testes)

## 📁 Estrutura do Projeto

Aqui está uma visão geral da estrutura de diretórios e arquivos principais do projeto:

```bash
fiap/
├── app/                    # Código fonte principal do projeto
│   ├── Controllers/        # Controladores responsáveis pela manipulação das requisições
│   ├── Models/             # Models que interagem com o banco de dados
│   └── Views/              # Views para renderização das páginas HTML
├── config/                 # Arquivos de configuração do projeto
│   ├── database.php        # Configurações do banco de dados
│   └── session.php         # Configurações para gerenciamento de sessões
├── public/                 # Diretório acessível publicamente; Contém o ponto de entrada da aplicação
│   └── index.php           # Arquivo principal que inicia a aplicação│
├── src/                    
├── tests/                  # Testes automatizados do projeto
│   └── ...                 # Arquivos de teste PHPUnit
├── vendor/                 # Diretório gerado pelo Composer; Contém as dependências do projeto
├── composer.json           # Arquivo de configuração do Composer
├── composer.lock           # Arquivo que bloqueia as versões das dependências do Composer
├── dump.sql                # Script SQL para criação do banco de dados e inserção de dados iniciais
├── phpunit.xml             # Arquivo de configuração do PHPUnit
├── README.md               # Este arquivo
└── .gitignore              # Arquivo para listar os arquivos e diretórios a serem ignorados pelo Git
```

## 🔧 Instalação

1. **Clonar o Repositório**

   Primeiro, clone o repositório para sua máquina local com o comando:

   ```bash
   git clone https://github.com/brunaminusso/fiap.git
   cd fiap

1. **Instalar as Dependências**
   ```bash
   composer install

## 🗃️ Configuração do Banco de Dados

1. **Criar o Banco de Dados**

   Acesse o MySQL e crie o banco de dados necessário para o projeto:

   ```bash
   mysql -u root -p

Depois, no prompt do MySQL, execute:

   ```bash
   CREATE DATABASE fiap;
   ```   

2. **Configurações**

    Configure o arquivo database.php, localizado em `config/database.php`

   ```bash
   $host = 'localhost';
   $dbname = 'fiap';
   $username = 'usuario';  // Substitua com seu nome de usuário MySQL
   $password = 'root';     // Substitua com sua senha MySQL
   ``` 

## 🚀 Executando o Servidor

Para iniciar o servidor e começar a usar o sistema, siga os passos abaixo:

1. **Iniciar o Servidor Embutido do PHP**

    Se você estiver usando o servidor embutido do PHP, você pode iniciar o servidor com o comando a seguir. Certifique-se de estar no diretório `public/index.php`:

   ```bash
   php -S localhost:8000 -t public
   ``` 

2. **Acessar a Aplicação**

Abra o navegador e acesse a aplicação em:

```bash
http://localhost:8000
``` 

3. **Redirecionamento para a Página de Login**

    Ao acessar a aplicação pela primeira vez, você será automaticamente redirecionado para a página de login. Para facilitar o início, você pode usar um usuário padrão já existente no banco de dados. Use as seguintes credenciais para fazer login:

    `Email: root@root.com`

    `Senha: root123`

Se preferir, crie um novo usuário.

## 🧪 Rodando os Testes

Para garantir que o código está funcionando corretamente e para verificar a integridade do projeto, execute os testes automatizados. Siga os passos abaixo para rodar os testes com PHPUnit:

1. **Certifique-se de que as Dependências Estão Instaladas**

   Antes de rodar os testes, garanta que todas as dependências do projeto estão instaladas. Se ainda não o fez, execute:

   ```bash
   composer install
   ```

2. **Executar os Testes**

    Para rodar todos os testes do projeto, use o seguinte comando:

   ```bash
   vendor/bin/phpunit
   ```


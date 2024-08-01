Projeto de Gerenciamento de Alunos
Este projeto é um sistema de gerenciamento de alunos desenvolvido em PHP. Ele utiliza o padrão MVC (Model-View-Controller) e inclui funcionalidades para cadastro, edição, exclusão e listagem de alunos. Além disso, o projeto inclui testes automatizados usando PHPUnit para garantir a qualidade do código.

Requisitos
PHP >= 7.4
Composer
MySQL ou MariaDB
PHPUnit
Estrutura do Projeto
app/Models: Contém os modelos do sistema, como Aluno, Matricula e Turma.
app/Controllers: Contém os controladores, como AlunoController.
app/Views: Contém as views para a interface do usuário.
src/tests/Unit: Contém os testes unitários para os modelos e controladores.
index.php: Ponto de entrada para o roteamento das requisições.
Instalação
Clone o Repositório

sh
Copiar código
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
Instale as Dependências

Certifique-se de que o Composer está instalado. Se não estiver, você pode instalá-lo aqui.

sh
Copiar código
composer install
Configure o Banco de Dados

Crie um banco de dados MySQL e configure as credenciais no arquivo de configuração (adapte o caminho conforme necessário).

php
Copiar código
// Exemplo de configuração no arquivo `app/Config.php`:
define('DB_HOST', 'localhost');
define('DB_NAME', 'nome_do_banco');
define('DB_USER', 'usuario');
define('DB_PASS', 'senha');
Execute o script SQL para criar as tabelas e inserir os dados iniciais:

sh
Copiar código
mysql -u usuario -p nome_do_banco < path/to/database/schema.sql
Uso
Inicie o Servidor Web

Você pode usar o servidor embutido do PHP para iniciar o servidor web:

sh
Copiar código
php -S localhost:8000 -t public
Acesse o sistema através de http://localhost:8000.

Executar Testes

Para garantir que todos os testes passem, execute o PHPUnit:

sh
Copiar código
./vendor/bin/phpunit
Certifique-se de que o PHPUnit está instalado e configurado corretamente.

Testes
Os testes unitários estão localizados em src/tests/Unit. Eles verificam o comportamento dos modelos e controladores. Para executar os testes, use o comando PHPUnit:

sh
Copiar código
./vendor/bin/phpunit --config phpunit.xml
Contribuição
Contribuições são bem-vindas! Se você encontrar problemas ou tiver sugestões de melhorias, por favor, abra uma issue ou envie um pull request.

Licença
Este projeto é licenciado sob a MIT License.

Contato
Para mais informações, entre em contato com seu-email@dominio.com.
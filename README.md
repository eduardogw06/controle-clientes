#  Controle de Clientes

Criar um portal web, no qual será possível cadastrar os clientes.
Fazer uma listagem dos clientes cadastrados e fornecer a opção de editar e excluir.

# Requisitos
Será necessário desenvolver recursos que cadastre as seguintes informações:
- Nome
- E-mail
- Data de Nascimento
- Endereço
- CEP
- Cidade
- Estado

# Especificações
- Linguagem Programação: PHP 7.2.25
- Banco de Dados: MySQL 14.14
- Framework: Laravel Framework 7.30.4
- Vue.js 6.14.12

## Passos para a instalação 
		
- Execute o comando a seguir em um diretório a sua escolha
```
    git clone git@gitlab.com:eduardogw06/controle-clientes.git
```

- No diretório raiz do projeto execute o comando abaixo para baixar as dependências do projeto
```
    php composer.phar install
```	
- Crie a Base de dados no MySQL
```
    create database controle_clientes
```	

6. Configure o banco de dados na aplicação. Para isso, um arquivo com o nome `.env` e cole o conteúdo do arquivo `.env.example` que se encontra na raiz do projeto. Neste novo arquivo você encontrará as seguintes linhas:
```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
```
- Em DB_CONNECTION informe `mysql`
- Em DB_HOST informe o IP do servidor de banco de dados, ou utilize `127.0.0.1` caso o banco esteja no mesmo servidor da aplicação.
- Em DB_PORT informe a porta de acesso ao banco de dados do servidor.
- Em DB_DATABASE informe o nome da base de dados criada anteriormente, no caso `controle_clientes`.
- Em DB_USERNAME informe o nome do usuário do banco de dados.
- Em DB_PASSWORD informe a senha de acesso do usuário do banco de dados.

- Abra o terminal no diretório raiz da aplicação e execute o seguinte comando:
```
    php artisan migrate
```
	
- Em seguida, no mesmo terminal, execute o seguinte comando:
```
    php artisan db:seed
```

- Crie um web host para executar seu projeto. Abaixo, seguem as instruções para criar o web host a partir do Xampp no Windows.

  - No arquivo `C:\xampp\apache\conf\extra\httpd-vhosts.conf` cole o trecho abaixo:
  ```
    <VirtualHost *:80>
        ServerName controle-clientes.local
        DocumentRoot "C:\xampp\htdocs\controle-clientes\public"
        
        <Directory "C:\xampp\htdocs\controle-clientes\public">
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            allow from all
        </Directory>
    </VirtualHost>
  ```
  - Se necessário, substitua os itens `DocumentRoot` e `Directory` com o diretório de instalação do projeto
  - No arquivo `C:\Windows\System32\drivers\etc\hosts` adicione a linha abaixo
   ```
    127.0.0.1 controle-clientes.local
   ```
   - Reinicie o servidor Apache
   - Após a conclusão dos passos, seu sistema estará disponível em `http://controle-clientes.local/`

# Acessos padrão
Por padrão, o usuário Admin é criado. Seus acessos são:
- E-mai: admin@gmail.com
- Senha: admin1234
	

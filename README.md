Join Tecnologia

Teste de PHP

Instalação do projeto.

- Clonar o repositório.
- Configurar o .env, pode ser o mesmo env.example
- Criar o banco de dados conforme o nome definido no .env
- Rodar os seguintes comandos `composer install && php artisan config:cache`
- Rodas os comando para compilaçãos dos assets `npm i && npm rum prod`
- Rodas o comandos de migração `php artisan migrate`
- Rodas o comandos para gerar dados de teste `php artisan db:seed`

Utilize o servidor web da sua preferencia ou o do próprio laravel `php artisan serve` pra testar a aplicação.
Utilize o usuário criado pelo seeder email teste@teste.com senha `password` ou registre um novo na tela de login.

Estou utilizando 3 bibliotecas exiliares no front.
   - `date-fns` para manipular e formatar tempo.
   - `v-money` para facilitar a manipulação de campos monetários.
   - `vue-sweetalert2` para exibição de mensagens de alertas.

Também escrevi teste de feature, para rodar você deve criar um .env.testing e especificar o banco de teste. Em seguida é só radar o comando `composer test`


Qualquer duvida estou a disposição. Obrigado!!

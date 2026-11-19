# Contábil Fácil

Sistema web para organizar clientes, obrigações fiscais e prazos de um escritório contábil.

## Requisitos
- PHP 8.0 ou superior com extensões PDO e PDO MySQL habilitadas
- MySQL ou MariaDB
- XAMPP (Apache/PHP/MySQL) ou servidor PHP local

## Instalação no XAMPP
1. Copie a pasta `contabil-facil-final` para `C:\xampp\htdocs\`.
2. Abra o phpMyAdmin em `http://localhost/phpmyadmin`.
3. Importe `database/contabil_facil.sql`.
4. Confira usuário, senha, porta e banco em `config/config.php` (padrão: root sem senha, porta 3306).
5. Inicie o MySQL no XAMPP.
6. Acesse `http://localhost/contabil-facil-final/`.

Se usar o servidor embutido do PHP, abra o terminal na pasta do projeto e execute:
`C:\xampp\php\php.exe -S localhost:8000 router.php`

Depois acesse `http://localhost:8000`. O arquivo `router.php` encaminha as rotas e entrega o CSS.

## Usuário de teste
- E-mail: `admin@contabilfacil.com`
- Senha: `password`

## Funcionalidades
- Login com sessão e encerramento seguro da sessão.
- CRUD completo de clientes.
- CRUD completo de obrigações fiscais relacionadas aos clientes.
- Busca, filtros e paginação nas listagens.
- Painel com indicadores e alertas de prazos próximos/vencidos.
- Tela para registrar avaliação de usuário final.
- Proteção CSRF nos formulários, consultas PDO parametrizadas, escape de saída contra XSS e validação no servidor.

## Estrutura MVC
- `app/Models`: acesso aos dados.
- `app/Views`: telas.
- `app/Controllers`: fluxo e validações.
- `app/Core`: conexão PDO e funções auxiliares.
- `index.php`: ponto único de entrada e roteamento.
- `database/contabil_facil.sql`: criação do banco e dados de demonstração.

## Git
Dentro da pasta do projeto:
```bash
git init
git add .
git commit -m "Cria estrutura inicial MVC do Contábil Fácil"
git add .
git commit -m "Implementa cadastro e gestão de clientes"
git add .
git commit -m "Implementa obrigações fiscais e alertas de vencimento"
git add .
git commit -m "Adiciona autenticação, segurança e avaliação do usuário"
```

## Teste com usuário real
O teste com usuário real deve ser realizado presencialmente ou remotamente com alguém que use serviços contábeis ou trabalhe em escritório. Não registre resultados fictícios. Peça à pessoa para cadastrar/consultar uma obrigação e anote:
- O que achou fácil?
- O que gerou dúvida?
- Qual melhoria considera mais importante?
Implemente pelo menos duas melhorias reais apontadas e registre o antes e depois no relatório.

## Observações de segurança para apresentação
- As senhas são verificadas com `password_verify` e armazenadas com hash.
- Os comandos SQL usam PDO e parâmetros.
- Os formulários POST verificam token CSRF.
- Os dados exibidos são escapados com `htmlspecialchars`.
- As páginas internas exigem sessão autenticada.
- O projeto é para demonstração acadêmica local; antes de publicar na internet, configure HTTPS, credenciais fortes, política de backup e tratamento de erros sem exposição de detalhes.

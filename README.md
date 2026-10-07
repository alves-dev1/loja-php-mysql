# Enzo Store — PHP e MySQL

Sistema de gerenciamento de loja desenvolvido para praticar PHP e banco de dados durante meus estudos em Desenvolvimento de Sistemas. Permite cadastrar clientes e produtos, consultar o estoque e registrar ou cancelar vendas.

## Demonstração

[Acessar a demonstração online](https://enzo-store-demo.ifree.page/login01.php)

- E-mail: `demo@example.com`
- Senha: `LojaDemo2026!`

Use apenas dados fictícios. A demonstração usa um banco compartilhado: alterações realizadas por visitantes podem aparecer para outras pessoas. O ambiente gratuito está sujeito à disponibilidade da hospedagem.

## Funcionalidades

- Login com verificação de senha e controle de acesso por sessão.
- Cadastro, consulta e edição de clientes e produtos.
- Busca por nome e filtros de estoque baixo e produtos esgotados.
- Registro de venda com verificação da quantidade disponível e baixa no estoque.
- Histórico com filtros de vendas ativas e canceladas.
- Cancelamento com devolução das unidades ao estoque, mantendo o histórico.
- Resumo de vendas ativas, unidades vendidas e total vendido.
- Interface em HTML e CSS, com adaptação para telas menores.

Cada venda contém um produto e sua quantidade. O preço unitário fica registrado na venda, mesmo que o preço do produto seja alterado depois. Os totais consideram apenas vendas ativas dentro do filtro selecionado; no filtro de canceladas, ficam zerados.

## Tecnologias e conceitos praticados

PHP procedural, MySQL/MariaDB, MySQLi, HTML, CSS e JavaScript na confirmação do cancelamento. Desenvolvimento local com XAMPP e VS Code.

O projeto utiliza consultas preparadas para os parâmetros das consultas, chaves estrangeiras, sessões, `password_hash`/`password_verify`, transações e `SELECT ... FOR UPDATE` nas operações de venda e cancelamento. O formulário de cancelamento também possui validação de token CSRF.

## Como executar localmente

1. Inicie Apache e MySQL no XAMPP, com PHP 8.x e MySQLi/mysqlnd disponíveis.
2. Baixe este repositório e coloque seus arquivos em `C:\xampp\htdocs\loja-php-mysql`.
3. Abra o phpMyAdmin e crie um banco vazio chamado `loja_demo`, com codificação utf8mb4.
4. Selecione esse banco e importe `banco.sql` uma única vez. O arquivo cria quatro tabelas e dados fictícios, incluindo o usuário de demonstração.
5. Copie `conexao.exemplo.php` para `conexao.php` na mesma pasta. Ajuste host, usuário, senha e nome do banco conforme seu ambiente. Os valores do exemplo correspondem ao XAMPP padrão, sem senha do MySQL.
6. Acesse `http://localhost/loja-php-mysql/login01.php` e use as credenciais de demonstração acima.

O arquivo `conexao.php` fica fora do versionamento. Não publique credenciais da hospedagem. Para hospedar, utilize um servidor com PHP e MySQL; o GitHub Pages não executa o backend PHP. Não envie o SQL para a pasta pública do servidor: importe-o pelo gerenciador do banco.

## Organização

| Arquivos | Finalidade |
| --- | --- |
| `index.php` | Menu inicial |
| `login01.php`, `login02.php`, `ses_start.php`, `sair.php` | Login e sessão |
| `cryp2graph2.php` | Funções para hash e verificação de senha |
| `clientes.php`, `estoque.php` | Consultas e filtros |
| `cadCliente*`, `cadProduto*`, `editarCliente*`, `editarProduto*` | Formulários e processamento |
| `venda01.php`, `venda02.php` | Registro de venda |
| `vendas.php`, `cancelarVenda.php` | Histórico e cancelamento |
| `estilo.css` | Estilos compartilhados |
| `banco.sql` | Estrutura e dados fictícios para instalação |
| `conexao.exemplo.php` | Modelo da conexão local |

## Roteiro de teste manual

1. Faça login e consulte produtos e clientes.
2. Busque um produto pelo nome e teste os filtros de quantidade.
3. Registre uma venda de duas unidades e confira a redução do estoque.
4. Tente vender uma quantidade maior que o estoque: a operação deve ser recusada.
5. Cancele a venda e confira a devolução das unidades e a atualização dos totais.
6. Atualize o histórico e confirme que a quantidade não foi devolvida novamente.
7. Saia da conta e tente abrir uma página protegida: ela deve redirecionar ao login.

## Limites e próximos passos

Projeto de estudo, sem pagamentos ou checkout de comércio eletrônico. Todos os usuários autenticados têm as mesmas permissões. Ainda faltam proteção CSRF nos demais formulários, controle de tentativas de login, perfis de acesso e testes automatizados. A demonstração não possui isolamento de dados por visitante nem restauração automática. Não foi projetado para administrar dados reais de clientes em produção.

## Autor

Enzo Alves de Moura — estudante de Desenvolvimento de Sistemas na ETEC Ary de Camargo Pedroso.

[GitHub](https://github.com/alves-dev1) · [LinkedIn](https://www.linkedin.com/in/enzo-alves-de-moura-578600276/)

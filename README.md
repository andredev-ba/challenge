# Desafio INNYX

Este projeto foi construído utilizando Laravel 10 no backend, Vue 3 com Composition API e TypeScript no frontend. Para a parte visual, foi escolhido o Quasar, framework Vue que possui um conjunto abrangente de utilitários e componentes UI, similar ao Bootstrap Vue, Vuetify, Element.Io, etc.

## Arquitetura utilizada

De modo a demonstrar o conhecimento em arquitetura de software, optei por aplicar os princípios da Clean Architecture, Patterns do DDD (Domain Driven Design) e SOLID, isolando o CORE da aplicação que inclui as camadas de UseCases e Domain dentro da pasta <b>src/Core</b>, e utilizando a estrutura do framework Laravel como sendo a camada de infraestrutura. Essa abordagem tem como objetivo promover a independência de frameworks e detalhes de implementação, facilitando a substituição ou atualização de componentes sem afetar o restante do sistema.

## Sistema de autenticação e autorização

Para a parte de autenticação e autorização, foi utilizado o Keycloak, uma plataforma de código aberto para gerenciamento de identidade e acesso. Ele fornece recursos como autenticação, autorização, e gerenciamento de sessão, bem como autenticação por redes sociais, redefinição de senha, autenticação em 2 fatores, etc. Nesse projeto, Keycloak é utilizado como sistema de autenticação para garantir a segurança da aplicação. 

Para realizar a integração do Laravel e do Vue com o keycloak com mais agilidade, foram utilizadas as bibliotecas externas <b>robsontenorio/laravel-keycloak-guard</b> e <b>keycloak.js</b> respectivamente.


## Test Driven Design

A fim de demonstrar o conhecimento com testes automatizados, na implementação do Backend foi utilizado o TDD para criação dos testes automatizados de unidade, de integração e de ponto a ponto, de algumas classes do projeto com o PEST, framework que roda em cima do PHP UNIT, mas que deixa a escrita do código mais atrativa, similar a de outras ferramentas de teste como o JEST. Segue alguns benefícios de utilizar TDD nos projetos de software:

- **Confiança no Código:**
  - Os testes automatizados garantem que as funcionalidades continuem funcionando conforme o esperado, mesmo após alterações no código.

- **Detecção Precoce de Bugs:**
  - Problemas são identificados no início do desenvolvimento, tornando as correções mais simples e menos dispendiosas.

- **Melhor Design de Software:**
  - A ênfase em criar testes antes da implementação leva a um código mais modular, desacoplado e fácil de manter.

- **Documentação Executável:**
  - Os testes servem como documentação executável, fornecendo uma compreensão clara do comportamento esperado do código.

- **Retroalimentação Rápida:**
  - A execução frequente dos testes fornece feedback instantâneo, permitindo uma resposta rápida a problemas ou mudanças nos requisitos.


## Instalação

Para instalar o projeto, certifique-se de ter o Docker e o Docker Compose instalados. Em seguida, execute o seguinte comando:

```bash
docker-compose up -d
docker-compose exec api php artisan migrate
docker-compose exec api php artisan db:seed
```

Para rodar os testes automatizados do backend:

```bash
docker-compose exec api php artisan test
```

## Acessando a aplicacão
Após subir os containers docker, o frontend da aplicação pode ser acessado no endereço: <b>http://localhost:9000.</b>

No keycloak que são gerenciados os usuários e papéis da aplicação. As rotas estão protegidas tanto no backend, quanto no front. Para demonstração básica do controle de permissões (ACL), foram criados 2 usuários: <b>innyx</b> e <b>user</b> com papéis distintos.

Usuário: <b>innyx</b> (Acessa o gerenciamento de categorias e produtos)

Senha: <b>123456</b>


Usuário: <b>user</b> (Acessa somente o gerenciamento de produtos.)

Senha: <b>123456</b>

## Acessando o keycloak
 O ideal é ter esse gerenciamento de usuários e permissões de dentro do frontend consumindo a API do keycloak, mas por conta do tempo e do objetivo desse desafio, optei por deixar esse gerenciamento no próprio keyclocak, que após subir os containers, ficará disponível em <b>http://localhost:8001.</b>. 

Usuário: <b>master</b>

Senha: <b>desafio</b>

## API Laravel
O backend, após subir os containers estará rodando no endereço <b>http://localhost:8000.</b>


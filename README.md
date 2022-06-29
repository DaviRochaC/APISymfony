<h1 align="center">API REST SYMFONY </h1>
<p align="center">
<img src="http://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=GREEN&style=for-the-badge" ALT="" />
</p>


## Objetivo

Criar uma API REST em conjunto com o framework Symfony que faça um CRUD de médicos e suas respectivas especialidades.

## Dependências
Instalações necessárias:
```
PHP 8
COMPOSER
MYSQL SERVER ou SQLITE ou POSTGRESQL (BANCO FICA A SEU CRITÉRIO)
```
Extensões PHP habilitadas:
```
(pdo_mysql
 pdo_sqlite
 pdo_pgsql)
 
 Será necessario ter instalado o driver e habilitar uma das extensões acima que corresponde a sua escolha ao Banco de Dados.
```
***
## Passo a passo de como utilizar:

#### OBS: As instruções abaixo tem como exemplo de banco de dados o MYSQL. Caso queira utilizar outro tipo de DB depois do passo  n° 1  pule para o n°5.

1) Renomeie o arquivo ".env.example" para ".env".

2) Posteriormente preencha no .env subtituindo corretamente as informações do banco que voce irá utilizar.

db_user = Seu usuário no Banco de dados.

db_password = Senha do seu usuário no Banco de dados.

host: Host do servidor do MYSQL

port = Porta do servidor do MYSQL

db_name = O nome que voce gostaria que o Banco de dados recebesse.

```
DATABASE_URL="mysql://db_user:db_password@host:port/db_name?serverVersion=5.7&charset=utf8mb4"
```

3) Navegue até o terminal da pasta que voce armazenará o projeto e rode o comando:

```
composer install
```
Isso fará com que o composer gerencie as bibliotecas que serão utilizadas no projeto.

4) Logo após o composer instalar as dependencias do projeto, continue no terminal e execute dois comando
 ```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```
Esses comandos criarão o banco de dados a partir da configuração definida por voce na variavel DATABASE_URL no .env . Depois criará as duas tabelas necessárias para o projeto: especialidade e medico.


5) A partir daqui todos os passos são destinados apenas para quem estiver utilizando um Banco de dados diferente do MYSQL.
Para utilizar um banco de dados diferente do mysql primeiro adicione um "#" no inicio da linha abaixo no .env, de modo que fique assim:

```
#DATABASE_URL="mysql://db_user:db_password@host:port/db_name?serverVersion=5.7&charset=utf8mb4
```

Depois tire o "#" de uma das duas linhas abaixo, de acordo com o tipo de banco que voce utilizará.
```
#DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
#DATABASE_URL="postgresql://symfony:ChangeMe@127.0.0.1:5432/app?serverVersion=13&charset=utf8"
```
Se for utilizar o sqlite nenhuma configuração é necessaria e o seu banco será criado em um arquivo na pasta var. Já no PostgreSql  alguma configurações sao necessárias.

6) Agora navegue até a pasta `migrations` no diretório raiz do projeto e exclua o unico arquivo php que a mesma possui.
7) Logo após, vá para o terminal da pasta raiz do projeto e execute todos comandos abaixo, porém um de cada vez
 ```
composer install
bin/console doctrine:database:create
bin/console doctrine:database:diff
bin/console doctrine:migrations:migrate
```

***

## Métodos 

As requisições para a API devem seguir os padrões:

| Verbo HTTP | Descrição                                    |
|:-----------|----------------------------------------------|
| `GET`      | Retorna informações de um ou mais registros. |
| `POST`     | Utilizado para criar unm novo registro.      |
| `PUT`      | Atualiza dados de um registro .              |
| `DELETE`   | Remove um registro do sistema.               |

### Respostas

| Código | Descrição                                                                  |
|:-------|----------------------------------------------------------------------------|
| `200`  | Requisição executada com sucesso.                                          |                                                     |
| `204`  | Sem conteúdo.                                                              |
| `404`  | Registro pesquisado não encontrado. (Referente a interação com o recurso). |
| `422`  | Campos não válidos para requisição.                                        |
| `500`  | Erro interno no servidor.                                                  |

## Grupo de Recursos

***
 <h3 align="center"> Especialidades </h3>

### Cadatro de Especialidades 

Para o cadastro é necessário:

- Descricão da especialidade

+ API endpoint
    + `especialidades`
+ Verbo Http : `POST`
+ Request (/application/json)
    + Body
        ```json
        {
          "descricao" : "Descrição da especialidade"
        }
        ```

### Listagem de Especilidades

##### Listagem de todas as Especialidades
+ API endpoint
    + `especialidades`
+ Verbo Http : `GET`
+ Response 200 (application/json)
    ```json
    [
      {
        "id": "Id da despesa",
        "descricao": "Descrição da especialidade"
      },
      {
        "id": "Id da despesa.",
        "descricao": "Descrição da especialidade"
      }
    ]
    ```


##### Listagem de uma especialidade específica
+ API endpoint
    + `especialidades/{id}`
+ Verbo Http : `GET`
+ Response 200 (application/json) <br/>
    ```json
      {
        "id": "Id da despesa",
        "descricao": "Descrição da especialidade"
      }
    ```

### Atualização de Especialidade

Para a atualização é necessário:

- Descricão da especialidade

+ API endpoint
  + `especialidades\{id}`
+ Verbo Http : `PUT`
+ Request (/application/json)
  + Body
      ```json
      {
        "descricao" : "Descrição atualizada da especialidade"
      }
      ```

### Remoção de Especilidade
+ API endpoint
  + `especialidades/{id}`
+ Verbo Http : `GET`
+ Response 204

***

<h3 align="center">Médicos</h3>


### Cadatro de Médicos

Para o cadastro é necessário:

- crm do Médico
- nome do Médico
- id da especialidade do Médico

+ API endpoint
  + `medicos`
+ Verbo Http : `POST`
+ Request (/application/json)
  + Body
      ```json
      {
        "crm" : "CRM/UF 000000",
        "nome" : "Nome do Médico",
        "especialidade": "1"
      }
      ```

### Listagem de Médicos

##### Listagem de todos os Médicos
+ API endpoint
  + `medicos`
+ Verbo Http : `GET`
+ Response 200 (application/json)
    ```json
    [
      {
        "id": "1",
        "crm" : "CRM/UF 000000",
        "nome" : "Nome do Médico",
         "especialidade": {
            "id": 1,
            "descricao": "descricao da especialidade "
        }
      }, 
      {
        "id": "1",
        "crm" : "CRM/UF 000000",
        "nome" : "Nome do Médico",
         "especialidade": {
            "id": 2,
            "descricao": "descricao da especialidade "
        }
      }
    ]
    ```


##### Listagem de informações de um médico específico (por ID)
+ API endpoint
  + `medicos/{id}`
+ Verbo Http : `GET`
+ Response 200 (application/json) <br/>
    ```json
      {
        "id": "1",
        "crm" : "CRM/UF 000000",
        "nome" : "Nome do Médico",
         "especialidade": {
            "id": 1,
            "descricao": "descricao da especialidade "
        }
      }
    ```

### Atualização de informações de um Médico

Para a atualização é necessário:

- crm do Médico
- nome do Médico
- id da especialidade do Médico

+ API endpoint
  + `medicos\{id}`
+ Verbo Http : `PUT`
+ Request (/application/json)
  + Body
      ```json
     {
        "crm" : "CRM/UF 000000",
        "nome" : "Nome do Médico",
        "especialidade": "5"
      }
      ```

### Remoção de um Médico
+ API endpoint
  + `medicos/{id}`
+ Verbo Http : `GET`
+ Response 204
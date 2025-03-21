# Aplicação Web com PHP e MariaDB na AWS

## Contexto da Atividade

O objetivo desta atividade foi desenvolver uma aplicação web integrada a um banco de dados relacional na AWS. A aplicação deveria permitir a criação e listagem de registros em uma tabela personalizada, com pelo menos quatro campos e três tipos de dados distintos. Além disso, foi necessário estruturar o ambiente na nuvem, incluindo a configuração de uma instância EC2, a criação de um banco de dados RDS e a implementação de um servidor web. Por fim, o projeto inclui a documentação em um repositório GitHub e a gravação de um vídeo demonstrando o funcionamento do ambiente e da aplicação.

---

## Preparação de Ambiente na AWS
Para realizar esta atividade, utilizei o ambiente de criação Learner Lab, disponibilizado pelos professores através do curso AWS Academy. Esse ambiente oferece uma infraestrutura temporária na nuvem da AWS, permitindo a criação e gerenciamento de recursos como EC2 e RDS de forma prática e segura durante o aprendizado.


### Criação de uma Instância EC2 na AWS
Foi criada uma instância EC2 com Amazon Linux 2, configurada em uma VPC pública com grupo de segurança permitindo acesso via SSH (porta 22) e HTTP (porta 80). A instância serviu como ambiente para hospedar a aplicação PHP e conectar ao banco RDS.


### Criação de um Banco RDS na AWS
Foi criado um banco de dados RDS utilizando o mecanismo MariaDB, configurado em uma sub-rede privada. O grupo de segurança foi ajustado para permitir conexões da instância EC2 na porta padrão 3306. O banco foi utilizado para armazenar e gerenciar os dados da aplicação

### Instalação de um Web Server na Instância EC2
Na instância EC2, foi instalado e configurado o servidor Apache junto com o PHP e as extensões necessárias para integração com o MariaDB. Após a instalação, o Apache foi iniciado e configurado para servir a aplicação PHP, permitindo a comunicação com o banco de dados RDS.


---

## Desenvolvimento da Aplicação

A aplicação consiste em duas páginas PHP integradas a um banco de dados MariaDB hospedado no RDS da AWS:

1. **Tabela EMPLOYEES**
   - Campos: ID (int), NAME (varchar), ADDRESS (varchar)
   - Funcionalidades: Cadastro e listagem de funcionários

2. **Tabela PRODUCTS**
   - Campos: ID (int), NAME (varchar), PRICE (decimal), CREATED_AT (timestamp)
   - Funcionalidades: Cadastro e listagem de produtos

Foi desenvolvida uma página web com formulários HTML para inserção de dados em ambas as tabelas, além da exibição em tabelas dinâmicas de todos os registros já cadastrados.

O layout foi estruturado com HTML e estilizado com CSS para uma melhor apresentação visual, e as queries SQL foram implementadas diretamente em PHP para manipulação dos dados (inserção e leitura).

---

## Estrutura do Projeto

```
/app
 ├── dbinfo.inc    # Credenciais do banco de dados
 ├── SamplePage.php  # Formulários e listagem de dados
/ README.md         # Documentação do projeto
```


---

## URL do Vídeo

## Tutorial Seguido

O desenvolvimento deste projeto foi baseado no tutorial oficial da AWS, "Creating a Web Application with Amazon RDS", disponível em [este link](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/TUT_WebAppWithRDS.html). O tutorial forneceu uma orientação clara sobre como integrar uma aplicação web a um banco de dados MySQL hospedado no Amazon RDS, além de detalhar os passos necessários para configurar as instâncias EC2 e as permissões adequadas. Segui as instruções para criar as instâncias, configurar a aplicação PHP e conectá-la ao banco de dados, garantindo um fluxo de trabalho eficiente e bem estruturado.

---

## Conclusão

Durante esta atividade, aprendi a realizar o deploy de uma aplicação web na AWS utilizando serviços como EC2 e RDS, além de integrar uma aplicação PHP a um banco de dados MariaDB. Aprimorei minhas habilidades com a manipulação de dados via PHP e SQL, além de ter aprofundado meus conhecimentos na configuração de ambientes em nuvem, práticas de segurança e boas práticas de desenvolvimento. Também desenvolvi um olhar mais atento para o gerenciamento de infraestrutura e automação de processos de deploy.

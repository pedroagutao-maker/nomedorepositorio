# PwrGenFORCE⚡ — Sistema de Monitoramento e Gestão de Treinos

## 1. Descrição e Objetivo

O **PwrGenFORCE⚡** é uma aplicação web voltada ao acompanhamento do desempenho físico em treinos de força e ao monitoramento da evolução do peso corporal.

O sistema permite registrar cargas, repetições, exercícios e datas de treino, acompanhar o histórico de registros, visualizar a evolução das cargas, consultar métricas de desempenho, registrar peso corporal e consultar fichas de treino estruturadas.

## 2. Problema Resolvido

Praticantes de musculação podem ter dificuldade para manter um histórico organizado de cargas, repetições e evolução corporal.

O PwrGenFORCE busca centralizar essas informações em uma aplicação web com persistência em banco de dados relacional, permitindo consultar os registros e visualizar métricas de treinamento.

## 3. Público-Alvo

- Praticantes de musculação e treinamento de força.
- Personal trainers e instrutores.
- Usuários interessados em acompanhar sua evolução de treinamento.

## 4. Funcionalidades Atuais

1. **Registro de Treinos:** cadastro de exercício, carga, repetições e data.
2. **Registro de Peso Corporal:** cadastro de peso e data da pesagem.
3. **Dashboard de Métricas:** apresentação de estatísticas relacionadas aos treinos.
4. **Gráfico de Evolução de Carga:** visualização da evolução das cargas registradas.
5. **Histórico de Treinos:** listagem dos registros cadastrados.
6. **Fichas de Treino:** consulta das fichas de treino A, B e C.
7. **Calculadora de 1RM:** estimativa da repetição máxima utilizando a fórmula de Epley.
8. **Cronômetro:** temporizador de descanso integrado à interface.
9. **Exportação de Histórico:** possibilidade de exportar registros de treino em CSV.

---

## 5. Requisitos de Usuário (RU)

- **RU01:** O usuário deseja registrar as cargas e repetições executadas em seus exercícios com a respectiva data.
- **RU02:** O usuário deseja registrar e acompanhar as variações do seu peso corporal.
- **RU03:** O usuário deseja consultar o histórico completo dos treinos cadastrados.
- **RU04:** O usuário deseja visualizar graficamente a evolução temporal de suas cargas.
- **RU05:** O usuário deseja visualizar estatísticas consolidadas dos seus treinos.
- **RU06:** O usuário deseja consultar o conteúdo das fichas de treino pré-configuradas.

---

## 6. Requisitos de Sistema (RS)

- **RS01:** O sistema deve receber requisições `POST` contendo exercício, carga, repetições e data e persistir os dados na tabela `registros_treino`.
- **RS02:** O sistema deve receber requisições `POST` contendo peso corporal e data e armazenar os dados na tabela `peso_corporal`.
- **RS03:** O sistema deve consultar os registros de treino ordenando-os pela data.
- **RS04:** O sistema deve disponibilizar os dados necessários para a geração do gráfico de evolução de cargas.
- **RS05:** O sistema deve calcular métricas relacionadas ao volume de treino e à carga máxima registrada.
- **RS06:** O sistema deve consultar e listar os registros armazenados na tabela `fichas_treino`.

---

## 7. Regras de Negócio

- **RN01 — Padrão PRG:** após o processamento de uma requisição `POST`, o sistema realiza redirecionamento para evitar duplicidade causada pela atualização da página.
- **RN02 — Validação Positiva:** valores de carga, repetições ou peso menores ou iguais a zero não devem ser aceitos.
- **RN03 — Vinculação de Usuário:** na versão atual, os registros utilizam o identificador `usuario_id = 1`.
- **RN04 — Data Padrão:** quando nenhuma data é informada, o sistema utiliza a data atual do servidor.

---

## 8. Visão Geral da Arquitetura

O PwrGenFORCE utiliza uma arquitetura baseada no padrão **Model-View-Controller (MVC)**.

```text
[ Usuário ]
     |
     v
[ View / Frontend ]
     |
     | HTTP POST / GET
     v
[ Controller ]
     |
     v
[ Model ]
     |
     v
[ Banco de Dados MySQL ]O usuário interage com a interface.
A View envia uma requisição HTTP.
O Controller recebe e identifica a ação solicitada.
O Controller realiza as validações necessárias.
O Model executa as operações de persistência ou consulta.
O banco MySQL armazena ou retorna os dados.
O Model devolve os resultados ao Controller.
A View apresenta as informações ao usuário.

9. Matriz de Rastreabilidade
Requisito de Usuário	Requisito de Sistema	Banco de Dados	Backend	Frontend	Status
RU01 — Registrar treinos	RS01 — Processar e salvar treino	registros_treino	Treino::salvarTreino()	Formulário de registro	Ativo
RU02 — Registrar peso	RS02 — Processar e salvar peso	peso_corporal	Treino::salvarPesoCorporal()	Formulário de peso	Ativo
RU03 — Consultar histórico	RS03 — Buscar registros	registros_treino	Treino::getHistoricoCompleto()	Tabela de histórico	Ativo
RU04 — Visualizar evolução	RS04 — Fornecer dados do gráfico	registros_treino	Treino::getEvolucaoCargas()	Chart.js	Ativo
RU05 — Consultar métricas	RS05 — Calcular métricas	registros_treino	getVolumeSemanal() / getCargaMaxima()	Cards do Dashboard	Ativo
RU06 — Consultar fichas	RS06 — Listar fichas	fichas_treino	Treino::getFichasTreino()	Fichas ABC	Ativo

pwrgenforce/
├── app/
│   ├── Controllers/
│   │   └── HomeController.php
│   ├── Models/
│   │   └── Treino.php
│   └── Views/
│       └── home.php
├── config/
│   └── database.php
├── public/
├── index.php
├── schema.sql
├── DOCUMENTACAO.md
├── Dockerfile
└── README.md

11. Tecnologias Utilizadas
PHP 8.x
MySQL
PDO
HTML5
CSS3
JavaScript ES6
Chart.js
Docker
Render


12. Banco de Dados

O projeto utiliza banco de dados MySQL para persistência das informações.

Tabela registros_treino
CREATE TABLE registros_treino (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL DEFAULT 1,
    exercicio VARCHAR(100) NOT NULL,
    carga DECIMAL(6,2) NOT NULL,
    repeticoes INT NOT NULL,
    data_registro DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Tabela peso_corporal
CREATE TABLE peso_corporal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL DEFAULT 1,
    peso DECIMAL(5,2) NOT NULL,
    data_registro DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Tabela fichas_treino
CREATE TABLE fichas_treino (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL DEFAULT 1,
    nome_ficha VARCHAR(100) NOT NULL,
    exercicios TEXT NOT NULL
);

13. Segurança
Prevenção contra SQL Injection

As operações de banco utilizam PDO e Prepared Statements, evitando a inserção direta de valores fornecidos pelo usuário nas consultas SQL.

Proteção contra Reenvio de Formulários

O sistema utiliza o padrão Post/Redirect/Get (PRG) após operações POST, reduzindo o risco de duplicação de registros causada por atualização da página.

Variáveis de Ambiente

As credenciais do banco de dados são obtidas por variáveis de ambiente:

DB_HOST
DB_PORT
DB_NAME
DB_USER
DB_PASS

As credenciais não devem ser armazenadas diretamente no código-fonte.

Configuração PDO

A conexão utiliza tratamento de exceções e Prepared Statements nativos:

PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
PDO::ATTR_EMULATE_PREPARES => false
14. Configuração e Execução
Variáveis de Ambiente

Configure:

DB_HOST
DB_PORT
DB_NAME
DB_USER
DB_PASS
Execução Local

Com o PHP instalado, execute:

php -S localhost:8000

Depois acesse:

http://localhost:8000
15. Limitações Atuais e Melhorias Futuras
Autenticação

A versão atual utiliza usuario_id = 1.

Como melhoria futura, poderá ser implementado:

sistema de cadastro;
login;
sessões;
password_hash();
controle individual de usuários.
Validação e Saída

As saídas apresentadas na View devem utilizar htmlspecialchars() de forma consistente para reduzir riscos de XSS.

Tratamento de Erros

Mensagens técnicas de banco de dados não devem ser exibidas diretamente ao usuário em produção.

Como melhoria futura, os erros poderão ser registrados em logs no servidor enquanto a interface apresenta mensagens genéricas.

16. Considerações Finais

O PwrGenFORCE foi estruturado para demonstrar a integração entre Frontend, Backend, Banco de Dados e Segurança, utilizando uma arquitetura MVC.

A matriz de rastreabilidade relaciona os requisitos de usuário às respectivas implementações do sistema, permitindo verificar o encadeamento entre necessidade, funcionalidade, persistência de dados e interface.


### 3. Salvar o arquivo

Depois de colar tudo no `nano`:

**Ctrl + O** → Enter → **Ctrl + X**

### 4. Verificar

De volta ao terminal, execute:

```bash
ls -lh README.md

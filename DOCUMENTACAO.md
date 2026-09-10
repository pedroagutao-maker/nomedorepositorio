# 🏋️‍♂️ PwrGenFORCE v5.7 — Documentação, Escopo e Plano de Execução

**Criador do Projeto:** Pedro  
**Arquitetura:** MVC (Model-View-Controller)  
**Stack Tecnológica:** PHP 8.2, MySQL, HTML5, CSS3, JavaScript (ES6+)

---

## 🎯 1. Escopo do Projeto

### 1.1. Objetivo Principal
O **PwrGenFORCE** é uma aplicação web interativa de gestão de saúde e performance física. O sistema permite ao atleta monitorar dados corporais, calcular metas nutricionais, acompanhar a evolução de cargas por meio de gráficos dinâmicos, planejar treinos segmentados por grupo muscular e registrar a frequência diária de treinos.

### 1.2. Arquitetura do Sistema (MVC)
- **Model (PHP 8.2 + MySQL):** Gerencia a persistência de dados no banco (registros de treino, cargas e histórico de evolução) utilizando **PDO** para garantir a segurança contra SQL Injection.
- **View (HTML5 + CSS3 + JavaScript):** Interface de usuário responsiva com design Glassmorphism, suporte a métricas dinâmicas, gráficos interativos (Chart.js), cronômetro de descanso e calculadora de 1RM.
- **Controller (PHP 8.2):** Intermedeia as requisições enviadas pelo Front-end (formulários POST e rotas da aplicação) e executa a comunicação com o banco de dados.

---

## 🛠️ 2. Stack Tecnológica

| Tecnologia | Camada | Função no Projeto |
| :--- | :--- | :--- |
| **HTML5** | View | Estruturação semântica das páginas e componentes do dashboard. |
| **CSS3** | View | Estilização em formato Glassmorphism, variáveis de tema e layouts flexíveis. |
| **JavaScript (ES6+)** | View / Interação | Dinamismo do cliente: cronômetro de descanso, calculadora de 1RM e Chart.js. |
| **PHP 8.2** | Controller / Model | Lógica de controle, roteamento via `index.php` e comunicação via PDO. |
| **MySQL** | Model (Banco de Dados) | Armazenamento persistente de registros de treino e cargas. |
| **Docker / Render** | Infraestrutura | Conteinerização (Apache + PHP 8.2) para deploy e hospedagem contínua. |

---

## 📂 3. Estrutura de Diretórios (Padrão MVC)

```text
pwrgenforce/
├── Dockerfile                 # Configuração do contêiner Apache/PHP para Render
├── schema.sql                 # DDL e carga inicial do banco de dados MySQL
├── DOCUMENTACAO.md            # Documentação e escopo do projeto
├── config/
│   └── database.php           # Conexão PDO com a base de dados
├── app/
│   ├── Controllers/
│   │   └── HomeController.php # Lógica do Dashboard e processamento de formulários
│   ├── Models/
│   │   └── Treino.php         # Regras de negócio e consultas SQL
│   └── Views/
│       └── home.php           # Interface principal do usuário
└── public/
    ├── index.php              # Front Controller (Ponto de entrada)
    ├── css/
    │   └── style.css          # Estilos CSS (Glassmorphism)
    └── js/
        └── main.js            # Lógica cliente (Chart.js, Timer e 1RM)

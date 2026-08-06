# 🏋️‍♂️ PwrGenFORCE v5.7 — Documentação, Escopo e Plano de Execução

**Criador do Projeto:** Pedro  
**Arquitetura:** MVC (Model-View-Controller)  
**Stack Tecnológica:** PHP 8, MySQL, HTML5, CSS3, JavaScript (ES6+)

---

## 🎯 1. Escopo do Projeto

### 1.1. Objetivo Principal
O **PwrGenFORCE** é uma aplicação web interativa de gestão de saúde e performance física. O sistema permite ao atleta monitorar dados corporais, calcular metas nutricionais, planejar treinos segmentados por grupo muscular via mapa anatômico e registrar a frequência diária.

### 1.2. Arquitetura do Sistema (MVC)
- **Model (PHP 8 + MySQL):** Gerencia a persistência de dados no banco (perfis dos usuários, histórico de treinos e dias marcados no calendário).
- **View (HTML5 + CSS3 + JavaScript):** Interface de usuário responsiva com suporte a tema claro/escuro, cronômetro dinâmico de descanso e seleção por mapa anatômico.
- **Controller (PHP 8):** Intermedeia as requisições enviadas pelo Front-end (via requisições `fetch`/JSON) e executa a comunicação segura com o banco de dados usando **PDO**.

---

## 🛠️ 2. Stack Tecnológica

| Tecnologia | Camada | Função no Projeto |
| :--- | :--- | :--- |
| **HTML5** | View | Estruturação semântica das páginas e mapas anatômicos. |
| **CSS3** | View | Estilização, variáveis de tema (Light/Dark) e layouts flexíveis (Grid/Flexbox). |
| **JavaScript (ES6+)** | View / Interação | Dinamismo do cliente: cronômetro de descanso, seleção anatômica e requisições Fetch. |
| **PHP 8** | Controller / Model | Lógica de controle, validação de regras de negócio e comunicação via PDO. |
| **MySQL** | Model (Banco de Dados) | Armazenamento persistente do perfil do usuário, *streaks* e histórico mensal. |

---

## 📂 3. Estrutura de Diretórios (Padrão MVC)

```text
pwrgenforce/
├── app/
│   ├── Controllers/       # Processamento das requisições (ex: UsuarioController.php)
│   ├── Models/            # Comunicação com a base MySQL via PDO (ex: UsuarioModel.php)
│   └── Views/             # Templates HTML/PHP renderizados
├── config/                # Credenciais e conexão com o banco de dados (database.php)
├── public/                # Ponto de entrada público
│   ├── index.php          # Front Controller (Roteador principal)
│   ├── css/               # Folhas de estilo CSS (style.css)
│   └── js/                # Scripts JavaScript (main.js)
└── DOCUMENTACAO.md        # Escopo e documentação do projeto

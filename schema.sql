CREATE DATABASE IF NOT EXISTS pwrgenforce;
USE pwrgenforce;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS registros_treino (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT DEFAULT 1,
    exercicio VARCHAR(100) NOT NULL,
    carga DECIMAL(5,2) NOT NULL,
    repeticoes INT NOT NULL,
    data_registro DATE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Dados iniciais para teste no gráfico
INSERT INTO usuarios (nome, email, senha) VALUES ('Atleta Demo', 'demo@pwrgenforce.com', '123456');

INSERT INTO registros_treino (usuario_id, exercicio, carga, repeticoes, data_registro) VALUES
(1, 'Supino Reto', 70.00, 10, '2026-08-01'),
(1, 'Supino Reto', 75.00, 8, '2026-08-08'),
(1, 'Supino Reto', 80.00, 8, '2026-08-15'),
(1, 'Supino Reto', 85.00, 6, '2026-08-22'),
(1, 'Supino Reto', 92.00, 5, '2026-08-29'),
(1, 'Supino Reto', 100.00, 3, '2026-09-03');

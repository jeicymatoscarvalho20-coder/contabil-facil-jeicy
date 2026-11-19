CREATE DATABASE IF NOT EXISTS contabil_facil CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE contabil_facil;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS avaliacoes;
DROP TABLE IF EXISTS obrigacoes;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(120) NOT NULL,
 email VARCHAR(160) NOT NULL UNIQUE,
 senha VARCHAR(255) NOT NULL,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE clientes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(160) NOT NULL,
 cnpj VARCHAR(30) NOT NULL,
 email VARCHAR(160),
 telefone VARCHAR(30),
 responsavel VARCHAR(120),
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY uk_cliente_documento (cnpj)
) ENGINE=InnoDB;

CREATE TABLE obrigacoes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 cliente_id INT NOT NULL,
 titulo VARCHAR(160) NOT NULL,
 descricao TEXT,
 vencimento DATE NOT NULL,
 status ENUM('Pendente','Em andamento','Concluída') NOT NULL DEFAULT 'Pendente',
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_obrigacao_cliente FOREIGN KEY(cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE avaliacoes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 usuario_id INT NOT NULL,
 nota TINYINT NOT NULL,
 comentario TEXT,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_avaliacao_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Senha do usuário de demonstração: password
INSERT INTO usuarios(nome,email,senha) VALUES
('Administrador','admin@contabilfacil.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.');

INSERT INTO clientes(nome,cnpj,email,telefone,responsavel) VALUES
('João Pereira','12.345.678/0001-90','joao@email.com','(86) 99999-1111','João Pereira'),
('Mariana Costa','98.765.432/0001-10','mariana@email.com','(86) 98888-2222','Mariana Costa');

INSERT INTO obrigacoes(cliente_id,titulo,descricao,vencimento,status) VALUES
(1,'Folha de pagamento','Conferir e processar folha mensal',DATE_SUB(CURDATE(), INTERVAL 7 DAY),'Pendente'),
(2,'Envio de documentos','Enviar extratos e notas fiscais',DATE_ADD(CURDATE(), INTERVAL 1 DAY),'Concluída'),
(2,'DAS - Simples Nacional','Apuração e emissão da guia DAS',DATE_ADD(CURDATE(), INTERVAL 5 DAY),'Pendente');

CREATE TABLE clientes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE produtos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 preco DECIMAL(10,2) NOT NULL,
 quantidade INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL UNIQUE,
 senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE vendas (
 id INT AUTO_INCREMENT PRIMARY KEY,
 cliente_id INT NOT NULL,
 produto_id INT NOT NULL,
 quantidade INT NOT NULL,
 preco_unitario DECIMAL(10,2) NOT NULL,
 data_venda DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 status VARCHAR(10) NOT NULL DEFAULT 'ativa',
 FOREIGN KEY (cliente_id) REFERENCES clientes(id),
 FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO clientes (nome, email) VALUES
('Cliente Exemplo 1', 'cliente1@example.com'),
('Cliente Exemplo 2', 'cliente2@example.com');

INSERT INTO produtos (nome, preco, quantidade) VALUES
('Camiseta básica', 49.90, 20),
('Calça jeans', 129.90, 10),
('Boné', 39.90, 3),
('Jaqueta', 199.90, 0);

INSERT INTO usuarios (nome, email, senha) VALUES
('Visitante', 'demo@example.com', '$2b$12$i4tpMgwtYc6wpsnDLGvGbO9iU1O5RI5iTH8tbPjokfYJrU5TWPpHu');

CREATE DATABASE IntegraLogDB;

USE IntegraLogDB;

CREATE TABLE usuarios (
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nomeUsuario VARCHAR(100) NOT NULL,
    emailUsuario VARCHAR(100) NOT NULL UNIQUE,
    senhaUsuario VARCHAR(255) NOT NULL,
    cargoUsuario TINYINT NOT NULL -- 1-Administrador, 2-Cliente, 3-Motorista
);

CREATE TABLE enderecos (
    idEndereco INT PRIMARY KEY AUTO_INCREMENT,
    nomeEndereco VARCHAR(100) NOT NULL,
    logradouroEndereco VARCHAR(100) NOT NULL,
    bairroEndereco VARCHAR(50) NOT NULL,
    cidadeEndereco VARCHAR(50) NOT NULL,
    estadoEndereco CHAR(2) NOT NULL DEFAULT 'RS',
    cepEndereco VARCHAR(10) NOT NULL,
    valorConsumo DECIMAL(10, 2) NOT NULL,
    valorPermanente DECIMAL(10, 2) NOT NULL
);

CREATE TABLE motoristas (
    idMotorista INT PRIMARY KEY AUTO_INCREMENT,
    nomeMotorista VARCHAR(100) NOT NULL,
    emailMotorista VARCHAR(100) NOT NULL UNIQUE,
    cpfMotorista VARCHAR(11) NOT NULL UNIQUE,
    cnhMotorista VARCHAR(11)NOT NULL UNIQUE,
    telefoneMotorista VARCHAR(15) NOT NULL UNIQUE
);

CREATE TABLE guias (
    idGuia INT PRIMARY KEY AUTO_INCREMENT,
    numeroGuia VARCHAR(20) NOT NULL UNIQUE,
    dataEmissaoGuia DATE NOT NULL,
    destinoGuia INT NOT NULL,
    tipoTransporteGuia TINYINT NOT NULL, -- 1-Remessa, 2-Recolhimento
    motoristaGuia INT NOT NULL,
    modalidadeGuia TINYINT NOT NULL,    -- 1-Consumo, 2-Permanente
    pesoGuia DECIMAL(10, 2) NOT NULL,
    valorFrete DECIMAL(10, 2) NOT NULL,
    statusGuia TINYINT NOT NULL,        -- 1-Coletada, 2-Transferencia, 3-Rota, 4-Entregue, 5-Divergente
    
    CONSTRAINT fk_destino_guia FOREIGN KEY (destinoGuia) REFERENCES enderecos(idEndereco),
    CONSTRAINT fk_motorista_guia FOREIGN KEY (motoristaGuia) REFERENCES motoristas(idMotorista)
);

CREATE TABLE guiaStatusHistorico (
    idHistorico INT PRIMARY KEY AUTO_INCREMENT,
    guiaHistorico INT NOT NULL,
    usuarioHistorico INT NULL,
    statusAnterior TINYINT NULL,            -- NULL no primeiro registro (criacao da guia)
    statusNovo TINYINT NOT NULL,            -- 1-Coletada, 2-Transferencia, 3-Rota, 4-Entregue, 5-Divergente
    dataHoraMudanca DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    observacaoHistorico VARCHAR(255) NULL,  -- ex: motivo de status "Divergente"

    CONSTRAINT fk_guia_historico FOREIGN KEY (guiaHistorico) REFERENCES guias(idGuia) ON DELETE CASCADE,
    CONSTRAINT fk_usuario_historico FOREIGN KEY (usuarioHistorico) REFERENCES usuarios(idUsuario) ON DELETE SET NULL
);

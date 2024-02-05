-- Creación de la tabla 'clientes'
CREATE TABLE clientes (
    cliente_id INT AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido1 VARCHAR(100) NOT NULL,
    apellido2 VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    telefono VARCHAR(15)
);

-- Creación de la tabla 'cuentas'
CREATE TABLE cuentas (
    cuenta_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    tipo ENUM('corriente', 'ahorros') NOT NULL,
    saldo DECIMAL(10, 2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id)
);

-- Creación de la tabla 'operaciones'
CREATE TABLE operaciones (
    operacion_id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL,
    tipo_operacion ENUM('ingreso', 'debito') NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    fecha_operacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descripcion VARCHAR(255),
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(cuenta_id)
);


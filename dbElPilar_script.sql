CREATE DATABASE ElPilar;
USE ElPilar;

CREATE TABLE Producto
(
	codigo_producto VARCHAR(20) PRIMARY KEY NOT NULL,
	nombre VARCHAR(30) NOT NULL,
	precio_unitario DECIMAL(10,2) DEFAULT 0,
	cantidad INT DEFAULT 0,
	descripcion LONGTEXT
);

CREATE TABLE Cliente
(
	id_cliente INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	nombre VARCHAR(30) NOT NULL,
	apellido VARCHAR(30) NOT NULL
);

CREATE TABLE Proveedor
(
	id_proveedor VARCHAR(50) PRIMARY KEY NOT NULL, #SE INSERTA EL RUC DE LA EMPRESA NO UN NUMERO CUALQUIERA
	nombre VARCHAR(30) NOT NULL,
	apellido VARCHAR(30) NOT NULL,
	empresa VARCHAR(50) NOT NULL,
	telefono CHAR(8) NOT NULL
);

CREATE TABLE Administrador
(
	id_administrador INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	nombre VARCHAR(30) NOT NULL,
	apellido VARCHAR(30) NOT NULL,
	correo VARCHAR(50) NOT NULL,
	clave CHAR(60) NOT NULL
);

CREATE TABLE Compra
(
	id_compra INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	fecha_compra DATE NOT NULL,
	total DECIMAL(10,2) DEFAULT 0,
	id_proveedor VARCHAR(50),
	CONSTRAINT fk_proveedor_id FOREIGN KEY(id_proveedor) REFERENCES Proveedor(id_proveedor)
);

CREATE TABLE DetalleCompra
(
	codigo_detalle_compra INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	cantidad INT NOT NULL,
	codigo_producto VARCHAR(20),
	id_compra INT,
	CONSTRAINT fk_codigo_producto_dc FOREIGN KEY(codigo_producto) REFERENCES Producto(codigo_producto),
	CONSTRAINT fk_id_compra_dc FOREIGN KEY(id_compra) REFERENCES Compra(id_compra)
);

CREATE TABLE Devolucion #antiguo dañados
(
	id_devolucion INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	descripcion LONGTEXT,
	fecha_devolucion DATE NOT NULL,
	total DECIMAL(10, 2)
);

CREATE TABLE DetalleDevolucion
(
	codigo_detalle_devolucion INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	cantidad INT NOT NULL,
	estado_devolucion BIT DEFAULT 0,
	codigo_producto VARCHAR(20),
	id_devolucion INT,
	CONSTRAINT fk_codigo_producto_dd FOREIGN KEY(codigo_producto) REFERENCES Producto(codigo_producto),
	CONSTRAINT fk_id_devolucion_dd FOREIGN KEY(id_devolucion) REFERENCES Devolucion(id_devolucion)
);

CREATE TABLE Consumido
(
	id_consumido INT AUTO_INCREMENT PRIMARY KEY, #NO SE INSERTA NADA DE ID
	fecha_consumido DATE NOT NULL,
	total DECIMAL(10,2)
);

CREATE TABLE DetalleConsumido
(
	codigo_detalle_consumido INT AUTO_INCREMENT PRIMARY KEY,
	cantidad INT NOT NULL,
	codigo_producto VARCHAR(20),
	id_consumido INT,
	CONSTRAINT fk_codigo_producto_dcm FOREIGN KEY(codigo_producto) REFERENCES Producto(codigo_producto),
	CONSTRAINT fk_id_consumido_dcm FOREIGN KEY(id_consumido) REFERENCES Consumido(id_consumido)
);

CREATE TABLE Contado
(
	id_contado INT AUTO_INCREMENT PRIMARY KEY,
	fecha_contado DATE NOT NULL,
	total DECIMAL(10,1)
);

CREATE TABLE DetalleContado
(
	codigo_detalle_contado INT AUTO_INCREMENT PRIMARY KEY,
	cantidad INT NOT NULL,
	codigo_producto VARCHAR(20),
	id_contado INT,
	CONSTRAINT fk_codigo_producto_dct FOREIGN KEY(codigo_producto) REFERENCES Producto(codigo_producto),
	CONSTRAINT fk_id_contado_dct FOREIGN KEY(id_contado) REFERENCES Contado(id_contado)
);

CREATE TABLE Credito
(
	id_credito INT AUTO_INCREMENT PRIMARY KEY,
	fecha_credito DATE NOT NULL, #fecha en que se abrio el credito
	fecha_cancelacion DATE NOT NULL, #fecha 'maxima' acordada para el pago
	monto_pagado DECIMAL(10,2) DEFAULT 0, #lo que lleva pagado
	monto_pendiente DECIMAL(10,2), #lo que le falta por pagar
	total DECIMAL(10,2),
	id_cliente INT,
	CONSTRAINT fk_id_cliente FOREIGN KEY(id_cliente) REFERENCES Cliente(id_cliente)
);

CREATE TABLE DetalleCredito
(
	codigo_detalle_credito INT AUTO_INCREMENT PRIMARY KEY,
	cantidad INT NOT NULL,
	codigo_producto VARCHAR(20),
	id_credito INT,
	CONSTRAINT fk_codigo_producto_dcdt FOREIGN KEY(codigo_producto) REFERENCES Producto(codigo_producto),
	CONSTRAINT fk_id_credito FOREIGN KEY(id_credito) REFERENCES Credito(id_credito)
);

##### CREACION DE LA TABLA CATEGORIA Y MODIFICANDO PRODUCTO  #####

CREATE TABLE Categoria
(
	id_categoria INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(50) NOT NULL,
	descripcion LONGTEXT NOT NULL,
	imagen VARCHAR(200)
);

ALTER TABLE Producto
ADD COLUMN id_categoria INT;

ALTER TABLE Producto
ADD CONSTRAINT fk_id_categoria FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria);

ALTER TABLE ElPilar.Producto
ADD COLUMN imagen VARCHAR(200);

ALTER TABLE ElPilar.Administrador 
ADD COLUMN imagen VARCHAR(200);

ALTER TABLE ElPilar.Proveedor
CHANGE COLUMN id_proveedor codigo_RUC VARCHAR(50) NOT NULL;

ALTER TABLE ElPilar.Compra
CHANGE COLUMN id_proveedor codigo_RUC VARCHAR(50) NOT NULL;

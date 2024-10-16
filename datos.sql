DROP TABLE IF EXISTS departamentos CASCADE;
DROP TABLE IF EXISTS empleados CASCADE;

CREATE TABLE departamentos (
    id              BIGSERIAL    PRIMARY KEY,
    codigo          VARCHAR(2)   NOT NULL UNIQUE,
    denominacion    VARCHAR(255) NOT NULL,
    localidad       VARCHAR(255),
    fecha_alta      TIMESTAMP       NOT NULL DEFAULT LOCALTIMESTAMP
);

CREATE TABLE empleados (
    id                  BIGSERIAL       PRIMARY KEY,
    numero              VARCHAR(255)    NOT NULL UNIQUE,
    nombre              VARCHAR(255)    NOT NULL,
    apellidos           VARCHAR(255)    NOT NULL,
    departamento_id     BIGINT          REFERENCES departamentos(id)
);


-----------

INSERT INTO departamentos (codigo, denominacion, localidad)
VALUES ('10', 'Informática', 'Sanlúcar'),
       ('20', 'Administrativo', NULL),
       ('30', 'Matemáticas', 'Chipiona');

INSERT INTO empleados (numero, nombre, apellidos, departamento_id)
VALUES ('1', 'Alfonso', 'Álvarez', 1),
       ('2', 'Beatriz', 'Barrranco', 1),
       ('3', 'Carlos', 'Carrasco', 3),
       ('4', 'David', 'Dominguez', 3),
       ('5', 'Elena', 'Escobar', 1),
       ('6', 'Francisco', 'Franco', NULL),
       ('7', 'Gregorio', 'Gutierrez', 3);

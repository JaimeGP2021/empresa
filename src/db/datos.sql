DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id       BIGSERIAL    PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS departamentos CASCADE;

CREATE TABLE departamentos (
    id           BIGSERIAL    PRIMARY KEY,
    codigo       VARCHAR(2)   NOT NULL UNIQUE,
    denominacion VARCHAR(255) NOT NULL,
    localidad    VARCHAR(255),
    fecha_alta   TIMESTAMP(0) NOT NULL DEFAULT LOCALTIMESTAMP
);

DROP TABLE IF EXISTS empleados CASCADE;

CREATE TABLE empleados (
    id              BIGSERIAL    PRIMARY KEY,
    numero          VARCHAR(4)   NOT NULL UNIQUE,
    nombre          VARCHAR(255) NOT NULL,
    apellidos       VARCHAR(255) NOT NULL,
    departamento_id BIGINT       REFERENCES departamentos (id)
);

-----------

INSERT INTO usuarios (username, password)
VALUES ('admin', crypt('admin', gen_salt('bf', 10))),
       ('usuario', crypt('usuario', gen_salt('bf', 10)));

INSERT INTO departamentos (codigo, denominacion, localidad)
VALUES ('10', 'Informática', 'Sanlúcar'),
       ('20', 'Administrativo', NULL),
       ('30', 'Matemáticas', 'Chipiona');

INSERT INTO empleados (numero, nombre, apellidos, departamento_id)
VALUES ('1000', 'Manolo', 'Pérez', 1),
       ('2000', 'María', 'Rodríguez', 3),
       ('3000', 'Rosa', 'González', NULL);

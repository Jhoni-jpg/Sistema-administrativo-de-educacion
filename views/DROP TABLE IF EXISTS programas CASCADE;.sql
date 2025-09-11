DROP TABLE IF EXISTS programas CASCADE;
DROP TABLE IF EXISTS fichas CASCADE;
DROP TABLE IF EXISTS estudiantes CASCADE;
DROP TABLE IF EXISTS notas CASCADE;
DROP TABLE IF EXISTS cursos CASCADE;
DROP TABLE IF EXISTS users CASCADE;


DROP TYPE rol
CREATE TYPE rol AS ENUM ('user', 'admin', 'desertado', 'graduado', 'estudiante', 'docente');
CREATE TYPE estado_estudiante AS ENUM ('inactivo', 'activo');

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    create_at DATE DEFAULT CURRENT_TIMESTAMP,
    rol rol DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS estudiantes (
    id SERIAL PRIMARY KEY,
    document VARCHAR(12) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    estado estado_estudiante DEFAULT 'activo',
    id_ficha INT NOT NULL,
    id_programa INT NOT NULL,
    fecha_creacion DATE DEFAULT CURRENT_DATE NOT NULL,

    CONSTRAINT fkId_ficha FOREIGN KEY (id_ficha) REFERENCES fichas(id),
    CONSTRAINT fkId_programa FOREIGN KEY (id_programa) REFERENCES programas(id)
);

CREATE TABLE IF NOT EXISTS notas (
    id SERIAL PRIMARY KEY,
    id_estudiante INT NOT NULL,
    id_curso INT NOT NULL,
    nota NUMERIC(5,2) NOT NULL,
    observacion VARCHAR(255),
    fecha_registro DATE DEFAULT CURRENT_DATE,

    CONSTRAINT fkId_estudiante FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id),
    CONSTRAINT fkId_curso FOREIGN KEY (id_curso) REFERENCES cursos(id)
);

CREATE TABLE IF NOT EXISTS cursos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE,
    creditos INT
);

CREATE TABLE IF NOT EXISTS programas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    fecha_creacion DATE DEFAULT CURRENT_DATE
);

CREATE TABLE IF NOT EXISTS fichas (
    id SERIAL PRIMARY KEY,
    id_programa INT NOT NULL,
    ubicacion_ficha VARCHAR(150) NOT NULL,
    numero_ficha INT UNIQUE NOT NULL,

    CONSTRAINT fkId_programa FOREIGN KEY (id_programa) REFERENCES programas(id)
);
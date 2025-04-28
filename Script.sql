CREATE DATABASE BD_PRUEBA_FL;
USE BD_PRUEBA_FL;

-- Tabla citas
CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_paciente VARCHAR(255) NOT NULL,
    especialidad ENUM('Medicina General', 'Pediatría', 'Dermatología') NOT NULL,
    fecha_cita DATETIME NOT NULL
);

-- Datos pre guardados 
INSERT INTO citas (nombre_paciente, especialidad, fecha_cita)
VALUES ('Freya Lopez', 'Medicina General', '2025-04-26 10:00:00');

INSERT INTO citas (nombre_paciente, especialidad, fecha_cita)
VALUES ('Milena Lopez', 'Pediatría', '2025-04-28 09:00:00');

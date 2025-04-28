<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre_paciente = $_POST['nombre_paciente'];
    $especialidad = $_POST['especialidad'];
    $fecha_cita = $_POST['fecha_cita'];

    // Validaciones 
    if (empty($nombre_paciente) || empty($especialidad) || empty($fecha_cita)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Valida que la fecha no sea en el pasado
        $fecha_actual = date("Y-m-d\TH:i"); 
        if ($fecha_cita < $fecha_actual) {
            $error = "La fecha y hora de la cita no puede ser en el pasado.";
        } else {
            // Insertar la cita en la base de datos
            $sql = "INSERT INTO citas (nombre_paciente, especialidad, fecha_cita) 
                    VALUES (:nombre_paciente, :especialidad, :fecha_cita)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre_paciente' => $nombre_paciente,
                ':especialidad' => $especialidad,
                ':fecha_cita' => $fecha_cita
            ]);

            // Redirigir a la pagina de listado de citas 
            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cita Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">Registrar Nueva Cita</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($error) ?></div> 
    <?php endif; ?>

    <form method="POST" action="registrar.php">
        <div class="mb-3">
            <label for="nombre_paciente" class="form-label">Nombre del paciente</label>
            <input type="text" class="form-control" id="nombre_paciente" name="nombre_paciente" required>
        </div>

        <div class="mb-3">
            <label for="especialidad" class="form-label">Especialidad</label>
            <select class="form-control" id="especialidad" name="especialidad" required>
                <option value="Medicina General">Medicina General</option>
                <option value="Pediatría">Pediatría</option>
                <option value="Dermatología">Dermatología</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_cita" class="form-label">Fecha y hora de la cita</label>
            <input type="datetime-local" class="form-control" id="fecha_cita" name="fecha_cita" required 
                   min="<?= date('Y-m-d\TH:i') ?>"> 
        </div>

        <button type="submit" class="btn btn-primary">Registrar Cita</button>
    </form>

    <a href="index.php" class="btn btn-secondary mt-3">Volver al listado de citas</a>
</div>

<script>
    // Validacion de formulario antes de enviarlo
    document.querySelector('form').addEventListener('submit', function(event) {
        // Obtener los valores de los campos
        var nombrePaciente = document.getElementById('nombre_paciente').value;
        var especialidad = document.getElementById('especialidad').value;
        var fechaCita = document.getElementById('fecha_cita').value;

        // Valida que no estén vacíos
        if (!nombrePaciente || !especialidad || !fechaCita) {
            alert("Por favor, complete todos los campos.");
            event.preventDefault();  // Detener el envío del formulario
        }
    });
</script>

</body>
</html>

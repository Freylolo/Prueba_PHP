<?php
require_once 'conexion.php';

// Filtrar 
$searchTerm = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $stmt = $pdo->prepare("SELECT * FROM citas WHERE nombre_paciente LIKE ? OR especialidad LIKE ? ORDER BY fecha_cita ASC");
    $stmt->execute([$searchTerm, $searchTerm]);
} else {
    // Si no hay búsqueda, mostrar todas las citas ordenadas por fecha
    $stmt = $pdo->query("SELECT * FROM citas ORDER BY fecha_cita DESC");
}

$citas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Citas Médicas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilo para citas pasadas */
        .pasada {
            text-decoration: line-through;
            color: #6c757d;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">Citas Médicas</h1>

    <a href="registrar.php" class="btn btn-success mb-3">Registrar nueva cita</a>

    <form method="GET" action="" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o especialidad" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </form>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th class="d-none">ID</th> 
                <th>Paciente</th>
                <th>Especialidad</th>
                <th>Fecha y Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($citas) > 0): ?>
                <?php foreach ($citas as $cita): ?>
                    <?php
                    // Verifica si la cita ya ha pasado
                    $isPast = strtotime($cita['fecha_cita']) < time();
                    ?>
                    <tr class="<?= $isPast ? 'pasada' : '' ?>">
                        <td class="d-none"><?= htmlspecialchars($cita['id']) ?></td> 
                        <td><?= htmlspecialchars($cita['nombre_paciente']) ?></td>
                        <td><?= htmlspecialchars($cita['especialidad']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($cita['fecha_cita'])) ?></td>
                        <td>
                            <a href="eliminar.php?id=<?= $cita['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta cita?')">
                                <i class="bi bi-trash"></i> 
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay citas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

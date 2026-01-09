<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <h1>Lista de usuarios</h1>

    <ul>
        <?php foreach ($usuarios as $u): ?>
            <li><?= $u['nombre'] ?> - <?= $u['email'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

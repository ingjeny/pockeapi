<?php
// Incluir el archivo de conexión
require 'Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $type = json_encode($_POST['type']);
    $moves = json_encode($_POST['moves']);
    $existing_image = $_POST['existing_image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $image = $existing_image;
    }

    // Crear conexión usando la clase mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta para actualizar los datos del Pokémon
    $sql = "UPDATE pokemon SET name = ?, type = ?, moves = ?, image = ? WHERE id = ?";
    
    // Preparar la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar parámetros
        $stmt->bind_param("ssssi", $name, $type, $moves, $image, $id);
        
        // Ejecutar la declaración
        if ($stmt->execute()) {
            header("Location: editar.php?id=$id&updated=true");
        } else {
            echo "Error al actualizar los datos: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>

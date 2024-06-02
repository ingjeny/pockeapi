<?php
// Incluir el archivo de conexión
require 'Conexion.php';

// Crear conexión usando la clase mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del Pokémon a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la declaración SQL para evitar inyecciones SQL
    $stmt = $conn->prepare("DELETE FROM pokemon WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Redirigir a index.php después de eliminar
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar el Pokémon: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
}

$conn->close();
?>

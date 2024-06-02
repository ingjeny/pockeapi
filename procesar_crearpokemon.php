<?php
// Conectar a la base de datos (reemplaza con tus propios datos de conexión)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pocke_api";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$name = $_POST['name'];
$types = $_POST['type']; // Array de tipos
$moves = $_POST['moves']; // Array de movimientos
$image = $_FILES['image']['name'];

// Ruta donde se almacenará la imagen (asegúrate de tener los permisos de escritura necesarios)
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
// Mover la imagen a la carpeta de destino
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// Convertir los arrays de tipos y movimientos en cadenas JSON
$types_json = json_encode($types);
$moves_json = json_encode($moves);

// Insertar el nuevo Pokémon en la base de datos
$sql = "INSERT INTO pokemon (name, type, moves, image)
VALUES ('$name', '$types_json', '$moves_json', '$image')";

if ($conn->query($sql) === TRUE) {
  // Redirigir a la página de creación con un parámetro de éxito
  header("Location: crearpokemon.php?created=true");
  exit();
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>

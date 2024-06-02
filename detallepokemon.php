<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle Pokémon</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .pokemon-details {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .pokemon-details img {
      max-width: 100%;
      height: auto;
    }
    .pokemon-details h3 {
      margin: 10px 0;
      font-size: 24px;
    }
    .pokemon-details p {
      font-size: 18px;
      margin: 5px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    if (isset($_GET['name'])) {
        $name = htmlspecialchars($_GET['name']);
        $poke_api_url = "https://pokeapi.co/api/v2/pokemon/" . urlencode($name);

        // Función para hacer solicitudes HTTP con cURL
        function fetch_data($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        // Leer datos JSON desde la PokeAPI usando cURL
        $poke_json_data = fetch_data($poke_api_url);

        // Decodificar datos JSON en un array de PHP
        $poke_response_data = json_decode($poke_json_data);

        // Verificar si se obtuvieron datos válidos
        if ($poke_response_data) {
            // Extraer detalles del Pokémon
            $poke_image_url = htmlspecialchars($poke_response_data->sprites->front_default);
            $types = array_map(function($type) {
                return $type->type->name;
            }, $poke_response_data->types);
            $abilities = array_map(function($ability) {
                return $ability->ability->name;
            }, $poke_response_data->abilities);

            // Mostrar detalles del Pokémon
            echo "<div class='pokemon-details'>";
            echo "<h3>" . htmlspecialchars($name) . "</h3>";
            echo "<img src='" . $poke_image_url . "' alt='" . htmlspecialchars($name) . "' />";
            echo "<p>Tipo de pokemon: " . implode(', ', $types) . "</p>";
            echo "<p>Habilidad de pokemon: " . implode(', ', $abilities) . "</p>";
            echo "</div>";
        } else {
            echo "<p>Error al obtener los detalles del Pokémon.</p>";
        }
    } else {
        echo "<p>Nombre del Pokémon no especificado.</p>";
    }
    ?>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pokémon List</title>
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
    .search-bar {
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .search-bar input[type="text"] {
      padding: 10px;
      width: 300px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px 0 0 5px;
    }
    .search-bar button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
      margin-right: 10px;
    }
    .search-bar button:hover {
      background-color: #0056b3;
    }
    .new-pokemon-button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-right: 10px;
    }
    .new-pokemon-button:hover {
      background-color: #218838;
    }
    .my-pokemon-button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #ffc107;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .my-pokemon-button:hover {
      background-color: #e0a800;
    }
    .pokemon-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .pokemon-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      overflow: hidden;
      width: calc(20% - 20px);
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
      padding: 20px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .pokemon-card:hover {
      transform: scale(1.05);
    }
    .pokemon-card img {
      max-width: 100%;
      height: auto;
    }
    .pokemon-card h3 {
      margin: 10px 0;
      font-size: 18px;
    }
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .pagination button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      margin: 0 5px;
    }
    .pagination button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Search bar -->
    <div class="search-bar">
      <form action="search.php" method="post">
        <input type="text" name="search_input" placeholder="Search pokemon...">
        <button type="submit">Search</button>
      </form>
      <button class="new-pokemon-button" onclick="window.location.href='crearpokemon.php'">Nuevo Pokémon</button>
      <button class="my-pokemon-button" onclick="window.location.href='verpokemones.php'">Mis Pokemones</button>
    </div>
    <div class="pokemon-list">
      <?php
      // Determinar la página actual y calcular el offset
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $limit = 35; // Número de Pokémon por página
      $offset = ($page - 1) * $limit; // Calcular el offset

      // URL de la API con el límite y el offset
      $poke_api_url = "https://pokeapi.co/api/v2/pokemon?limit=$limit&offset=$offset";

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

      // Leer datos JSON de la PokeAPI usando cURL
      $json_data = fetch_data($poke_api_url);

      // Decodificar datos JSON en un array de PHP
      $response_data = json_decode($json_data);

      // Almacenar todos los resultados de Pokémon en una variable
      $poke_objects = $response_data->results;

      // Obtener datos de cada Pokémon uno por uno
      foreach ($poke_objects as $pokemon) {
        // Almacenar la URL y el nombre de cada Pokémon en variables
        $name = $pokemon->name;
        $url = $pokemon->url;

        // Leer datos JSON desde la URL del Pokémon usando cURL
        $poke_json_data = fetch_data($url);

        // Decodificar datos JSON en un array de PHP
        $poke_response_data = json_decode($poke_json_data);

        // Verificar si se obtuvieron datos válidos
        if (!$poke_response_data) {
            continue; // Saltar a la siguiente iteración si no se obtuvieron datos válidos
        }

        // Extraer la URL de la primera imagen sprite
        $poke_image_url = htmlspecialchars($poke_response_data->sprites->front_default);

        // Mostrar la tarjeta del Pokémon con enlace a la página de detalles
        echo "<a href='detallepokemon.php?name=$name' class='pokemon-card'>";
        echo "<h3>" . htmlspecialchars($name) . "</h3>";
        echo "<img src='" . htmlspecialchars($poke_image_url) . "' alt='" . htmlspecialchars($name) . "' />";
        echo "</a>";
      }
      ?>
    </div>
    <div class="pagination">
      <?php
      // Mostrar enlaces para cambiar de página
      if ($page > 1) {
        echo "<button onclick=\"window.location.href='index.php?page=" . ($page - 1) . "'\">Anterior</button>";
      }
      if (count($poke_objects) == $limit) {
        echo "<button onclick=\"window.location.href='index.php?page=" . ($page + 1) . "'\">Siguiente</button>";
      }
      ?>
    </div>
  </div>
</body>
</html>

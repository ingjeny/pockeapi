<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Pokémon</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('img/Fondoapi.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
    }

    input[type="text"],
    input[type="file"],
    select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-top: 5px;
      margin-bottom: 10px;
    }

    .btn-submit,
    .btn-view {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-align: center;
      margin-top: 10px;
    }

    .btn-submit {
      background-color: #28a745;
      color: white;
    }

    .btn-submit:hover {
      background-color: #218838;
    }

    .btn-view {
      background-color: #007bff;
      color: white;
    }

    .btn-view:hover {
      background-color: #0056b3;
    }

    .success-message {
      display: none;
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container form-container">
    <h2>¿QUIERES AGREGAR UN POKÉMON NUEVO?</h2>
    <div id="success-message" class="success-message">Pokémon creado con éxito</div>
    <form action="procesar_crearpokemon.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" class="form-control">
      </div>

      <div class="form-group">
        <label for="type" class="form-label">Tipo:</label>
        <select id="type" name="type[]" multiple class="form-control">
          <option value="Normal">Normal</option>
          <option value="Lucha">Lucha</option>
          <option value="Volador">Volador</option>
          <option value="Veneno">Veneno</option>
          <option value="Tierra">Tierra</option>
          <option value="Roca">Roca</option>
          <option value="Bicho">Bicho</option>
          <option value="Fantasma">Fantasma</option>
          <option value="Acero">Acero</option>
          <option value="Fuego">Fuego</option>
          <option value="Agua">Agua</option>
          <option value="Hierba">Hierba</option>
          <option value="Eléctrico">Eléctrico</option>
          <option value="Psíquico">Psíquico</option>
          <option value="Hielo">Hielo</option>
          <option value="Dragón">Dragón</option>
          <option value="Siniestro">Siniestro</option>
          <option value="Hada">Hada</option>
          <option value="Desconocido">Desconocido</option>
        </select>
      </div>

      <div class="form-group">
        <label for="moves" class="form-label">Movimientos:</label>
        <select id="moves" name="moves[]" multiple class="form-control">
          <option value="Hediondez">Hediondez</option>
          <option value="Llovizna">Llovizna</option>
          <option value="Aumento de Velocidad">Aumento de Velocidad</option>
          <option value="Armadura Batalla">Armadura Batalla</option>
          <option value="Robustez">Robustez</option>
          <option value="Humedad">Humedad</option>
          <option value="Ágil">Ágil</option>
          <option value="Velo Arena">Velo Arena</option>
          <option value="Electricidad Estática">Electricidad Estática</option>
          <option value="Absorbe Voltio">Absorbe Voltio</option>
          <option value="Absorbe Agua">Absorbe Agua</option>
          <option value="Ajeno">Ajeno</option>
          <option value="Cielonube">Cielonube</option>
          <option value="Ojos Compuestos">Ojos Compuestos</option>
          <option value="Insomnio">Insomnio</option>
          <option value="Cambio Color">Cambio Color</option>
          <option value="Inmunidad">Inmunidad</option>
          <option value="Fuego Flash">Fuego Flash</option>
          <option value="Escudo Polvo">Escudo Polvo</option>
          <option value="Marcha Propia">Marcha Propia</option>
        </select>
      </div>

      <div class="form-group">
        <label for="image" class="form-label">Imagen:</label>
        <input type="file" id="image" name="image" class="form-control-file">
      </div>

      <button type="submit" class="btn btn-submit">Crear Pokémon</button>
    </form>
    <a href="index.php" class="btn btn-view">Ver Pokemones</a>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('created') && urlParams.get('created') === 'true') {
        const successMessage = document.getElementById('success-message');
        successMessage.style.display = 'block';
        setTimeout(() => {
          successMessage.style.display = 'none';
        }, 3000); // El mensaje desaparecerá después de 3 segundos
      }
    });
  </script>
</body>
</html>

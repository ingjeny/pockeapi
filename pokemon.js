document.addEventListener("DOMContentLoaded", function() {
    // Check if Pokémon data is already in localStorage
    if (!localStorage.getItem('pokemonData')) {
        // Fetch data from the API if not in localStorage
        fetchAllPokemonData();
    } else {
        // Use the data from localStorage
        const pokemonData = JSON.parse(localStorage.getItem('pokemonData'));
        renderPokemonList(pokemonData);
    }

    // Function to fetch all Pokémon data from the API
    function fetchAllPokemonData() {
        let pokemonData = [];
        const limit = 151; // Number of Pokémon to fetch
        const requests = [];

        for (let i = 1; i <= limit; i++) {
            const url = `https://pokeapi.co/api/v2/pokemon/${i}`;
            requests.push(fetch(url).then(response => response.json()));
        }

        Promise.all(requests)
            .then(results => {
                results.forEach(pokemon => {
                    pokemonData.push({
                        id: pokemon.id,
                        name: pokemon.name,
                        type: pokemon.types.map(type => type.type.name),
                        moves: pokemon.moves.map(move => move.move.name).slice(0, 8), // Limit to 8 moves
                        image: pokemon.sprites.front_default
                    });
                });
                localStorage.setItem('pokemonData', JSON.stringify(pokemonData));
                renderPokemonList(pokemonData);
            })
            .catch(error => console.error('Error fetching Pokémon data:', error));
    }

    // Function to render the Pokémon list
    function renderPokemonList(pokemonData) {
        const pokemonListContainer = document.querySelector('.pokemon-list');
        pokemonListContainer.innerHTML = '';
        pokemonData.forEach(pokemon => {
            const pokemonCard = document.createElement('a');
            pokemonCard.href = `detail.php?name=${pokemon.name}`;
            pokemonCard.classList.add('pokemon-card');
            pokemonCard.innerHTML = `
                <h3>${pokemon.name}</h3>
                <img src="${pokemon.image}" alt="${pokemon.name}">
            `;
            pokemonListContainer.appendChild(pokemonCard);
        });
    }
});

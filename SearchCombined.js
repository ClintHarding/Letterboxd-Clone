const container = document.getElementById('results');

async function searchMovies(query) {
  const apiKey = '7f0e42ab052fbd09ee9ddc86b625600a'; // Modified: Replace with your own API key
  const searchUrl = `https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&query=${query}`;
  try {
    const response = await fetch(searchUrl);
    const searchResults = await response.json();
    const movies = await Promise.all(searchResults.results.map(async ({ title, release_date: releaseDate, genre_ids: genreIds, id: movieId, poster_path: posterPath }) => {
      const posterUrl = `https://image.tmdb.org/t/p/w500/${posterPath}`;
      const genres = await fetch(`https://api.themoviedb.org/3/genre/movie/list?api_key=${apiKey}`)
        .then(response => response.json())
        .then(data => data.genres.filter(genre => genreIds.includes(genre.id)).map(genre => genre.name));
      const { crew, cast } = await fetch(`https://api.themoviedb.org/3/movie/${movieId}/credits?api_key=${apiKey}`)
        .then(response => response.json());
      const directors = crew.filter(person => person.department === 'Directing').slice(0, 3).map(director => director.name);
      const actors = cast.slice(0, 5).map(actor => actor.name);
      const synopsis = await fetch(`https://api.themoviedb.org/3/movie/${movieId}?api_key=${apiKey}&language=en-US`)
        .then(response => response.json())
        .then(data => data.overview);
      return { movieId, title, year: releaseDate ? releaseDate.substring(0, 4) : '', genres, directors, actors, synopsis, posterUrl }; // Modified: Add movieId property to the returned object
    }));
    return movies;
  } catch (error) {
    console.error(error);
    return [];
  }
}

async function handleSearch() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const query = urlParams.get('query');
  const results = await searchMovies(query);
  container.innerHTML = results.map(movie => {
    const filmId = movie.movieId; // Modified: Store movie ID in a variable called filmId
    return `
      <div class="movie-item">
        <a href="movie-details.php?filmname=${filmId}"><img src="${movie.posterUrl}" class="poster"></a>
        <div class="movie-info">
          <div class="info-wrapper">
            <h4><a href="movie-details.php?filmname=${filmId}" class="link movinfotitle">${movie.title}</a></h4>
            <div class="movie-details">
              <div class='movinf'><span class='movdet'>Year:</span> ${movie.year}</div>
              <div class='movinf'><span class='movdet'>Genres:</span> ${movie.genres.join(', ')}</div>
              <div class='movinf'><span class='movdet'>Directors:</span> ${movie.directors.join(', ')}</div>
              <div class='movinf'><span class='movdet'>Actors:</span> ${movie.actors.join(', ')}</div>
              <div class='movinf'><span class='movdet'>Synopsis:</span> ${movie.synopsis}</div>
            </div>
            <div class="movie-actions">
              <span>Like &hearts;</span> | <span>Add to List</span> | <span><a href="movie-details.php?filmname=${filmId}#rate-movie" class="link">Rate</a></span>
            </div>
          </div>
        </div>
      </div>
    `;
  }).join('');
}

handleSearch();

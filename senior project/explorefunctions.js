const container = document.getElementById('poster-container');

async function getTopMoviePosters() {
  const apiKey = '7f0e42ab052fbd09ee9ddc86b625600a'; 
  const url = `https://api.themoviedb.org/3/movie/popular?api_key=${apiKey}&language=en-US&page=1`;

  try {
    const response = await fetch(url);
    const data = await response.json();
    const posters = data.results.slice(0, 5).map(movie => {
      return `
        <a href="movie-details.php?filmname=${movie.id}" style="link">
          <img src="https://image.tmdb.org/t/p/w200${movie.poster_path}" alt="${movie.title} movie poster" width="173" height="260">
        </a>
      `;
    }).join('');
    container.innerHTML = posters;
  } catch (error) {
    console.error(error);
  }
}

getTopMoviePosters();
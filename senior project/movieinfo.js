const container = document.getElementById('results');

async function APIdetails(filmname) {
    const apiKey = '7f0e42ab052fbd09ee9ddc86b625600a';
    const movieUrl = `https://api.themoviedb.org/3/movie/${filmname}?api_key=${apiKey}&language=en-US`;
    try {
      const response = await fetch(movieUrl);
      const movieDetails = await response.json();
      const posterUrl = `https://image.tmdb.org/t/p/w500/${movieDetails.poster_path}`;
      const genres = await fetch(`https://api.themoviedb.org/3/genre/movie/list?api_key=${apiKey}`)
        .then(response => response.json())
        .then(data => movieDetails.genres.map(genre => data.genres.find(x => x.id === genre.id).name));
      const { crew, cast } = await fetch(`https://api.themoviedb.org/3/movie/${filmname}/credits?api_key=${apiKey}`)
        .then(response => response.json());
      const directors = crew.filter(person => person.department === 'Directing').slice(0, 3).map(director => director.name);
      const actors = cast.slice(0, 5).map(actor => actor.name);
      const synopsis = movieDetails.overview;
      return { movieId: filmname, title: movieDetails.title, year: movieDetails.release_date ? movieDetails.release_date.substring(0, 4) : '', genres, directors, actors, synopsis, posterUrl };
    } catch (error) {
      console.error(error);
      return null;
    }
  }

  async function MovieDetails() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const filmname = urlParams.get('filmname');
    const movieDetails = await APIdetails(filmname);
    container.innerHTML = `
      <div class="movie-item">
        <img src="${movieDetails.posterUrl}" class="poster">
        <div class="movie-info">
          <div class="info-wrapper">
            <h4 class='movinfotitle'>${movieDetails.title}</h4>
            <div class="movie-details">
              <div class='movinf'><span class='movdet'>Year:</span> ${movieDetails.year}</div>
              <div class='movinf'><span class='movdet'>Genres:</span> ${movieDetails.genres.join(', ')}</div>
              <div class='movinf'><span class='movdet'>Directors:</span> ${movieDetails.directors.join(', ')}</div>
              <div class='movinf'><span class='movdet'>Actors:</span> ${movieDetails.actors.join(', ')}</div>
              <div class='movinf'><span class='movdet'>Synopsis:</span> ${movieDetails.synopsis}</div>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  async function getBackdrop(filmname) {
    const apiKey = '7f0e42ab052fbd09ee9ddc86b625600a';
    const { movieId } = await APIdetails(filmname);
    const movieUrl = `https://api.themoviedb.org/3/movie/${movieId}?api_key=${apiKey}&language=en-US`;
    try {
      const response = await fetch(movieUrl);
      const movieDetails = await response.json();
      const backdropUrl = `https://image.tmdb.org/t/p/original/${movieDetails.backdrop_path}`;
      const backdropImg = document.getElementById("backdrop-image");
      backdropImg.src = backdropUrl;
    } catch (error) {
      console.error(error);
      return null;
    }
  }
  
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const filmname = urlParams.get('filmname');

  MovieDetails();
  getBackdrop(filmname);

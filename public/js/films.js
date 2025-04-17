document.addEventListener("DOMContentLoaded", function () {
  let err = document.getElementById("");
  let token = localStorage.getItem("token");
  if (token) {
      fetchFilms();
  } else {
      window.location.href = "/login";
  }
});

function fetchFilms() {
  const conn = new XMLHttpRequest();
  let token = localStorage.getItem("token");
  console.log("Retrieved token:", token);

  conn.open("GET", "http://localhost:8000/api/film", true);
  conn.setRequestHeader("Authorization", "Bearer " + token);

  conn.onload = function () {
      if (conn.status === 200) {
          const films = JSON.parse(conn.responseText);
          displayFilms(films);
      } else {
          console.error("Error fetching films:", conn.statusText);
      }
  };

  conn.onerror = function () {
      console.error("Request failed");
  };

  conn.send();
}

function displayFilms(films) {
  const container = document.getElementById("films-container");
  if (!container) return;

  container.innerHTML = "";

  films.forEach((film) => {
      const filmCard = `
  <div class="film-card bg-white rounded-lg overflow-hidden shadow-md">
              <div class="relative">
                  <img src="http://localhost:8000/storage/${film.image}" alt="${film.title}" class="w-full h-80 object-cover">
              </div>
              <div class="p-4">
                  <h3 class="font-bold text-lg mb-1">${film.title}</h3>
                  <div class="flex items-center text-sm text-gray-600 mb-2">
                      <span>${film.duration} min</span>
                      <span class="mx-2">•</span>
                      <span>${film.genre}</span>
                  </div>
                  <div class="rating flex items-center mb-3">
                      <span>★</span>
                      <span>★</span>
                      <span>★</span>
                      <span>★</span>
                      <span class="text-gray-300">★</span>
                      <span class="ml-1 text-gray-600 text-sm">(2.3k reviews)</span>
                  </div>
                  <p class="text-gray-600 text-sm mb-4 truncate">${film.description}</p>
                  <a href='http://localhost:8001/films/${film.id}'><button
                      class="view-details w-full bg-rose-600 hover:bg-rose-700 text-white py-2 rounded-md transition"
                  >
                   View Details
                  </button></a>
              </div>
          </div>
  `;
      container.innerHTML += filmCard;
  });
}

const detailButtons = document.querySelectorAll(".view-details");
detailButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
      const filmId = btn.getAttribute("data-id");
      viewFilmDetails(filmId);
  });
});

function viewFilmDetails(filmId) {
  window.location.href = `/films/${filmId}`;
}

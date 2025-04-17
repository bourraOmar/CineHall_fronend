<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Film Hero Section -->
        <div class="relative rounded-xl overflow-hidden mb-8">
            <!-- Background Image (Blurred) -->
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('http://localhost:8000/storage/placeholder-bg.jpg'); filter: blur(8px); opacity: 0.3;">
            </div>

            <!-- Content -->
            <div class="relative z-10 p-6 md:p-8 flex flex-col md:flex-row items-start">
                <!-- Poster -->
                <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8 w-full md:w-auto">
                    <img id="film-image" src="http://localhost:8000/storage/placeholder.jpg" alt="Film poster"
                        class="w-full md:w-80 h-auto rounded-lg shadow-lg">
                </div>

                <!-- Film Info -->
                <div class="flex-1">
                    <h1 id="film-title" class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Loading ...</h1>

                    <div class="flex flex-wrap items-center mb-6">
                        <span id="film-genre"
                            class="px-3 py-1 bg-rose-100 text-rose-800 text-sm rounded-full mr-3 mb-2">Genre</span>
                        <div class="flex items-center mr-4 mb-2">
                            <i class="fas fa-clock text-rose-600 mr-2"></i>
                            <span id="film-duration" class="text-gray-700">Loading ...</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            <span class="text-gray-700">Loading ...</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Synopsis</h2>
                        <p id="film-description" class="text-gray-700 leading-relaxed">
                            Loading ...
                        </p>
                    </div>

                    <div class="flex flex-wrap">
                        <a href="#showtimes"
                            class="px-6 py-3 bg-rose-600 text-white rounded-lg hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 mr-3 mb-3 flex items-center">
                            <i class="fas fa-ticket-alt mr-2"></i> Book Tickets
                        </a>
                        <a href="#trailer"
                            class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 mb-3 flex items-center">
                            <i class="fas fa-play mr-2"></i> Watch Trailer
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trailer Section -->
        <div id="trailer" class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Trailer</h2>
            <div class="aspect-w-16 aspect-h-9">
                <div id="film-trailler" class="w-full rounded-lg bg-black h-0 pb-[56.25%] relative">
                    <!-- Placeholder for video - in a real implementation, this would be an iframe with the actual trailer -->

                </div>
            </div>
        </div>

        <!-- Showtimes Section -->
        <div id="showtimes" class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Sessions</h2>

            <!-- Showtimes Grid -->
            <div id="session-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <p class="text-gray-500">Loading...</p>
            </div>
        </div>
    </main>

    <div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-md p-6 w-96 relative">
            <button onclick="closeBookingModal()"
                class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">×</button>
            <h3 class="text-lg font-semibold mb-4">Book Session</h3>
            <form id="booking-form">
                <input type="hidden" name="session_id" id="booking-session-id">

                <label for="seat-type" class="block mb-2 text-sm font-medium">Seat Type:</label>
                <select id="seat-type" name="type" class="w-full border px-3 py-2 rounded-md mb-4" required>
                    <option value="solo">Solo</option>
                    <option value="couple">Couple</option>
                </select>

                <div id="solo-seat-group" class="mb-4">
                    <label for="seat" class="block mb-2 text-sm font-medium">Seat Number:</label>
                    <input type="number" id="seat" name="seat" min="1"
                        class="w-full border px-3 py-2 rounded-md" required>
                </div>

                <div id="couple-seat-group" class="mb-4 hidden">
                    <label class="block mb-2 text-sm font-medium">Seat Numbers (Couple):</label>
                    <div class="flex space-x-2">
                        <input type="number" id="seat1" name="seat1" min="1"
                            class="w-1/2 border px-3 py-2 rounded-md">
                        <input type="number" id="seat2" name="seat2" min="1"
                            class="w-1/2 border px-3 py-2 rounded-md">
                    </div>
                </div>

                <button type="submit" class="w-full bg-rose-600 text-white py-2 rounded-md hover:bg-rose-700">Confirm
                    Booking</button>
            </form>
        </div>
    </div>



    <script>
        const filmId = "{{ $filmId }}";

        document.addEventListener("DOMContentLoaded", function() {
            const token = localStorage.getItem("token");

            if (!token) {
                window.location.href = "/login";
                return;
            }

            fetch(`http://localhost:8000/api/film/${filmId}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    const film = response.film;

                    document.getElementById("film-title").textContent = film.title;
                    document.getElementById("film-image").src = `http://localhost:8000/storage/${film.image}`;
                    document.getElementById("film-description").textContent = film.description;
                    document.getElementById("film-genre").textContent = film.genre;
                    document.getElementById("film-duration").textContent = film.duration + " min";
                    const rawTrailerLink = film.trailer_url;
                    const embedLink = convertYouTubeToEmbed(rawTrailerLink);
                    console.log(embedLink);
                    if (embedLink) {
                        document.getElementById("film-trailler").innerHTML = `
        <iframe width="1425" height="800"
            src="${embedLink}" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" 
            allowfullscreen>
        </iframe>
    `;


                        const sessionContainer = document.getElementById("session-container");
                        sessionContainer.innerHTML = "";

                        if (film.session && film.session.length > 0) {
                            film.session.forEach(s => {
                                const sessionCard = `
  <div class="border rounded-lg p-4">
      <h3 class="font-semibold text-gray-900 mb-3">${s.type} - ${s.language}</h3>
      <div class="text-gray-700 text-sm mb-1"><strong>Start:</strong> ${formatDate(s.start_date)}</div>
      <div class="text-gray-700 text-sm mb-3"><strong>End:</strong> ${formatDate(s.end_date)}</div>
      <a href="" 
         class="book-session-btn inline-block px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700 text-sm" 
         data-session-id="${s.id}">
         Book This Session
      </a>
  </div>
`;
                                sessionContainer.innerHTML += sessionCard;
                            });

                            document.querySelectorAll(".book-session-btn").forEach(btn => {
                                btn.addEventListener("click", (e) => {
                                    e.preventDefault();
                                    const sessionId = btn.dataset.sessionId;
                                    openBookingModal(sessionId);
                                });
                            });
                        } else {
                            sessionContainer.innerHTML =
                                "<p class='text-gray-500'>No sessions available for this film.</p>";
                        }
                    } else {
                        document.getElementById("film-trailler").textContent = "Invalid trailer URL.";
                    }
                })
                .catch(error => {
                    console.error("Error fetching film:", error);
                });
        });

        function convertYouTubeToEmbed(url) {
            try {
                if (url.includes("youtu.be")) {
                    const videoId = url.split("/").pop().split("?")[0];
                    return `https://www.youtube.com/embed/${videoId}`;
                }

                if (url.includes("youtube.com/watch")) {
                    const urlObj = new URL(url);
                    const videoId = urlObj.searchParams.get("v");
                    return `https://www.youtube.com/embed/${videoId}`;
                }

                if (url.includes("youtube.com/embed")) {
                    return url;
                }

                return null;
            } catch (error) {
                console.error("Invalid URL:", error);
                return "Invalid URL";
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString();
        }

        function openBookingModal(sessionId) {
            document.getElementById("booking-session-id").value = sessionId;
            document.getElementById("booking-modal").classList.remove("hidden");
        }

        function closeBookingModal() {
            document.getElementById("booking-modal").classList.add("hidden");
        }

        document.getElementById("booking-form").addEventListener("submit", function(e) {
            e.preventDefault();

            const sessionId = document.getElementById("booking-session-id").value;
            const type = document.getElementById("seat-type").value;
            let seats = [];

            if (type === "solo") {
                const seat = parseInt(document.getElementById("seat").value);
                if (isNaN(seat)) {
                    alert("Please enter a valid seat number.");
                    return;
                }
                seats = [seat];
            } else if (type === "couple") {
                const seat1 = parseInt(document.getElementById("seat1").value);
                const seat2 = parseInt(document.getElementById("seat2").value);
                if (isNaN(seat1) || isNaN(seat2)) {
                    alert("Please enter two valid seat numbers.");
                    return;
                }
                seats = [seat1, seat2];
            }

            fetch("http://127.0.0.1:8000/api/reservations", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + localStorage.getItem("token")
                    },
                    body: JSON.stringify({
                        session_id: parseInt(sessionId),
                        type: type,
                        seats: seats
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log("Reservation successful:", data);
                    alert("Booking confirmed!");
                    closeBookingModal();
                })
                .catch(err => {
                    console.error("Booking failed:", err);
                    alert("Booking failed.");
                });
        });

        document.getElementById("seat-type").addEventListener("change", function() {
            const type = this.value;
            document.getElementById("solo-seat-group").classList.toggle("hidden", type === "couple");
            document.getElementById("couple-seat-group").classList.toggle("hidden", type === "solo");
        });
    </script>
</body>

</html>

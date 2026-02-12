let query = "Marvel";
let page = 1;
let loading = false;
let hasMore = true;
let currentType = "";
let currentYear = "";

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    if (searchInput) {
        query = searchInput.value || "Marvel";
    }
    fetchMovies();
});

function searchMovies() {
    query = document.getElementById("search").value || "Marvel";
    currentType = document.getElementById("filter-type").value;
    currentYear = document.getElementById("filter-year").value;

    page = 1;
    hasMore = true;
    fetchMovies(false);
}

function fetchMovies(append = false) {
    if (loading || !hasMore) return;
    loading = true;
    document.getElementById("loading").classList.remove("hidden");

    let url = `https://www.omdbapi.com/?apikey=${window.aldmicMovie.apiKey}&s=${query}&page=${page}`;
    if (currentType !== "") url += `&type=${currentType}`;
    if (currentYear !== "") url += `&y=${currentYear}`;

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            const list = document.getElementById("movie-list");
            if (!append) list.innerHTML = "";

            if (data.Response === "True") {
                data.Search.forEach((movie) => {
                    list.innerHTML += renderMovieCard(movie);
                });
                lucide.createIcons();
                if (data.Search.length < 10) hasMore = false;
            } else {
                if (!append)
                    list.innerHTML = `<p class="col-span-full text-center text-gray-500">${window.aldmicMovie.msg.notFound}</p>`;
                hasMore = false;
            }
            loading = false;
            document.getElementById("loading").classList.add("hidden");
        })
        .catch((err) => {
            console.error(err);
            loading = false;
        });
}

function renderMovieCard(movie) {
    const placeholder = "https://placehold.co/400x600?text=No+Poster";
    const posterUrl =
        movie.Poster && movie.Poster !== "N/A" ? movie.Poster : placeholder;
    const isAlreadyFav = window.aldmicMovie.favoriteIds.includes(movie.imdbID);

    const favButton = isAlreadyFav
        ? `<button class="w-full bg-slate-200 text-slate-500 py-2 rounded font-bold cursor-not-allowed text-[10px] md:text-xs flex items-center justify-center gap-1 md:gap-2" disabled>
        <i data-lucide="check" class="w-3 h-3 md:w-4 h-4"></i> ${window.aldmicMovie.msg.favorited}
       </button>`
        : `<button onclick="addFromList(this, '${movie.imdbID}', '${movie.Title.replace(/'/g, "\\'")}')" 
            class="w-full border border-slate-500 text-slate-500 py-2 rounded hover:bg-slate-500 hover:text-white font-bold text-[10px] md:text-xs transition flex items-center justify-center gap-1 md:gap-2">
        <i data-lucide="plus" class="w-3 h-3 md:w-4 h-4"></i> ${window.aldmicMovie.msg.addFavorite}
       </button>`;

    return `
        <div class="relative bg-slate-50 rounded-lg overflow-hidden shadow-lg border border-slate-200 flex flex-col h-full">
            <div class="absolute top-2 left-2 z-20">
                <span class="bg-black/60 backdrop-blur-md text-white text-[9px] md:text-[10px] uppercase px-2 py-1 rounded font-bold tracking-wider">
                    ${movie.Type}
                </span>
            </div>
            <a href="/movies/${movie.imdbID}" class="relative block w-full bg-slate-50 flex items-center justify-center overflow-hidden" style="aspect-ratio: 2/3;">
                <img src="${posterUrl}" class="w-full h-full object-contain hover:scale-105 transition duration-300" onerror="this.onerror=null;this.src='${placeholder}';">
            </a>
            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <h3 class="font-bold text-gray-800 text-xs md:text-sm line-clamp-2 h-8 md:h-10 leading-tight mb-1">
                    <a href="/movies/${movie.imdbID}" class="hover:underline">${movie.Title}</a>
                </h3>
                <p class="text-gray-500 text-[10px] md:text-xs mb-3">${movie.Year}</p>
                <div class="mt-auto">${favButton}</div>
            </div>
        </div>`;
}

function addFromList(btnElement, id) {
    const originalContent = btnElement.innerHTML;
    btnElement.disabled = true;
    btnElement.innerHTML = `<span class="animate-pulse">...</span>`;

    fetch(window.aldmicMovie.urlAddFavorite, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.aldmicMovie.csrfToken,
            Accept: "application/json",
        },
        body: JSON.stringify({
            imdbID: id,
        }),
    })
        .then((response) => response.json())
        .then((res) => {
            if (res.status === "success") {
                alert(window.aldmicMovie.msg.success);
                btnElement.disabled = true;
                btnElement.className =
                    "w-full bg-slate-200 text-slate-500 py-2 rounded-md font-bold cursor-not-allowed text-[10px] md:text-xs";
                btnElement.innerHTML = `<span>${window.aldmicMovie.msg.favorited}</span>`;

                if (window.aldmicMovie.favoriteIds) {
                    window.aldmicMovie.favoriteIds.push(id);
                }
            } else {
                alert(res.message || window.aldmicMovie.msg.fail);
                btnElement.disabled = false;
                btnElement.innerHTML = originalContent;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert(
                "Gagal memproses data. Silakan cek koneksi atau login status.",
            );
            btnElement.disabled = false;
            btnElement.innerHTML = originalContent;
        });
}

fetchMovies();

window.addEventListener("scroll", () => {
    if (
        window.innerHeight + window.scrollY >=
        document.body.offsetHeight - 500
    ) {
        if (!loading && hasMore) {
            page++;
            fetchMovies(true);
        }
    }
});

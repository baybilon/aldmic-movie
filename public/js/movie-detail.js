function addToFavorite() {
    const data = {
        imdbID: window.aldmicMovie.imdbID,
    };

    fetch(window.aldmicMovie.urlAddFavorite, {
        method: "POST",

        headers: {
            "Content-Type": "application/json",

            "X-CSRF-TOKEN": window.aldmicMovie.csrfToken,

            Accept: "application/json",
        },

        body: JSON.stringify(data),
    })
        .then((response) => {
            if (!response.ok) throw new Error("Network response was not ok");

            return response.json();
        })

        .then((res) => {
            if (res.status === "success") {
                alert(window.aldmicMovie.msg.success);

                location.reload();
            } else {
                alert(window.aldmicMovie.msg.fail);
            }
        })

        .catch((error) => {
            console.error("Error:", error);

            alert(window.aldmicMovie.msg.authentication);
        });
}

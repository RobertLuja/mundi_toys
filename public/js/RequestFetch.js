function sendData(url, payload) {
    return fetch(url, {
        method: "POST",
        mode: "same-origin",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': document.getElementById("csrf").textContent
        },
        body: JSON.stringify( payload ),
    });
}
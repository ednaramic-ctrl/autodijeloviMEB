
const app = document.getElementById("app");

async function ucitajStranicu(stranica) {
    try {
        const odgovor = await fetch("./views/" + stranica + ".html");

        if (!odgovor.ok) {
            app.innerHTML = "<p>Provjeri naziv HTML datoteke u folderu views.</p>";
            return;
        }

        app.innerHTML = await odgovor.text();
    } catch (greska) {
        app.innerHTML = "<p>Greška pri učitavanju.</p>";
    }
}

document.addEventListener("click", function(event) {
    const link = event.target.closest('a[href^="#"]');

    if (link) {
        event.preventDefault();

        const stranica = link.getAttribute("href").substring(1);

        history.pushState(null, "", "#" + stranica);
        ucitajStranicu(stranica);
    }
});

window.addEventListener("popstate", function() {
    ucitajStranicu(location.hash.substring(1) || "home");
});

ucitajStranicu(location.hash.substring(1) || "home");


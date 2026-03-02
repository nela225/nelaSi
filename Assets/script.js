document.addEventListener("DOMContentLoaded", () => {

  console.log("Nela CRUD loaded");

  // Highlight input kad klikneš
  document.querySelectorAll("input").forEach(input => {
    input.addEventListener("focus", () => {
      input.style.border = "2px solid #00d4ff";
    });

    input.addEventListener("blur", () => {
      input.style.border = "none";
    });
  });

  // Potvrda za delete
  document.querySelectorAll("a[href*='delete']").forEach(btn => {
    btn.addEventListener("click", e => {
      if (!confirm("Sigurno želiš obrisati korisnika?")) {
        e.preventDefault();
      }
    });
  });

});
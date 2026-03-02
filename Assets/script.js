document.addEventListener("DOMContentLoaded", () => {

  console.log("Nela CRUD loaded");

  document.querySelectorAll("input").forEach(input => {
    input.addEventListener("focus", () => {
      input.style.border = "2px solid #00d4ff";
    });

    input.addEventListener("blur", () => {
      input.style.border = "none";
    });
  });

  document.querySelectorAll("a[href*='delete']").forEach(btn => {
    btn.addEventListener("click", e => {
      if (!confirm("Sigurno želiš obrisati korisnika?")) {
        e.preventDefault();
      }
    });
  });


});

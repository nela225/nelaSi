<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management – php-mysql-backend</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="topbar">
    <div class="topbar-brand">⚡ php-mysql-backend</div>
    <div class="topbar-badge">Softver inženjering · 2025/2026</div>
</div>

<div class="container">

    <div class="card" style="margin-bottom:24px">
        <div class="card-header">
            <div class="card-title">
                <div class="icon">➕</div>
                Dodaj novog korisnika
            </div>
        </div>
        <div class="card-body">
            <form id="createForm" novalidate>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="ime">Ime</label>
                        <input type="text" id="ime" name="ime" placeholder="Npr. Hana" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="prezime">Prezime</label>
                        <input type="text" id="prezime" name="prezime" placeholder="Npr. Kovač" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="email">Email adresa</label>
                        <input type="email" id="email" name="email" placeholder="hana@email.com" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary" style="width:100%">➕ Dodaj korisnika</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="icon">👥</div>
                Svi korisnici
            </div>
            <div class="search-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchInput" placeholder="Pretraži korisnike...">
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Korisnik</th>
                        <th>Datum registracije</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody"></tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            <span class="pagination-info" id="paginationInfo">Učitavanje...</span>
            <div class="pagination-btns" id="paginationBtns"></div>
        </div>
    </div>

</div>

<div class="modal-overlay" id="editModalOverlay">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">✏️ Uredi korisnika</div>
            <button class="modal-close" onclick="closeEditModal()">✕</button>
        </div>
        <form id="editForm" novalidate>
            <div class="modal-body">
                <div class="modal-form-group">
                    <label>Ime</label>
                    <input type="text" id="editIme" name="ime" placeholder="Ime" autocomplete="off">
                </div>
                <div class="modal-form-group">
                    <label>Prezime</label>
                    <input type="text" id="editPrezime" name="prezime" placeholder="Prezime" autocomplete="off">
                </div>
                <div class="modal-form-group">
                    <label>Email adresa</label>
                    <input type="email" id="editEmail" name="email" placeholder="email@example.com" autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Odustani</button>
                <button type="submit" class="btn btn-primary">💾 Sačuvaj promjene</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="confirmModalOverlay">
    <div class="modal">
        <div class="modal-body" style="padding-top:28px;text-align:center">
            <div class="confirm-icon">🗑️</div>
            <div class="confirm-title">Obriši korisnika?</div>
            <div class="confirm-msg">
                Da li ste sigurni da želite obrisati korisnika <strong id="deleteUserName"></strong>?
                Ova akcija se ne može poništiti.
            </div>
        </div>
        <div class="modal-footer" style="justify-content:center">
            <button type="button" class="btn btn-secondary" onclick="closeConfirmModal()">Odustani</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn" onclick="doDelete()">🗑️ Da, obriši</button>
        </div>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script src="assets/script.js"></script>
</body>
</html>
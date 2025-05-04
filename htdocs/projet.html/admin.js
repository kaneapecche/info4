document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".action-btn").forEach((button) => {
        button.addEventListener("click", () => {
            // Désactive le bouton
            button.disabled = true;
            button.classList.add("disabled");

            const icon = button.querySelector("i");
            const originalIcon = icon.className;
            icon.className = "fa-solid fa-spinner fa-spin";

            // Trouve le <td> du rôle correspondant
            const email = button.dataset.email;
            const roleCell = document.querySelector(`td.user-role[data-user-id='${email}']`);

            // Valeur actuelle
            const currentRole = roleCell.textContent.trim();
            const newRole = currentRole === "Admin" ? "User" : "Admin";

            // Simule la mise à jour (3s)
            setTimeout(() => {
                // Change la valeur simulée du rôle
                roleCell.textContent = newRole;

                // Réactive le bouton
                button.disabled = false;
                button.classList.remove("disabled");
                icon.className = originalIcon;

                // Message visuel du fait que la similation a été réussi  
                alert("Rôle modifié (simulation uniquement) !");
            }, 3000);
        });
    });
});

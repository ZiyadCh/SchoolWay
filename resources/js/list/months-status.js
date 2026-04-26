import token from "../auth/token.js";

document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("paymentsTableBody");
    const template = document.getElementById("paymentRowTemplate");
    const studentNameDisp = document.getElementById("studentName");
    const confirmBtn = document.getElementById("confirmBtn");

    const inscriptionId = window.location.pathname.split("/").pop();

    if (!inscriptionId) {
        return;
    }

    const fetchPayments = async () => {
        try {
            const response = await fetch(
                `/api/v1/paiments?inscription_id=${inscriptionId}`,
            );
            if (!response.ok) throw new Error("Erreur réseau");

            const result = await response.json();
            const payments = result.data;

            tableBody.innerHTML = "";

            if (payments.length > 0) {
                const studentData = payments[0].inscription.student.user;
                studentNameDisp.textContent =
                    studentData.prenom + " " + studentData.nom;

                renderTable(payments);
            } else {
                tableBody.innerHTML = `<tr><td colspan="3" class="px-8 py-12 text-center text-gray-500">Aucun historique trouvé.</td></tr>`;
            }
        } catch (error) {
            console.error("Erreur fetch:", error);
            tableBody.innerHTML = `<tr><td colspan="3" class="px-8 py-12 text-center text-red-400">Erreur lors du chargement des données.</td></tr>`;
        }
    };

    const renderTable = (payments) => {
        payments.forEach((payment) => {
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector("tr");
            const checkbox = clone.querySelector(".payment-checkbox");
            const isPaid = payment.etatPaiement === true;

            row.dataset.paymentId = payment.id;
            row.dataset.paid = isPaid;

            checkbox.value = payment.id;
            if (isPaid) {
                checkbox.checked = true;
            }

            ///////////////////////////////////
            //turning the date into readabel months names in french
            const dateObj = new Date(payment.mois);

            const monthName = new Intl.DateTimeFormat("fr-FR", {
                month: "long",
                year: "numeric",
            }).format(dateObj);
            clone.querySelector(".month-display").textContent =
                monthName.toUpperCase();

            const badge = clone.querySelector(".status-badge");
            if (isPaid) {
                badge.textContent = "Payé";
                badge.className =
                    "inline-block text-[10px] font-black px-4 py-2 rounded-full border text-emerald-400 bg-emerald-400/10 border-emerald-400/20";
            } else {
                badge.textContent = "En attente";
                badge.className =
                    "inline-block text-[10px] font-black px-4 py-2 rounded-full border text-red-400 bg-red-400/10 border-red-400/20";
            }

            tableBody.appendChild(clone);
        });

        setupCheckboxListeners();
    };

    const setupCheckboxListeners = () => {
        const checkboxes = document.querySelectorAll(
            ".payment-checkbox:not(:disabled)",
        );

        checkboxes.forEach((cb) => {
            cb.addEventListener("change", () => {
                const anyChecked = Array.from(checkboxes).some(
                    (c) => c.checked,
                );
                confirmBtn.disabled = !anyChecked;
            });
        });
    };

    fetchPayments();
});

import token from "../auth/token.js";

const selectedPayments = [];

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("paymentForm");
    const confirmBtn = document.getElementById("confirmBtn");

    document.addEventListener("change", (e) => {
        if (!e.target.classList.contains("payment-checkbox")) return;

        const id = Number(e.target.value);
        selectedPayments.push(id);

        confirmBtn.disabled = selectedPayments.length === 0;
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (selectedPayments.length === 0) return;

        try {
            const response = await fetch("/api/v1/paiments/mark-payment", {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    ids: selectedPayments,
                }),
            });

            const result = await response.json();
            console.log(result);
            window.location.href = document.referrer;

            if (!response.ok) throw new Error(result.message);
        } catch (error) {
            console.error(error);
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach(function (form) {
        // Skip forms that have data-ajax="true"
        if (form.dataset.ajax === "true") return;

        form.addEventListener("submit", function (event) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fa-solid fa-rotate-right fa-spin"></i> ' + submitButton.innerHTML;
            }
        });
    });
});

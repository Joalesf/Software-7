const themeForm = document.querySelector('[data-theme-form]');

if (themeForm) {
    const options = themeForm.querySelectorAll('input[name="theme"]');

    options.forEach((option) => {
        option.addEventListener('change', () => {
            document.documentElement.dataset.theme = option.value;
        });
    });
}

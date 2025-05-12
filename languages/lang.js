
const langSelect = document.querySelector('#lang-select'); // nút chọn ngôn ngữ
const defaultLang = localStorage.getItem('lang') || 'vi';

function loadLanguage(lang) {
    fetch(`./languages/${lang}.json`)
        .then(res => res.json())
        .then(data => {
            document.querySelectorAll("[data-i18n]").forEach(el => {
                const key = el.getAttribute("data-i18n");
                if (data[key]) el.textContent = data[key];
            });
            localStorage.setItem('lang', lang);
        })
}

langSelect.addEventListener('change', function () {
    loadLanguage(this.value);
});

document.addEventListener('DOMContentLoaded', () => {
    langSelect.value = defaultLang;
    loadLanguage(defaultLang);
});

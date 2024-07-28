const PAGE_SETTINGS_SELECTOR = '.page-settings';
const pageSettings = () => {
    // use form to work with "Enter" button
    const form = document.querySelector(PAGE_SETTINGS_SELECTOR)?.querySelector('form');

    const handleSubmit = (e) => {
        e.preventDefault();
        const pagination = form.querySelector('input[name="pagination"]')?.value;
        const parsedUrl = new URL(window.location.href);
        const params = new URLSearchParams(parsedUrl.search);

        // prevent adding pagination  multiple time to query 
        if (params.has('pagination'))
            params.delete('pagination');

        params.set('pagination', pagination);

        window.location.href  = `${parsedUrl.origin}${parsedUrl.pathname}?${params.toString()}`
    }
    form?.addEventListener('submit', handleSubmit)
}
pageSettings();

export default pageSettings
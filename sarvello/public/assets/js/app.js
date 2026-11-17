/*
 * File:    app.js
 * Module:  Shared
 * Date:    2026-11-17
 * Purpose: Small page behaviours shared across the site.
 */

// Ask before any button marked data-confirm deletes or cancels something.
document.addEventListener('click', function (event) {
    const button = event.target.closest('[data-confirm]');
    if (button && !window.confirm(button.dataset.confirm)) {
        event.preventDefault();
    }
});

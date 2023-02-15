window.addEventListener('load', () => {
    // confirm dialog to log out
    const confirmDialog = document.querySelector('.black-container');
    const logoutBtn = document.querySelector('.fa-arrow-right-from-bracket');
    const cancelBtn = document.querySelector('.btn-cancel');

    logoutBtn.addEventListener('click', () => {
        confirmDialog.style.display = 'flex';
    })

    cancelBtn.addEventListener('click', () => {
        confirmDialog.style.display = 'none';
    })

});
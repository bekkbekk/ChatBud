window.addEventListener('load', () => {
    // hamburger
    const hamburger = document.querySelector('.hamburger');
    const mobileNavCont = document.querySelector('.mobile-nav-container');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('is-active');
        mobileNavCont.classList.toggle('is-active');
    });

    // confirm dialog to log out
    const confirmDialog = document.querySelector('.black-container');
    const logoutBtn = document.querySelector('.sign-out');
    const cancelBtn = document.querySelector('.btn-cancel');

    logoutBtn.addEventListener('click', () => {
        confirmDialog.style.display = 'flex';
        console.log("klujshflkjhsdf")
    })

    cancelBtn.addEventListener('click', () => {
        confirmDialog.style.display = 'none';
    })

});
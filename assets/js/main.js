///////////////////////////////////////////
// Creado por CtrlProgrammer
// Copyright (C) Derechos de autor Hewks.net
///////////////////////////////////////////

window.onload = function () {
    var loader = document.getElementById('bs-total-page-loader');
    loader.style.visibility = 'hidden';
    loader.style.opacity = '0';
}

///////////////////////////////////////////
// Navigation Bar
////////////////////////////////////////

// Sidebar toggler
document.getElementById('sidebarToggler').addEventListener('click', function () {

    var sidebar = document.getElementById('primarySidebar');

    if (sidebar.classList.contains('active-sidebar')) {
        sidebar.classList.remove('active-sidebar');
    } else {
        sidebar.classList.add('active-sidebar');
    }

});

function removeLoader() {
    document.getElementById('hw-chart-loader').classList.remove('hw-active-loader');
}



const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('main-content');
const table = document.querySelector('.table-container');
const tabel = document.querySelector('.tabel');
const topbar = document.getElementById('atas');

function toggleSidebar() {
    sidebar.classList.toggle('collapsed');
    if (sidebar.classList.contains('collapsed')) {
        topbar.style.marginLeft = '80px';
        mainContent.style.marginLeft = '80px';
        table.style.width = '1150px';
        tabel.style.maxWidth = '1150px';
    } else {
        topbar.style.marginLeft = '250px';
        mainContent.style.marginLeft = '250px';
        table.style.width = '980px';
        tabel.style.maxWidth = '980px';
    }
}
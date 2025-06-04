'use strict'

function showInfo(){
    const info = document.getElementById('info');
    if (info.style.display === 'none' || info.style.display === '') {
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }
}

function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}
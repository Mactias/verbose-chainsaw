function resizeEvent() {
    if (window.screen.width < 940 ) {
        document.getElementById('mm_tt_mobile').style.display = 'block';
        document.getElementById('mm_tt').style.display = 'none';
    } else {
        document.getElementById('mm_tt_mobile').style.display = 'none';
        document.getElementById('mm_tt').style.display = 'block';
    }
}
window.addEventListener('resize', resizeEvent); 
window.addEventListener('load', resizeEvent);

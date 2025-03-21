function checkEnvironment(val) {
    var element = document.getElementById('environment_text_input');
    if (val == 'other') {
        element.classList.remove('d-none');
    } else {
        element.classList.add('d-none');
    }
}

function showDatabaseSettings() {
    document.getElementById('tab2').checked = true;
}

function showApplicationSettings() {
    document.getElementById('tab3').checked = true;
}

var x = document.getElementById('error_alert');
var y = document.getElementById('close_alert');
if (x || y) {
    y.onclick = function() {
        x.style.display = "none";
    };
}

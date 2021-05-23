function uploadContent() {
    if (content !== textarea.value) {
        var temp = textarea.value;
        var request = new XMLHttpRequest();
        request.open('POST', window.location.href, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.onload = function() {
            if (request.readyState === 4) {
                content = temp;
                setTimeout(uploadContent, 1000);
            }
        }

        request.onerror = function() {
            setTimeout(uploadContent, 1000);
        }

        request.send('text=' + encodeURIComponent(temp));
        printable.removeChild(printable.firstChild);
        printable.appendChild(document.createTextNode(temp));
    } else {
        setTimeout(uploadContent, 1000);
    }
}

var textarea = document.getElementById('content');
var printable = document.getElementById('printable');
var content = textarea.value;

printable.appendChild(document.createTextNode(content));

textarea.onkeydown = function(e) {
    if (e.keyCode === 9 || e.which === 9) {
        e.preventDefault();
        var s = this.selectionStart;
        this.value = this.value.substring(0, this.selectionStart) + '\t' + this.value.substring(this.selectionEnd);
        this.selectionEnd = s + 1;
    }
}

textarea.focus();
uploadContent();

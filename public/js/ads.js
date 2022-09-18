function remove(className) {
    elements = document.getElementsByClassName(className);
    elements[0].remove();
    for (var i = 0; i < elements.length; i++) {
        elements.item(i).remove();
    }
}

elements = document.getElementsByClassName('ads');
for (var i = 0; i < elements.length; i++) {
    elements.item(i).classList.toggle('d-none');
}


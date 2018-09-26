document.addEventListener('DOMContentLoaded', function () {
    appendShowAll();
    expandAllUIBehavior();
});

function appendShowAll() {
    var treeElement = document.getElementById("fullwidth-treeview-row");

    var element = document.createElement("input");
    //Assign different attributes to the element.
    element.id = 'uml-expand-all';
    element.type = 'button';
    element.value = 'Expand all';

    if (treeElement){
        treeElement.appendChild(element);
    }
};

function expandAllUIBehavior() {
    var $ = jQuery;
    $('#uml-expand-all').click(function () {
        console.log('clicked');

        $('#fullwidth-treeview').jstree('open_all');
    });
};
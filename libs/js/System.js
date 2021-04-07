/**
 * All Global functionality goes here
 *  
 */

function isEmpty(str) {
    if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g, "") === "") {
        return true;
    } else {
        return false;
    }
}

function getToken() {
    var token;
    var body;

    body = document.getElementsByTagName('body');
    body = $(body);

    var token = body.attr('data-token');

    return token;
}

function assign_id_to_selected_element(id, parent) {
    parent.find(".item_select").attr('data-uuid', id);
}
const root = "http://manage.hilltopwinesandspirit.co.ke";
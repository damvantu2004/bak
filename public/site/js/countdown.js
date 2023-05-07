

function increase(cart_id) {
    var input_id = cart_id + "quantity";
    var inputQuantityElement = document.getElementById(input_id);
    var newQuantity = parseInt(inputQuantityElement.value) + 1;
    inputQuantityElement.value = newQuantity;

}

function decrease(cart_id) {
    var input_id = cart_id + "quantity";
    var inputQuantityElement = document.getElementById(input_id);
    if (inputQuantityElement.value > 1) {
        var newQuantity = parseInt(inputQuantityElement.value) - 1;
        inputQuantityElement.value = newQuantity;
    }

}

function increase2(cart_id) {
    var input_id = cart_id + "quantity";
    var inputQuantityElement = document.getElementById(input_id);
    var newQuantity = parseInt(inputQuantityElement.value) + 1;
    inputQuantityElement.value = newQuantity;
    document.getElementById('update-quantity-form' + cart_id).submit();
}

function decrease2(cart_id) {
    var input_id = cart_id + "quantity";
    var inputQuantityElement = document.getElementById(input_id);
    if (inputQuantityElement.value > 1) {
        var newQuantity = parseInt(inputQuantityElement.value) - 1;
        inputQuantityElement.value = newQuantity;
    }
    document.getElementById('update-quantity-form' + cart_id).submit();
}


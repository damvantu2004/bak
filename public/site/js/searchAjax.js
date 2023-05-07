/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function showSearchBar() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function showSearchResult(str) {
    str = str.trim();

    // locate element
    var x = document.getElementById("searched-items");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("searched-items").innerHTML = this.responseText;
            // var option = document.createElement("option");
            // option.text = "Kiwi " + str;
            // x.add(option);

        }
    }
    // xmlhttp.open("GET", "?controller=product&action=search&product=" + str, true);
    xmlhttp.open("GET", "?controller=product&action=ajaxSearch&product=" + str, true);
    xmlhttp.send();
}
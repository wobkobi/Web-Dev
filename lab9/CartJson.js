var xHRObject = false;
if (window.XMLHttpRequest) {
    xHRObject = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
    xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}


function getData() {
    if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
        var spantag = document.getElementById("cart");
        var serverResponse;
        if (xHRObject.responseText != "") serverResponse = JSON.parse(xHRObject.responseText);
        else serverResponse = null;

        if (serverResponse != null) {
            var cartItems = serverResponse.cart;
            var totalCost = serverResponse.totalCost;
            spantag.innerHTML = "";

            for (var key in cartItems) {
                var item = cartItems[key];
                spantag.innerHTML += "Book: " + key;
                spantag.innerHTML += " ISBN: " + item.isbn;
                spantag.innerHTML += " Quantity: " + item.quantity;
                spantag.innerHTML += " Price: " + item.price + "<br>";
            }

            spantag.innerHTML += "Total Cost: $" + totalCost;
        } else {
            spantag.innerHTML = "";
        }
    }
}

function AddRemoveItem(action) {
    var book = document.getElementById("book").innerHTML;
    var isbn = document.getElementById("ISBN").innerHTML;
    var price = document.getElementById("price").innerHTML;

    if (action == "Add" || action == "Remove") {
        xHRObject.open("GET", "test.php?action=" + action + "&book=" + encodeURIComponent(book) + "&isbn=" + encodeURIComponent(isbn) + "&price=" + encodeURIComponent(price) + "&value=" + Number(new Date), true);
    }

    xHRObject.onreadystatechange = getData;
    xHRObject.send(null);
}
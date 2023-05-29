var xHRObject = false;
if (window.XMLHttpRequest) {
    xHRObject = new XMLHttpRequest();
} else if (window.ActiveXObject) {
    xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData() {
    if (xHRObject.readyState === 4 && xHRObject.status === 200) {
        var spantag = document.getElementById("cart");
        var serverResponse;
        if (xHRObject.responseText !== "") {
            serverResponse = JSON.parse(xHRObject.responseText);
        } else {
            serverResponse = null;
        }

        if (serverResponse !== null) {
            var cartData = serverResponse.cart;
            var totalCost = serverResponse.totalCost;

            spantag.innerHTML = "";

            if (Object.keys(cartData).length === 0) {
                spantag.innerHTML = "";
            } else {
                for (var key in cartData) {
                    if (cartData.hasOwnProperty(key)) {
                        spantag.innerHTML += " " + key + " (ISBN: " + cartData[key].ISBN + ")";
                        spantag.innerHTML += " Quantity: " + cartData[key].quantity;
                        spantag.innerHTML += " Price: $" + cartData[key].price;
                        spantag.innerHTML += " <a href='#' onclick='AddRemoveItem(\"Remove\", \"" + key + "\");'>Remove Item</a>";
                        spantag.innerHTML += "<br>";
                    }
                }
                spantag.innerHTML += "<br>Total Cost: $" + totalCost.toFixed(2);
            }
        } else {
            spantag.innerHTML = "";
        }
    }
}

function AddRemoveItem(action, book) {
    var bookElement = document.getElementById("book");
    var ISBNElement = document.getElementById("ISBN");
    var priceElement = document.getElementById("price");

    var book = bookElement.innerHTML;
    var ISBN = ISBNElement.innerHTML;
    var price = parseFloat(priceElement.innerHTML.replace("$", ""));

    var url = "test.php?action=" + action + "&book=" + encodeURIComponent(book) +
        "&ISBN=" + ISBN + "&price=" + price + "&value=" + Number(new Date());

    xHRObject.open("GET", url, true);
    xHRObject.onreadystatechange = getData;
    xHRObject.send(null);
}

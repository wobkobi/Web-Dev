var xHRObject = false;
if (window.XMLHttpRequest)
{
xHRObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}


function getData()
{
    if ((xHRObject.readyState == 4) &&(xHRObject.status == 200))
    {
        // var obj = JSON.parse('{ "name":"John", "age":30, "city":"New York"}'); 
		
		var spantag = document.getElementById("cart");
		
		var serverResponse;
		if (xHRObject.responseText!="") serverResponse= JSON.parse(xHRObject.responseText);
		else serverResponse=null;
		
		// alert(keys[0]);
		// alert(serverResponse[keys[0]]);
		
		
		if (serverResponse != null){
			
			var keys = Object.keys(serverResponse);
			spantag.innerHTML = "";
            
			
            if (window.ActiveXObject)
            {
                spantag.innerHTML += " " +keys[0];
                spantag.innerHTML += " " + serverResponse[keys[0]] + " " + "<a href='#' onclick='AddRemoveItem(\"Remove\");'>Remove Item</a>";
            }
            else
            {
                spantag.innerHTML += " " +keys[0];
                spantag.innerHTML += " " + serverResponse[keys[0]] + " " + "<a href='#' onclick='AddRemoveItem(\"Remove\");'>Remove Item</a>";
            }
        
        }
        else{  spantag.innerHTML = ""; }
		
		
		
		/*

        var spantag = document.getElementById("cart");

        if (serverResponse != null){
            var header = serverResponse.getElementsByTagName("book");
            spantag.innerHTML = "";
            for (i=0; i<header.length; i++)
            {
           
            if (window.ActiveXObject)
            {
                spantag.innerHTML += " " +header[0].firstChild.text;
                spantag.innerHTML += " " + header[0].lastChild.text + " " + "<a href='#' onclick='AddRemoveItem(\"Remove\");'>Remove Item</a>";
            }
            else
            {
                spantag.innerHTML += " " +header[0].firstChild.textContent;
                spantag.innerHTML += " " + header[0].lastChild.textContent + " " + "<a href='#' onclick='AddRemoveItem(\"Remove\");'>Remove Item</a>";
            }
            }
        }
        else{  spantag.innerHTML = ""; }
*/
    }
}

function AddRemoveItem(action)
{
          var book  = document.getElementById("book").innerHTML;
           
          if(action=="Add")
          {
            //xHRObject.open("GET", "ManageCartJson.php?action=" + action + "&book=" + encodeURIComponent(book) + "&value=" + Number(new Date), true);
			            xHRObject.open("GET", "test.php?action=" + action + "&book=" + encodeURIComponent(book) + "&value=" + Number(new Date), true);
          }
          else
          {
           xHRObject.open("GET", "test.php?action=" + action + "&book=" + encodeURIComponent(book) + "&value="  + Number(new Date), true);
          }

          xHRObject.onreadystatechange = getData;
          xHRObject.send(null);   
}




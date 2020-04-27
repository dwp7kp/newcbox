DEBUG = 0;

function makeAjaxCall(location) {

    // 2. Create an instance of an XMLHttpRequest object
    xhr = GetXmlHttpObject();
    if (xhr == null) {
        alert("Your browser does not support XMLHTTP!");
        return;
    }

    // 3. specify a backend handler (URL to the backend)
    var backend_url = "playlist-dp.php" // relative path
    // abosule path needs http://localhost/.../...

    // 4. Assume we are going to send a GET request,
    //    use url rewriting to pass information the backend needs to process the request
    backend_url += "?first=" + first + "&middle=" + middle + "&last=" + last;
    var data_tosend = "StringSoFar=" + first + middle + last;

    // 5. Configure the XMLHttpRequest instance.
    //    Register the callback function.
    //    Assume the callback function is named showHint(),
    //    don't forget to write code for the callback function at the bottom
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // 4 means complete
            if (xhr.status === 200) { // OK
                var res = xhr.responseText;
                // What we want to do
                if (DEBUG) console.log("respose: ", res);
                //confirm(res);
            } else {
                // handle error
                console.log("hxr failed");
            }
        } else {
            // not done yet (3 means still doing, 2 request recieved, 1 connection established)
            if (DEBUG) console.log("xhr still in progress", xhr.readyState);
        }
    }

    // 8. Once the response is back the from the backend,
    //    the callback function is called to update the screen
    //    (this will be handled by the configuration above)

    // 6. Make an asynchronous request
    xhr.open('GET', backend_url, true); // true means it will be async request
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // 7. The request is sent to the server
    //xhr.send(null);
    xhr.send(data_tosend);

}

// 1. Add event listener to the input boxes.
//    Call makeAjaxCall() when the event happens
document.getElementById("location").addEventListener("click", function () {
    var location = document.getElementById("location").value;

    // call the function to send asynch request
    makeAjaxCall(location);
});

// The callback function processes the response from the server
function confirm(str) {
    
}

function GetXmlHttpObject() {
    // Create an XMLHttpRequest object
    if (window.XMLHttpRequest) {  // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }
    if (window.ActiveXObject) { // code for IE6, IE5
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function httpAsync(type,theUrl, callback)
{
var xmlHttp = new XMLHttpRequest();
xmlHttp.onreadystatechange = function() {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
        callback(xmlHttp.responseText);
}
xmlHttp.open(type, theUrl, true); // true for asynchronous
xmlHttp.send(null);
 }

 function httpg(type,theUrl, callback)
 {
 var xmlHttp = new XMLHttpRequest();
 xmlHttp.onreadystatechange = function() {
     if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
         callback(xmlHttp.responseText);
 }
 xmlHttp.open(type, theUrl, false); // true for asynchronous
 xmlHttp.send(null);
  }

function get(postdata,wait,waittext,response,url,method)
{
var ajaxHTTP;
function ajax_do()
{

ajaxHTTP=GetXmlHttpObject();

if (ajaxHTTP==null)
  {
  alert ("AJAX does not work your browser!");
  return;
  }
else {
			if(method=="GET")
			{
			ajaxHTTP.onreadystatechange=ajaxHTTPSC;
			url=url+postdata;
			ajaxHTTP.open("GET",url,true);
			ajaxHTTP.send(null);
			}
			
  			else if(method=="POST")
			{
			ajaxHTTP.onreadystatechange=ajaxHTTPSC;
			ajaxHTTP.open("POST",url,true);
			ajaxHTTP.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			ajaxHTTP.send(postdata);
			}

	}

}

function ajaxHTTPSC()
{

	if (ajaxHTTP.readyState==4)
	{
	document.getElementById(wait).innerHTML="";
	document.getElementById(response).innerHTML=ajaxHTTP.responseText;
	}
	if (ajaxHTTP.readyState!=4)
	{
	
		document.getElementById(wait).innerHTML="<span>"+ waittext+"</span>";

	}

}
	ajax_do();
}
function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
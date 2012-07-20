function cssmenuhover()
{
	if(!document.getElementById("menu"))
		return;
	var lis = document.getElementById("menu").getElementsByTagName("LI");
	for (var i=0; i<lis.length; i++)
	{
		if (lis[i].className != "disabled")
		{
			lis[i].onmouseover = function(){this.className += " hover";}
			lis[i].onmouseout = function() {this.className = this.className.replace(new RegExp(" hover\\b"), "");}
		}
	}
}
if (window.attachEvent){
	window.attachEvent("onload", cssmenuhover);
}
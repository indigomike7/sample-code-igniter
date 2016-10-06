<?php
?>
<html>
<head>
<title>Check Website</title>
<link href="style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="jquery.js">
</script>
</head>
<body>
<script type="text/javascript">
function getalexa(url)
{
	var request = $.ajax
	(
		{
			url: "alexa.php",
			data:"url=" + $("#url").val(),
			type:"POST",
			beforeSend: function( data ) 
			{
				$("#alexa").html("Loading Data ...");
			}
		}
	);
	request.done
	(
		function(x) 
		{
			$("#alexa").html(x);
		}
	);
}
function getsocial(url)
{
	var request = $.ajax
	(
		{
			url: "social_monitoring.php",
			data:"url=" + $("#url").val(),
			type:"POST",
			beforeSend: function( data ) 
			{
				$("#social").html("Loading Data ...");
			}
		}
	);
	request.done
	(
		function(x) 
		{
			$("#social").html(x);
		}
	);
}
function redirection(url)
{
	var request = $.ajax
	(
		{
			url: "redirect.php",
			data:"url=" + $("#url").val(),
			type:"POST",
			beforeSend: function( data ) 
			{
				$("#redirect").html("Loading Data ...");
			}
		}
	);
	request.done
	(
		function(x) 
		{
			$("#redirect").html(x);
		}
	);
}
function getDomain(url)
{
	var s = url.substr(0, 8), d;
	try
	{
	if(s.search('http://')<0 && s.search('https://')<0 && s.search('ftp://')<0){s="http://"+url;}else{s=url;}
	d = s.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/)[2];}
	catch(e){
	d = "" ;}
	return d ;
}
function generate()
{
	var url=$("#url").val();
	if(url != "")
	{
		if(learnRegExp(url)||learnRegExp2(url))
		{
			url=getDomain(url);
			//urlwww=getDomainwww(url);
			//alert(url);
			$("#result").show();
			getalexa(url);
			getsocial(url);
			//redirection(urlwww);
		}
		else
		{
			alert("Bad URL Format");
		}
	}
	else
	{
		alert("please enter url");
	}

}
$(document).ready
(
	function()
	{
		$("#result").hide();
		$("#go").click
			(
				function()
				{
					generate();
				}
			);
		$("#url").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
					generate();
                }
            }
        );

	}
);
function learnRegExp(){
  return /^(ftp|https?):\/\/+(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,}$/.test(learnRegExp.arguments[0]);
}
function learnRegExp2(){
  return /^[a-z0-9\-\.]{3,}\.[a-z]{2,}$/.test(learnRegExp2.arguments[0]);
}
</script>
<input type="text" name="url" value="" id="url">
<button type="button" name="go" id="go">Check Url</button>
<div id="result">
	<div class="title">Traffic Rank</div>
	<div id="alexa" class="full"></div>
	<div class="title">Social Media Monitoring</div>
	<div id="social" class="full"></div>
	<div class="title">301 Redirect</div>
	<div id="redirect" class="full"></div>
</div>
<?php
?>
</body>
</html>

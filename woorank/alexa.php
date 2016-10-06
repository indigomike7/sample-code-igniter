<?php
function getAlexa($url)
{
	$xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$url);
	$rank=(int)$xml->SD[1]->POPULARITY->attributes()->TEXT;
	return $rank;
}
if(isset($_POST['url']))
{
	$url=$_POST['url'];

	/*Alexa*/
	$ranking=getAlexa($url);
	if($ranking<1000000)
	{
		$rank='<span class="green font14">#'.$ranking."</span>";
		$alexa_msg_1 ="<span class='green font14'><b>Low Rank</b></span>";
		$alexa_msg_2 = "A <span class='green font14'><b>Low Rank</b></span> means that your website gets lots of visitors.";
	}
	else
	{
		$rank='<span class="red font14">#'.$ranking."</span>";
		$alexa_msg_1 ="<span class='red font14'><b>High Rank</b></span>";
		$alexa_msg_2 = "A <span class='red font14'><b>High Rank</b></span> means that your website doesn't gets lots of visitors.";
	}
}

?>
<div class="content">
<ul>
	<li><b><?php echo $alexa_msg_1;?></b></li>
	<li><b><?php echo $rank; ?></b> most visited website in the World </li>
	<li><?php echo $alexa_msg_2;?></li>
	<li>Your Alexa Rank is a good estimate of worldwide traffic to your website, Quantcast provides similar services.</li>
</ul>
</div>

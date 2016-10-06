<?php
require_once("dom.php");
function getFacebook($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
	curl_setopt($curl, CURLOPT_SSLVERSION,3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	$fql  = "SELECT url, normalized_url, share_count, like_count, comment_count, ";
	$fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
	$fql .= "link_stat WHERE url = '".$url."'";
	$get="?format=json&query=".urlencode($fql);
	curl_setopt($curl,CURLOPT_URL,'https://api.facebook.com/method/fql.query'.$get);

	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result_xml = curl_exec($curl);
	curl_close($curl);
	$data=json_decode($result_xml);
	$return=array('like'=>$data[0]->like_count,'share'=>$data[0]->share_count,'comment'=>$data[0]->comment_count);
	return $return;
}
function getTwitter($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
	curl_setopt($curl, CURLOPT_SSLVERSION,3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	$get="?url=".$url;
	curl_setopt($curl,CURLOPT_URL,'http://cdn.api.twitter.com/1/urls/count.json'.$get);

	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result_xml = curl_exec($curl);
	curl_close($curl);
	$data=json_decode($result_xml);
	$return=array('twitter_back_link'=>$data->count);
	return ($return);
}
function getDigg($url)
{
}
function getAll($url)
{
	$curl = curl_init();
/*	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
	curl_setopt($curl, CURLOPT_SSLVERSION,3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
*/
	$get="?url=http://".urlencode($url);
	curl_setopt($curl,CURLOPT_URL,'http://api.sharedcount.com/'.$get);
/*
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
	));

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
*/	$result_xml = file_get_contents("http://api.sharedcount.com/?url=http://" . rawurlencode($url));;
//	echo $result_xml;
	curl_close($curl);
	$counts = json_decode($result_xml, true);
	return ($counts);
}
if(isset($_POST['url']))
{
	$url=$_POST['url'];

	/*Alexa*/
	$data=getFacebook($url);
	$data2=getTwitter($url);
	$data3=getAll($url);
	//print_r($data3);
}

?>
<div class="content">
<ul>
	<li>Facebook Like : <span class="font14"><b><?php echo $data['like'];?></b></span></li>
	<li>Facebook Shares : <span class="font14"><b><?php echo $data['share']; ?></b></span> </li>
	<li>Facebook Comments : <span class="font14"><b><?php echo $data['comment']; ?></b></span></li>
	<li>Twitter Backlinks : <span class="font14"><b><?php echo $data2['twitter_back_link']; ?></b></span></li>
	<li>Digg Entries : <span class="font14"><b><?php echo $data3['Diggs']; ?></b></span></li>
	<li>Stumbled Upon : <span class="font14"><b><?php echo $data3['StumbleUpon']; ?></b></span></li>
	<li>Google + : <span class="font14"><b><?php echo $data3['GooglePlusOne']; ?></b></span></li>
	<?php
	if(($data['like']+$data['share']+$data['comment']+$data2['twitter_back_link']+$data3['Diggs']+$data3['StumbleUpon']+$data3['GooglePlusOne'])<1000)
	{
		?>
		<li>Improve your visibility: <span class="font14 red">Your website Is Not Popular</span> on Social Platforms.</li>
		<?php
	}
	else
	{
		?>
		<li><span class="font14 green"><b>Your Website is Popular</b></span> on Social Platforms.</li>
		<?php
	}
	?>
	<li>The impact of Social Media is huge for certain industries. Monitor what people say about your website on Social Media</li>
</ul>
</div>

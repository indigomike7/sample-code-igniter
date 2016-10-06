<?php
function curl_trace_redirects($url, $timeout = 15) {

    $result = array();
    $ch = curl_init();

    $trace = true;
    $currentUrl = $url;

    $urlHist = array();
    while($trace && $timeout > 0 && !isset($urlHist[$currentUrl])) {
        $urlHist[$currentUrl] = true;

        curl_setopt($ch, CURLOPT_URL, $currentUrl);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $output = curl_exec($ch);

        if($output === false) {
            $traceItem = array(
                'errorno' => curl_errno($ch),
                'error' => curl_error($ch),
            );

            $trace = false;
        } else {
            $curlinfo = curl_getinfo($ch);

            if(isset($curlinfo['total_time'])) {
                $timeout -= $curlinfo['total_time'];
            }

            if(!isset($curlinfo['redirect_url'])) {
                $curlinfo['redirect_url'] = get_redirect_url($output);
            }

            if(!empty($curlinfo['redirect_url'])) {
                $currentUrl = $curlinfo['redirect_url'];
            } else {
                $trace = false;
            }

            $traceItem = $curlinfo;
        }

        $result[] = $traceItem;
    }

    if($timeout < 0) {
        $result[] = array('timeout' => $timeout);
    }

    curl_close($ch);

    return $result;
}

// apparently 'redirect_url' is not available on all curl-versions
// so we fetch the location header ourselves
function get_redirect_url($header) {
    if(preg_match('/^Location:\s+(.*)$/mi', $header, $m)) {
        return trim($m[1]);
    }

    return "";
}
if(isset($_POST['url']))
{
	$url=$_POST['url'];
	$res = curl_trace_redirects($url);
	foreach($res as $item) {
		if(isset($item['timeout'])) {
			echo "Timeout reached!\n";
		} else if(isset($item['error'])) {
			echo "error: ", $item['error'], "\n";
		} else {
	/*        echo $item['url'];
			if(!empty($item['redirect_url'])) {
				// redirection
				echo " -> (", $item['http_code'], ")";
			}
	*/
			if($item['url']!=$url)
			{
				$data['url']=$item['url'];
			}
			if(!empty($item['redirect_url'])) {
				if($item['http_code']==301)
				{
					$data["code"]=301;
				}
			}
		}
	}
}
echo json_encode($data);

?>
<?php

	require_once('php-ogp/ogp/Parser.php');
	require_once('php-mf2/mf2/Parser.php');

		function getUrl($url) {
            global $version;
            
            $curl_handle=curl_init();
            curl_setopt($curl_handle,CURLOPT_URL,$url);
            curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,5);
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, "pingback2hook $version");

            $buffer = curl_exec($curl_handle);
            $http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            
            curl_close($curl_handle);
            
            return array('content' => $buffer, 'status' => $http_status);
        }

?><html>
	<head>
		<title>MetaInspect <?=$_REQUEST['url']; ?></title>
	</head>
	<body>
		<?php if (empty($_REQUEST['url'])) {
			?>
			
			<form method="post">
				<input name="url" type="url" placeholder="URL/permalink to parse"><input type="submit" value="Go">
			</form>
			
			<?php
		} else { 
			
			$content = getUrl($_REQUEST['url']);
			
			?>
			<h1><?= $_REQUEST['url'];?> : Status - <?= $content['status']; ?></h1>
			
			<h2>Open Graph</h2>
			<pre><?= print_r(\ogp\Parser::parse($content['content']), true); ?></pre>
			
			<h2>MF2</h2>
			<pre><?php
			$parser = new \mf2\Parser($content['content']);
			print_r( $parser->parse());
			?></pre>
		<?php } ?>
	</body>
</html>
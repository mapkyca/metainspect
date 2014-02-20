<?php

	require_once('absolute-url-deriver/src/webignition/AbsoluteUrlDeriver/AbsoluteUrlDeriver.php');
	require_once('php-ogp/ogp/Parser.php');
	require_once('php-mf2/Mf2/Parser.php');
	require_once('lib/metainspect.php');

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
			<?php
			if ($parser = new \mf2\Parser($content['content'])) {
				echo "<pre>";
				print_r( $parser->parse());
				echo "</pre>";
			}
			else
			{
				?>
					<b>Errrp! No microformats found... if this site is yours, you might want to add some Indieweb Microformats in order to help others parse your content! Check out <a href="http://microformats.org/wiki/microformats2">http://microformats.org/wiki/microformats2</a>
				<?php
			}
			?>
		<?php } ?>
	</body>
</html>

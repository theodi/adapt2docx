<?php

	error_reporting(E_ALL & ~E_NOTICE);

	$file = $argv[1];
	$id = $argv[2];
	system('cat ' . $file . ' | grep ' . $id . ' > out.tmp');
	$handle = fopen('out.tmp',"r");
	while ($line = fgets($handle)) {
		$line = trim($line);
		$oid = substr($line,strpos($line,$id),strlen($line));
		if (strpos($oid," ") > 0) $oid = substr($oid,0,strpos($oid," "));
		if (strpos($oid,'"') > 0) $oid = substr($oid,0,strpos($oid,'"'));
		if (strpos($oid,"-") > 0) $oid = substr($oid,0,strpos($oid,"-"));
		if ($oid != "" && !$done[$oid]) {
			$done[$oid] = true;
			$ids[] = $oid;
		}
	}
	fclose($handle);
	unlink('out.tmp');

	$string = file_get_contents("../languagefiles/en/export.json");
	$data = json_decode($string,true);
	for ($i=0;$i<count($data);$i++) {
		$node = $data[$i];
		if ($node["id"] && substr($node["id"],0,strlen($id)) == $id && $node["path"] != "/displayTitle/" && $node["path"] != "/linkText/" && strpos($node["path"],"strapline") == 0) {
			$parts[$node["id"]][] = $node;
		}
	}
	for ($i=0;$i<count($ids);$i++) {
		$output = filter($parts[$ids[$i]]);
		$output = reorder($output);
		if ($output) $outputs[] = $output;
	}
	for($i=0;$i<count($outputs);$i++) {
		output($outputs[$i]);
	}

function output($data) {
	for($i=0;$i<count($data);$i++) {
		$path = $data[$i]["path"];
		//echo $path . "\n";
		if ($path == "/title/") {
			echo "<h2>" . strip_tags($data[$i]["value"]) . "</h2>";
		} elseif (strpos($path, "title") > 0) {
			echo "<h3>" . strip_tags($data[$i]["value"]) . "</h3>";
		} elseif ( $path == "/instruction/") {
			echo "<i>" . strip_tags($data[$i]["value"]) . "</i><br/><br/>";
		} elseif ( strpos($path, "items") > 0 && strpos($path, "text") > 0) {
			echo "<ul><li>" . strip_tags($data[$i]["value"]) . "</li></ul>";
		} else {
			echo "<p>" . trim($data[$i]["value"]) . "</p>";
		}
	}
}

function reorder($data) {
	$order = ['/title/','/body/','/instruction/'];
	for($i=0;$i<count($order);$i++) {
		$path = $order[$i];
		for($j=0;$j<count($data);$j++) {
			if ($data[$j]["path"] == $path) $ret[] = $data[$j];
		}
	}
	for($j=0;$j<count($data);$j++) {
		$path = $data[$j]["path"];
		if (!in_array($path, $order)) {
			$ret[] = $data[$j];
		}
	}
	return $ret;
}

function filter($data) {
	for($i=0;$i<count($data);$i++) {
		$current = $data[$i];
		if (trim($current["value"]) == "") {
			continue;
		}
		if (trim($current["value"]) == "Component title") {
			continue;
		}
		if (trim($current["value"]) == "Article title") {
			continue;
		}
		if (trim($current["value"]) == "Page title") {
			continue;
		}
		$ret[] = $data[$i];
	}
	return $ret;
}

?>

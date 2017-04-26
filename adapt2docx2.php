<?php

	error_reporting(E_ALL & ~E_NOTICE);

	$file = $argv[1];
	$id = $argv[2];
	system('cat ' . $file . ' | grep ' . $id . ' > out.tmp');
	$handle = fopen('out.tmp',"r");
	while ($line = fgets($handle)) {
		$line = trim($line);
		$ids = explode(" " . $id, $line);
		for($i=1;$i<count($ids);$i++) {
			$oid = $id . substr($ids[$i],0,strpos($ids[$i]," "));
			$oid = str_replace('"','',$oid);
			$done[$oid] = true;
			$oids[] = $oid;
		}
	}
	fclose($handle);
	unlink('out.tmp');
	$ids = $oids;

	$string = file_get_contents("course/components.json");
	$data = json_decode($string,true);
	for ($i=0;$i<count($data);$i++) {
		$node = $data[$i];
		if ($node["_id"] && substr($node["_id"],0,strlen($id)) == $id) {
			$parts[$node["_id"]] = $node;
		}
	}
	for ($i=0;$i<count($ids);$i++) {
		$component = $parts[$ids[$i]];
		if ($component["_component"] != "graphic") {
			output($component);
			
		}
	}

function output($component) {
	if ($component["_component"] == "text" || $component["_component"] == "media") {
		outputText($component);
	} elseif ($component["_canShowFeedback"]) {
		outputText($component);
		outputQuestion($component);
	} elseif ($component["_component"] == "accordion") {
		outputText($component);
		outputAccordion($component);
	} elseif ($component["_component"] == "narrative") {
		outputText($component);
		outputNarrative($component);
	} elseif ($component["_component"] == "matching") {
		outputText($component);
		outputMatching($component);
	} elseif ($component) {
		print_r($component);
		exit(1);
	}
}

function outputText($component) {
	echo "<h2>" . strip_tags($component["displayTitle"]) . "</h2>";
	echo "<p>" . trim($component["body"]) . "</p>";
}
function outputQuestion($component) {
	$items = $component["_items"];
	echo '<ul>';
	for($i=0;$i<count($items);$i++) {
		echo '<li>' . $items[$i]["text"] . '</li>';
	}
	echo '</ul>';
	echo $component["_feedback"]["correct"];
	echo $component["_feedback"]["_incorrect"]["final"];
}
function outputMatching($component) {
	$items = $component["_items"];
	echo '<ul>';
	for($i=0;$i<count($items);$i++) {
		echo '<li>' . $items[$i]["text"] . '</li>';
		$options = $items[$i]["_options"];
		echo '<ul>';
		for ($j=0;$j<count($options);$j++) {
			echo '<li>' . $options[$j]["text"] . '</li>';
		}
		echo '</ul>';
	}
	echo '</ul>';
	echo $component["_feedback"]["correct"];
	echo $component["_feedback"]["_incorrect"]["final"];
}
function outputAccordion($component) {
	$items = $component["_items"];
	for($i=0;$i<count($items);$i++) {
		$item = $items[$i];
		echo "<h3>" . strip_tags($item["title"]) . "</h3>";
		echo "<p>" . $item["body"] . "</p>";
	}
}
function outputNarrative($component) {
	$items = $component["_items"];
	for($i=0;$i<count($items);$i++) {
		$item = $items[$i];
		echo "<h3>" . strip_tags($item["title"]) . "</h3>";
		echo "<p>" . $item["body"] . "</p>";
	}
}


function reorder($data) {
	$order = ['title','body','instruction'];
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

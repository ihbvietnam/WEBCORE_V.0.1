<?php
$index = 0;
foreach ( $data as $item ) {
	if ($index == 0) {
		if ($item ['url'] != "")
			echo "<a href='" . $item ['url'] . "'>" . $item ['title'] . "</a>";
		else
			echo $item ['title'];
	} else {
		if ($item ['url'] != "")
			echo "<span></span><a href='" . $item ['url'] . "'>" . $item ['title'] . "</a>";
		else
			echo "<span></span>".$item ['title'];
	}
	$index ++;
}
?>

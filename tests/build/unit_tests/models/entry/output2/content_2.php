<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<div id="version">2.0.skel</div>
	<div id="status">draft</div>
	<div id="type">entry</div>
	<div id="slug">170707</div>
	<div id="creation_date">2017-07-07</div>
	<div id="published_date">2017-07-07</div>
	<div id="last_modified_date">2017-07-07</div>
	<div id="trip">rtw</div>
	<div id="title">This_Is_A_Title</div>
	<div id="vehicle">earthroamer</div>
	<div id="miles">miles</div>
	<div id="odometer">odometer</div>
	<div id="day_number">day_number</div>
	<div id="place">place</div>
	<div id="country">Canada</div>
	<div id="latitude">latitude</div>
	<div id="longitude">longitude</div>
	<div id="featured_image">[0]</div>
	<div id="main_content">
		<!-- a new format 22/5/2019 -->
		<p>main entry content goes here</p>
		<?php Skin::JournalGalleryThumbnails($trip, $entry);?>  
		<?php //Skin::JournalGalleryByName($trip, $entry, "190421");?>  
		<p>and here</p>
		<div id="camping">
			<p>camping comment goes here</p>
		</div>
		<div id="border">
		</div>
	</div>

</body>
</html>
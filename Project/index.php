<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CPSC 332 Final Project - Daniel Jordan</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/ajax.js"></script>
</head>
<body>
<div id="main">
		<h1>CPSC 332 Final Project</h1>
		<h3>Daniel Jordan | daniel_jordan@csu.fullerton.edu</h3>
	<ul id="tabs">
	    <li class="selected"><a>Department</a></li>
	    <li><a>Professors</a></li>
	    <li><a>Students</a></li>
	</ul>
	<div id="search_bar">
		<form id="search"> 
			<input type="text" class="search" placeholder="Make a selection">
			<button id="submit" type="submit">Submit</button>
        </form>
        <div id="categories">
        	<input name="search_category" type="radio" id="radio1" value="professor_class_listing_name"/>
            <label for="radio1">Professor class listing</label>
            <input name="search_category" type="radio" id="radio2" value="department_units"/>
            <label for="radio2">Department Units</label>
            <span class="errors"></span>
        </div>
	</div>
	<div id="results_container">
	

	</div>
</div>
</body>
</html>
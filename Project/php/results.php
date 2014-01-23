<?
require('../classes/Database.class.php');

$db = new Database("ecsmysql", "cs332g11", "eiweifai");
$db->db_connect("cs332g11");

switch($_GET["category"])
{
	case "professor_class_listing_name":
		echo "<h1>Professor Name: ".$_GET["search"]."</h1>\n";
		echo $db->professor_name_class_listing($_GET["search"]);
		break;
	case "department_units":
		echo "<h1>Department Number: ".$_GET["search"]."</h1>\n";
		echo $db->department_units($_GET["search"]);
		break;
	case "professor_class_listing_ssn":
		echo "<h1>Professor SSN: ".$_GET["search"]."</h1>\n";
		echo $db->professor_ssn_class_listing($_GET["search"]);
		break;
	case "grade_count":
		//Split search string into separate arguments
		$arr = explode("::", $_GET["search"]);
		echo "<h1>Course Number: ".$arr[0].", Section Number: ".$arr[1]."</h1>\n";
		echo $db->course_grade_count($arr[0], $arr[1]);
		break;
	case "section_listing":
		echo "<h1>Course Number: ".$_GET["search"]."</h1>\n";
		echo $db->course_section_listing($_GET["search"]);
		break;
	case "student_class_listing":
		echo "<h1>Student CCWID: ".$_GET["search"]."</h1>\n";
		echo $db->student_class_listing($_GET["search"]);
		break;
}
?>
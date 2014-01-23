<?
class Database
{
	public $db_host;
	public $db_username;
	public $db_password;
	public $db_name;
	public $query;

	public function Database($db_host, $db_username, $db_password)
	{
		$this->db_host = $db_host;
		$this->db_username = $db_username;
		$this->db_password = $db_password;
	}
	public function db_connect($db_name)
	{
		$this->db_name = $db_name;
		mysql_connect($this->db_host, $this->db_username, $this->db_password) or die(mysql_error()); 
		mysql_select_db  ($this->db_name) or die(mysql_error()); 
	}
	public function professor_name_class_listing($professor_name)
	{
		$this->query = "SELECT COURSE_NUMBER as 'Course Number', COURSE_TITLE as 'Course Title', COURSE_UNITS as 'Course Units'
				  		 FROM PROFESSOR, SECTION, COURSE
				  		 WHERE COURSE_NUMBER = SECTION_COURSE_NUMBER 
				  		 AND PROFESSOR_SSN = SECTION_PROFESSOR_SSN
				  		 AND PROFESSOR_NAME = '".mysql_real_escape_string($professor_name)."'
				  		 GROUP BY COURSE_TITLE;";
		$this->run_query();
	}
	public function department_units($department_name)
	{
		$this->query = "SELECT DEPARTMENT_NAME as 'Department Name', SUM(COURSE_UNITS) AS 'Units'
						FROM DEPARTMENT, COURSE
						WHERE DEPARTMENT_NUMBER = COURSE_DEPARTMENT_NUMBER
						AND   DEPARTMENT_NUMBER = '".mysql_real_escape_string($department_name)."'
						GROUP BY DEPARTMENT_NAME;";
		$this->run_query();
	}
	public function professor_ssn_class_listing($professor_ssn)
	{
		$this->query = "SELECT COURSE_TITLE as 'Course Title', SECTION_CLASSROOM as 'Classroom', SECTION_DAYS as 'Days', DATE_FORMAT(SECTION_BEGINNING_TIME, '%h:%i %p') as 'Starting Time', DATE_FORMAT(SECTION_ENDING_TIME,'%h:%i %p') as 'Ending Time'
						FROM COURSE, SECTION, PROFESSOR
						WHERE PROFESSOR_SSN = SECTION_PROFESSOR_SSN 
						AND COURSE_NUMBER = SECTION_COURSE_NUMBER 
						AND PROFESSOR_SSN = ".mysql_real_escape_string($professor_ssn).";";
		$this->run_query();
	}
	public function course_grade_count($course_name, $section_number)
	{
		$this->query = "SELECT ENROLLMENT_GRADE as 'Grade', COUNT(*) as 'Count'
						FROM ENROLLMENT, COURSE, SECTION
						WHERE COURSE_NUMBER = SECTION_COURSE_NUMBER
						AND ENROLLMENT_COURSE_NUMBER = COURSE_NUMBER
						AND ENROLLMENT_SECTION_NUMBER = SECTION_NUMBER
						AND SECTION_NUMBER = ".mysql_real_escape_string($section_number)." 
						AND COURSE_NUMBER = '".mysql_real_escape_string($course_name)."'
						GROUP BY ENROLLMENT_GRADE;";
		$this->run_query();
	}
	public function course_section_listing($course_name)
	{
		$this->query = "SELECT COURSE_NUMBER as 'Course Number', COURSE_TITLE as 'Course Title', SECTION_NUMBER as 'Section Number', SECTION_CLASSROOM as 'Classroom', SECTION_DAYS as 'Days', (SECTION_SEATS-COUNT(ENROLLMENT_CCWID)) as 'Seats'
						FROM COURSE, ENROLLMENT, SECTION
						WHERE ENROLLMENT_SECTION_NUMBER = SECTION_NUMBER
						AND COURSE_NUMBER = SECTION_COURSE_NUMBER
						AND ENROLLMENT_COURSE_NUMBER = '".mysql_real_escape_string($course_name)."'
						GROUP BY SECTION_NUMBER;";
		$this->run_query();
	}
	public function student_class_listing($student_ccwid)
	{
		$this->query = "SELECT COURSE_TITLE as 'Course Title', ENROLLMENT_COURSE_NUMBER as 'Course Number', ENROLLMENT_SECTION_NUMBER as 'Section Number', ENROLLMENT_GRADE as 'Grade'
						FROM ENROLLMENT, COURSE
						WHERE ENROLLMENT_COURSE_NUMBER = COURSE_NUMBER
						AND ENROLLMENT_CCWID = ".mysql_real_escape_string($student_ccwid).";";
		$this->run_query();
	}
	public function run_query()
	{
		$data = mysql_query($this->query) or die(mysql_error()); 
		if(mysql_num_rows($data) > 0)
			return $this->output($data);
		else
			echo "<h1>No results found</h1>";
	}
	public function output($data)
	{
		//Output field names in table header 
		echo '<table>'."\n\t".'<tr id="header">'."\n";
		for($i = 0; $i < mysql_num_fields($data); $i++) {
		    $column = mysql_fetch_field($data, $i);
		    echo "\t\t".'<td>'.$column->name.'</td>'."\n";
		}
		echo "\t".'</tr>'."\n";
		//Output data in table rows
		while($row = mysql_fetch_row($data))
		{
	    	echo "\t".'<tr>'."\n";
	    	foreach($row as $field) {
	        	echo "\t\t".'<td>'.$field.'</td>'."\n";
	    	}
	    	echo "\t".'</tr>'."\n";
		}
		echo '</table>'."\n";
	}
}
?>
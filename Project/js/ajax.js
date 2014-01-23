$(document).ready(function() {

	//=============================================================
	// Tab functionality:
	// 
	//=============================================================
		$("#tabs li").click(function() {
		$("#tabs li").each(function() {
			$(this).removeClass('selected');
		});
		$(this).addClass('selected');
		$('#radio1').prop('checked', false);
		$('#radio2').prop('checked', false);
		$('.search').attr("placeholder", "Make a selection");
		$('.search').val("");
		$(".errors").html("");
		switch($(this).text())
		{
			case 'Department':
				$('label[for=radio1]').text("Professor class listing");
				$('#radio1').val("professor_class_listing_name");
				$('label[for=radio2]').text("Department Units");
				$('#radio2').val("department_units");
				break;
			case 'Professors':
				$('label[for=radio1]').text("Professor class listing");
				$('#radio1').val("professor_class_listing_ssn");
				$('label[for=radio2]').text("Class grade count");
				$('#radio2').val("grade_count");
				break;
			case 'Students':
				$('label[for=radio1]').text("Class section listing");
				$('#radio1').val("section_listing");
				$('label[for=radio2]').text("Student class listing");
				$('#radio2').val("student_class_listing");
				break;
		}
		});
	//=============================================================
	// Radio buttons:
	// Sets according placeholder text on input field, telling user  
	// what type of entry is expected, for each search category
	//=============================================================
	$("input[name='search_category']").click(function() {
		$('.search').val("");
		switch($(this).val())
		{
			case "professor_class_listing_name":
				$('.search').attr("placeholder", "Enter Professor Name");
				break;
			case "department_units":
				$('.search').attr("placeholder", "Enter Department Number");
				break;
			case "professor_class_listing_ssn":
				$('.search').attr("placeholder", "Enter Professor SSN (No dashes)");
				break;				
			case "grade_count":
				$('.search').attr("placeholder", "Enter Course Number and section number separated by two colons (Ie: CPSC-471::13654)");
				break;
			case "section_listing":
				$('.search').attr("placeholder", "Enter Course Number (Ie: CPSC-332)");
				break;
			case "student_class_listing":
				$('.search').attr("placeholder", "Enter Student CCWID");
				break;
			break;
		}
	});
	//=============================================================
	// Form validation:
	// Checks if a search category has been selected, and search string
	// has been entered. If any errors are caught, they are displayed
	// and form is prevented from submitting. 
	//=============================================================	
	$("#submit").click(function(event) {
		var errors = [];
		var search_category = $('input[name=search_category]:checked').val();
		var search_string = $('.search').val();
		if(typeof search_category === "undefined")
		{
			errors.push("Select a search category")
			event.preventDefault();
		}
		if(search_string == "")
		{
			errors.push("Enter a search term")
			event.preventDefault();
			$("#search").focus();
		}
		if(errors.length > 0)
		{
			$(".errors").html("");
			$.each(errors, function(index, val) {
				$(".errors").append(errors[index]);
				if(index < (errors.length-1))
				$(".errors").append(", ");					
			});
		}
	});
	//=============================================================
	// Ajax call:
	// Sends search category and search string to php/results.php
	// File returns html, which is injected into the "results_container" div
	//=============================================================		
	$("#search").submit(function(event) {
		event.preventDefault();
		$(".errors").html("");
		var search_category = $('input[name=search_category]:checked').val();
		var search_string = $('.search').val();
		$('#results_container').html('<div id="spinner"></div>');
		var t = setTimeout(function(){
			$.ajax({
				url: "php/results.php", 
				type: "GET",
				data:   "category="+search_category+ "&search="+search_string,  
				cache: false,
				success: function (html){
					$("#results_container").hide().html(html).fadeIn("slow");
				}
			});
		},1000);

    
	});
});
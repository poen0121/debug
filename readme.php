<?php
/*
>> Information

	Title		: hpl_debug function
	Revision	: 3.7.4
	Notes		:

	Revision History:
	When			Create		When		Edit		Description
	---------------------------------------------------------------------------
	10-20-2010		Poen		10-20-2010	Poen		Create the program.
	08-17-2016		Poen		08-18-2016	Poen		Reforming the program.
	09-08-2016		Poen		06-21-2017	Poen		Improve error_log_file function.
	09-23-2016		Poen		09-20-2017	Poen		Improve the program.
	09-23-2016		Poen		09-23-2016	Poen		Change logs function name become record.
	10-06-2016		Poen		10-06-2016	Poen		Add is_all_report function.
	10-06-2016		Poen		10-06-2016	Poen		Add is_close_report function.
	10-06-2016		Poen		10-06-2016	Poen		Add is_display function.
	10-06-2016		Poen		10-06-2016	Poen		Add is_record function.
	10-07-2016		Poen		10-07-2016	Poen		Debug is_display function.
	10-07-2016		Poen		10-07-2016	Poen		Debug is_record function.
	02-22-2017		Poen		02-22-2017	Poen		Debug error_log_file function.
	04-20-2017		Poen		04-20-2017	Poen		Add set_trace_error_handler function.
	06-21-2017		Poen		06-21-2017	Poen		Rename set_trace_error_handler function to trace_error_handler.
	06-21-2017		Poen		06-21-2017	Poen		Fix error log time and line breaks.
	06-22-2017		Poen		06-22-2017	Poen		PHP System error log recovery can only access system files.
	06-22-2017		Poen		06-22-2017	Poen		Improve error_log_file function.
	07-04-2017		Poen		07-04-2017	Poen		Improve trace_error_handler function.
	09-18-2017		Poen		09-18-2017	Poen		Modify error_log_file function.
	09-18-2017		Poen		09-18-2017	Poen		Rename trace_error_handler function.
	---------------------------------------------------------------------------

>> About

	Debug the operation mode.

>> Usage Function

	==============================================================
	Include file
	Usage : include('debug/main.inc.php');
	==============================================================

	==============================================================
	Set PHP errors report mode.
	Usage : hpl_debug::report($switch);
	Param : boolean $switch (open or close the report error mode) : Default true
	Note : $switch `true` is open the report error types E_ALL.
	Note : $switch `false` is close the report error types 0.
	Return : boolean
	Return Note : Returns FALSE on failure.
	--------------------------------------------------------------
	Example : Open the report error.
	hpl_debug::report(true);
	Output >> TRUE
	Example : Close the report error.
	hpl_debug::report(false);
	Output >> TRUE
	==============================================================

	==============================================================
	Check the PHP error reporting mode is strictly of type E_ALL.
	Usage : hpl_debug::is_all_report();
	Return : boolean
	--------------------------------------------------------------
	Example :
	hpl_debug::report(true);
	hpl_debug::is_all_report();
	Output >> TRUE
	==============================================================

	==============================================================
	Check the PHP error reporting mode is strictly of type 0.
	Usage : hpl_debug::is_close_report();
	Return : boolean
	--------------------------------------------------------------
	Example :
	hpl_debug::report(false);
	hpl_debug::is_close_report();
	Output >> TRUE
	==============================================================

	==============================================================
	Set PHP errors report display mode.
	Usage : hpl_debug::display($switch);
	Param : boolean $switch (open or close the report display mode) : Default true
	Note : $switch `true` is open the report display.
	Note : $switch `false` is close the report display.
	Return : boolean
	Return Note : Returns FALSE on failure.
	--------------------------------------------------------------
	Example : Open the report display.
	hpl_debug::display(true);
	Output >> TRUE
	Example : Close the report display.
	hpl_debug::display(false);
	Output >> TRUE
	==============================================================

	==============================================================
	Check the PHP error report display mode is open.
	Usage : hpl_debug::is_display();
	Return : boolean
	--------------------------------------------------------------
	Example :
	hpl_debug::display(true);
	hpl_debug::is_display();
	Output >> TRUE
	==============================================================

	==============================================================
	Set PHP log errors to specified default file.
	Usage : hpl_debug::error_log_file($path);
	Param : string $path (file path)
	Return : boolean
	Return Note : Returns FALSE on failure.
	--------------------------------------------------------------
	Example : Rewrite the PHP system error_log file.
	hpl_debug::error_log_file('./test.log');
	Output >> TRUE
	Example : Error file path.
	hpl_debug::error_log_file('http://example/test_log');
	Output >> FALSE
	Example : Error file path.
	hpl_debug::error_log_file('./');
	Output >> FALSE
	==============================================================

	==============================================================
	Set system error log storage.
	Note : Uncontrolled error_log function.
	Usage : hpl_debug::record($switch);
	Param : boolean $switch (open or close the logs storage) : Default true
	Note : $switch `true` is open the logs storage.
	Note : $switch `false` is close the logs storage.
	Return : boolean
	Return Note : Returns FALSE on failure.
	--------------------------------------------------------------
	Example : Open the logs storage.
	hpl_debug::record(true);
	Output >> TRUE
	Example : Close the logs storage.
	hpl_debug::record(false);
	Output >> TRUE
	==============================================================

	==============================================================
	Check the PHP error log storage mode is open.
	Usage : hpl_debug::is_record();
	Return : boolean
	--------------------------------------------------------------
	Example :
	hpl_debug::record(true);
	hpl_debug::is_record();
	Output >> TRUE
	==============================================================

*/
?>
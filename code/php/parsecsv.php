<?php
/*
 * Retrieves an array containing name => column associations from open file
 * 
 * @param resource $fH Open file resource
 * 
 * @return array Associative array of column name => column number
 */
function get_csv_headers ($fH)
{
	return array_flip(fgetcsv($fH));
}

/**
 * Handles file opening and error reporting if file in unavailable
 * 
 * @param string $file Path of file to open
 * 
 * @return resource Open file handle
 */
function open_file ($file)
{
	// Open the CSV file
	$fH = fopen($file, "r");
	if ($fH === false) {
		die("Failed to open input file {$file} for reading\n");
	}
	
	return $fH;
}

/**
 * Reads a row of data from a CSV file and parses into UTF-8
 * 
 * @param resource $fH Open file handle
 * 
 * @return mixed False if EOF; indexed array of data otherwise
 */
function parse_csv_row ($fH)
{
	$row = fgetcsv($fH);
	
	if (is_array($row) === false)
	{
		return false;
	}
	
	foreach ($row as $key => $value) {
		$row[$key] = iconv('ISO-8859-1', 'UTF-8', $value);
	}
	
	return $row;
}
?>

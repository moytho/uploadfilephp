<?php
/*
* 	   Simple file Upload system with PHP.
* 	   Created By Tech Stream
* 	   Original Source at http://techstream.org/Web-Development/PHP/Single-File-Upload-With-PHP
*      This program is free software; you can redistribute it and/or modify
*      it under the terms of the GNU General Public License as published by
*      the Free Software Foundation; either version 2 of the License, or
*      (at your option) any later version.
*      
*      This program is distributed in the hope that it will be useful,
*      but WITHOUT ANY WARRANTY; without even the implied warranty of
*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*      GNU General Public License for more details.
*     
*/
	require_once 'connection.php';

	if(isset($_FILES['file'])){
		$errors= array();
		$file_name = $_FILES['file']['name'];
		$file_size =$_FILES['file']['size'];
		$file_tmp =$_FILES['file']['tmp_name'];
		$file_type=$_FILES['file']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
		
		
		$expensions= array("xls","xlsx","ods","csv"); 		
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}
		//if($file_size > 2097152){
		//$errors[]='File size must be excately 2 MB';
		//}				
		if(empty($errors)==true){
			//move_uploaded_file($file_tmp,"files/".$file_name);
			$destination_path = getcwd().DIRECTORY_SEPARATOR;
			$target_path = $destination_path ."files/". basename( $_FILES["file"]["name"]);
			move_uploaded_file($_FILES['file']['tmp_name'], $target_path);

			// If you need to parse XLS files, include php-excel-reader
		    require('php-excel-reader/excel_reader2.php');
		    require('SpreadsheetReader.php');
		    $Reader = new SpreadsheetReader($target_path);

		    $strSQL="";
		    $counter=0;
		    foreach ($Reader as $Row)
		    {
		    	if ($counter>0){
			    	//echo $Row[0];
					$strSQL="INSERT INTO ".
			    		"zipcodes". 
			    		"(zip, type,primary_city,acceptable_cities,unacceptable_cities,state,county,timezone,area_codes,latitude,longitude,world_region,country,decommissioned,estimated_population,notes) ".
			    		"VALUES ('$Row[0]','$Row[1]','$Row[2]','$Row[3]','$Row[4]','$Row[5]','$Row[6]','$Row[7]','$Row[8]','$Row[9]','$Row[10]','$Row[11]','$Row[12]','$Row[13]','$Row[14]','$Row[15]')";
			    		echo $strSQL;
			    	$sql = mysql_query($strSQL);
			    	//echo $Row;
		    	}
		    	$counter++;
		    }
		    echo "Created successfully";



		}else{
			print_r($errors);
		}
	}
?>
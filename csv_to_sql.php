// TABLENAME
$tablename = "tblname";
// CSV FILE (local file)
$csv = "upload data/tblname.csv";
// SEPERTATOR
$sep = ";";
$SQLIMPORT="";
	if (($csvdata = fopen($csv, "r")) !== FALSE) {
		$row=0;
		// get each line
		while (($data = fgetcsv($csvdata, 0, $sep)) !== FALSE) {
			$num = count($data);
			$row++;
			//get each coll
			for ($c=0; $c < $num; $c++) {
				if( $row == 1)
				{
					$collname[] =$data[$c];
				}
				else{
					$datarow[$collname[$c]]=$data[$c];
				}
			}
			if( $row > 1) $SQLIMPORT.="INSERT INTO $tablename (`".implode("`,`",	array_keys($datarow))."`) VALUES (`".implode("`,`",	array_values($datarow))."`);\n";
			
		}
		fclose($csvdata);
	}
  // thats it
 echo ($SQLIMPORT);

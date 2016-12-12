<?
// TABLENAME
$tablename = "tablename here";
// CSV FILE (local file)
$csv = "upload data/testdata.csv";
// SEPERTATOR
$sep = ",";
// DOES FIRST ROW CONTAIN COLNAMES 
$firestrowhavecolnames = true;

$SQLIMPORT="";
	if (($csvdata = fopen($csv, "r")) !== FALSE) {
		$row=0;
		// get each line
		while (($data = fgetcsv($csvdata, 0, $sep)) !== FALSE) {
			$num = count($data);
			$row++;
			// check if first row have more than 1 columns
			if($num < 2 && $row ==1)
			{
				$csverror="ERROR: count fields:={$num} need more than 1, used seperator:=`{$sep}`, data: ".implode($sep,$data)."\n";
				continue;
				
			}
			// if first row have less than 2 columns add extra error data
			if($num < 2 )
			{
				if($row == 5) 
				{
					echo $csverror;
					break;
				}
				$csverror.="\nERROR: count fields:={$num} need more than 1, used seperator:=`{$sep}`, data: ".implode($sep,$data);
				continue;
			}
			//get each coll
			for ($c=0; $c < $num; $c++) {
				if( $row == 1)
				{
					if($firestrowhavecolnames  == true)
					{
						$collname[] = $data[$c];
					}
					else
					{
						$collname[] = 'field'.$c;
						$datarow['field'.$c]=$data[$c];
						}
					
				}
				else{
					$datarow[$collname[$c]]=$data[$c];
					
				}
			}
			
			if($firestrowhavecolnames  == true )
			{
				if($row > 1)
				{
					$SQLIMPORT.=add_SqlInsert($datarow) ;
				}
			}
			else
			{
				$SQLIMPORT.=add_SqlInsert($datarow) ;
			}
			
			
		}
		fclose($csvdata);
	}


function add_SqlInsert($data)
	{
		global $tablename;
		$retvar = "INSERT INTO $tablename (`".implode("`,`",	array_keys($data))."`) VALUES (`".implode("`,`",	array_values($data))."`);\n";
		return $retvar;
	}


?>
<style>
	pre {
    	display: block;
    	margin-left: auto;
    	margin-right: auto;
    	background-color: #fcfcfc;
    	padding: 10px;
    	border: 1px;
    	border-style: solid;
    	border-width: 1px;
   	overflow: scroll;
    	max-height: 95vh;
    	max-width: 95vw;
	}
</style>
<pre>
<?  print_r($SQLIMPORT); ?>
</pre>
  

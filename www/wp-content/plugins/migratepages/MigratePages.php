<?php

require_once('../../../wp-config.php');

class MigratePages{
	private static function getConnection() {
		$dbh = new PDO ( "mysql:host=". DB_HOST . ";dbname=" . DB_NAME,
				 DB_USER, DB_PASSWORD );
		$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		return $dbh;
	}
	public static function export()
	{
		global $table_prefix;
		$db = MigratePages::getConnection();
		$sql = 'SELECT * FROM ' . $table_prefix . 'posts';
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$aResults = $stmt->fetchAll(PDO::FETCH_NUM);
		file_put_contents(ABSPATH . 'wp-content/uploads/pages.sql',
			"This starts the file\n");
		foreach ($aResults as $aRow){
			$sRow = "('";
			foreach($aRow as $n=>$sColumn){
				$sColumn = addslashes(preg_replace("/[\n\r]/", "", $sColumn));
				if($n > 0) $srow .= "','";
				$sRow .= $sColumn;
			}
			$sRow .= "')\n";
			file_put_contents(ABSPATH . 'wp-content/uploads/pages.sql',
			$sRow, FILE_APPEND);
		}
	}
	public static function import()
	{
	
	}
}
MigratePages::export ();
?>












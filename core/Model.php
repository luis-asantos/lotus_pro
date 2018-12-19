<?php
class model {
	
	protected $db;

	public function __construct() {
		global $config;
        try {
            $this->db = new PDO("sqlsrv:Database=".$config['dbname'].";server=".$config['host'], $config['dbuser'], $config['dbpass']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            die("Error connecting to SQL Server: " . $e->getMessage());

        }
	}

}
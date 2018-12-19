<?php
class controller {

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
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadLibrary($lib) {
		if(file_exists('libraries/'.$lib.'.php')) {
			include 'libraries/'.$lib.'.php';
		}
	}

}
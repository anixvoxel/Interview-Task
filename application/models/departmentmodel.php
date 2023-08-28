<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\BSON\ObjectId;

class DepartmentModel extends CI_model {

	private $database = 'school';
	private $department_collection = 'departments';
	private $conn;
	protected $mongoClient;
	protected $CI;
    protected $client;
    protected $manager;
    protected $config;
	
	function __construct() {
		parent::__construct();
		$this->load->library('mongodb');
		$this->conn = $this->mongodb->getConn();

		$CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

	}

	public function aggregate($pipeline, $collection,$config) {
        $command = new Command([
            'aggregate' => $collection,
            'pipeline' => $pipeline,
            'cursor' => new stdClass(),
        ]);

       
        $cursor = $this->conn->executeCommand($config['mongo_database'], $command);
        return $cursor->toArray();
    }


	function getDepartments($config,$id=null) {
		try {
			if($id==null){
			$pipeline = [];
			}else{
			$pipeline = [[
               		 '$match' => [
                    	'_id' => new ObjectId($id)
                	]
            	]];
			
			}

        $result = $this->aggregate($pipeline, 'departments',$config);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}
	
	
	function register_department($data) {
		try {
			extract($data);
			$department = array(
					'department' => $department,
				);
			
			$query = new MongoDB\Driver\BulkWrite();
			$query->insert($department);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->department_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while saving users: ' . $ex->getMessage(), 500);
		}
	}

		function update_department($data) {
		try {
			extract($data);
			$query = new MongoDB\Driver\BulkWrite();
			$query->update(
				['_id' => new MongoDB\BSON\ObjectId($id)], 
				['$set' => array(
					'department' => $department,
				)]
			);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->department_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while updating users: ' . $ex->getMessage(), 500);
		}
	}

	function delete_department($id) {
		try {
			$query = new MongoDB\Driver\BulkWrite();
			$query->delete(['_id' => new MongoDB\BSON\ObjectId($id)]);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->department_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while deleting users: ' . $ex->getMessage(), 500);
		}
	}

	
}
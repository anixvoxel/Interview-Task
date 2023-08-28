<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\BSON\ObjectId;

class BatchModel extends CI_model {
	
	private $database = 'school';
	private $batch_collection = 'batches';
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
	
	function getBatches($config,$id=null) {
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

        $result = $this->aggregate($pipeline, 'batches',$config);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}

	function register_batch($data) {
		try {
			extract($data);
			$batch = array(
					'batch' => $batch,
				);
			
			$query = new MongoDB\Driver\BulkWrite();
			$query->insert($batch);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->batch_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while saving users: ' . $ex->getMessage(), 500);
		}
	}

		function update_batch($data) {
		try {
			extract($data);
			$query = new MongoDB\Driver\BulkWrite();
			$query->update(
				['_id' => new MongoDB\BSON\ObjectId($id)], 
				['$set' => array(
					'batch' => $batch,
				)]
			);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->batch_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while updating users: ' . $ex->getMessage(), 500);
		}
	}

	function delete_batch($id) {
		try {
			$query = new MongoDB\Driver\BulkWrite();
			$query->delete(['_id' => new MongoDB\BSON\ObjectId($id)]);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->batch_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while deleting users: ' . $ex->getMessage(), 500);
		}
	}
	

	
}
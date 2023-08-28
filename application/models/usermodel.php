<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\BSON\ObjectId;

class UserModel extends CI_model {
	
	private $database = 'school';
	private $user_collection = 'users';
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
	
	function get_user_list() {
		try {
			$filter = [];
			$query = new MongoDB\Driver\Query($filter);
			
			$result = $this->conn->executeQuery($this->database.'.'.$this->user_collection, $query);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}


	function getStudent($id,$config) {
		try {

            	$searchRule = [
                    '_id' => new ObjectId($id)
                ];

			$pipeline = [
            [
                '$lookup' => [
                    'from' => 'departments',
                    'localField' => 'department',
                    'foreignField' => '_id',
                    'as' => 'departmentinfo',
                ],
            ],
            [
                '$unwind' => '$departmentinfo',
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'user_id' => '$_id',
                    'batch' => 1,
                    'department' => '$departmentinfo.department',
                    'name' => 1,
                    'gender' => 1,
                    'rollnumber' => 1,
                    'address' => 1,
                    'mobile' => 1,
                    'status' => 1,
                ],
            ],
            [
                '$match' => $searchRule,
            ]
        ];

        $result = $this->aggregate($pipeline, 'users',$config);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}

	function admin_student_filter_list($userdata,$config,$query=null) {
		try {

if($query){

	$searchRule = [
                    '$or' => [
                        ['name' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['mobile' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['rollnumber' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['address' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['department' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['batch' => ['$regex' => $query['query'], '$options' => 'i']],
                    ]
                ];
            }else{
            	$searchRule = [
            		'$or' => [
                        ['status' => 'Active'],
                        ['status' => 'Inactive']
                    ]
                ];
            }


			$pipeline = [
            [
                '$lookup' => [
                    'from' => 'departments',
                    'localField' => 'department',
                    'foreignField' => '_id',
                    'as' => 'departmentinfo',
                ],
            ],
            [
                '$unwind' => '$departmentinfo',
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'user_id' => '$_id',
                    'batch' => 1,
                    'department' => '$departmentinfo.department',
                    'name' => 1,
                    'rollnumber' => 1,
                    'address' => 1,
                    'mobile' => 1,
                    'status' => 1,
                ],
            ],
            [
                '$match' => $searchRule,
            ]
        ];

     

        $result = $this->aggregate($pipeline, 'users',$config);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}


	function student_filter_list($userdata,$config,$query=null) {
		try {

if($query){

	$searchRule = [
                    'status' => 'Active',
                    'batch' => $userdata['batch'],
                    'department' => $userdata['department']->_id,
                    '$or' => [
                        ['name' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['mobile' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['rollnumber' => ['$regex' => $query['query'], '$options' => 'i']],
                        ['address' => ['$regex' => $query['query'], '$options' => 'i']],
                    ]
                ];
            }else{
            	$searchRule = [
                    'status' => 'Active',
                    'batch' => $userdata['batch'],
                    'department' => $userdata['department']->_id
                ];
            }
			$pipeline = [
            [
                '$match' => $searchRule,
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'user_id' => '$_id',
                    'batch' => 1,
                    'name' => 1,
                    'rollnumber' => 1,
                    'address' => 1,
                    'mobile' => 1
                ],
            ]
        ];

        $result = $this->aggregate($pipeline, 'users',$config);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}

	function getnextRollnumber($config) {
		try {

			$pipeline = [
				[
                '$sort' => [
                    'rollnumber' => -1,
                ]
            ],
	            [
	                '$limit' => 1,
	            ],
			];

        $result = $this->aggregate($pipeline, 'users',$config);



			return $result[0]->rollnumber+1;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}

	function get_specific_user_list($userdata,$config) {
		try {

			$pipeline = [
            [
                '$match' => [
                    'status' => 'Active',
                    'batch' => $userdata['batch'],
                    'department' => $userdata['department'][0]->_id
                ],
            ],
            [
                '$lookup' => [
                    'from' => 'departments',
                    'localField' => 'department',
                    'foreignField' => '_id',
                    'as' => 'departmentinfo',
                ],
            ],
            [
                '$unwind' => '$departmentinfo',
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'user_id' => '$_id',
                    'department' => '$departmentinfo.department',
                    'batch' => 1,
                    'name' => 1,
                    'rollnumber' => 1,
                    'address' => 1,
                    'mobile' => 1
                ],
            ]
        ];

        $result = $this->aggregate($pipeline, 'users',$config);

			return $result;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching users: ' . $ex->getMessage(), 500);
		}
	}

	function studentlogin($rollnumber,$mobile) {
		try {
			$filter = ['rollnumber' => $rollnumber , 'mobile'=>$mobile];
			$query = new MongoDB\Driver\Query($filter);
			
			$result = $this->conn->executeQuery($this->database.'.'.$this->user_collection, $query);
			
			
			foreach($result as $user) {
				return $user;
			}
			
			return NULL;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching user: ' . $ex->getMessage(), 500);
		}
	}
	
	function get_user($_id) {
		try {
			$filter = ['_id' => new MongoDB\BSON\ObjectId($_id)];
			$query = new MongoDB\Driver\Query($filter);
			
			$result = $this->conn->executeQuery($this->database.'.'.$this->user_collection, $query);
			
			foreach($result as $user) {
				return $user;
			}
			
			return NULL;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while fetching user: ' . $ex->getMessage(), 500);
		}
	}
	

	function create_user($name, $email) {
		try {
			$user = array(
				'name' => $name,
				'email' => $email
			);
			
			$query = new MongoDB\Driver\BulkWrite();
			$query->insert($user);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->user_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while saving users: ' . $ex->getMessage(), 500);
		}
	}

		function register_student($data) {
		try {
			extract($data);
			$user = array(
					'name' => $name, 
					'mobile' => $mobile,
					'rollnumber' => $rollnumber,
					'batch' => $batch,
					'gender' => $gender,
					'address' => $address,
					'status' => $status,
					'department' => new MongoDB\BSON\ObjectId($department),
					'userType' => 'student',
				);
			
			$query = new MongoDB\Driver\BulkWrite();
			$query->insert($user);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->user_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while saving users: ' . $ex->getMessage(), 500);
		}
	}

		function update_student($data) {
		try {
			extract($data);
			$query = new MongoDB\Driver\BulkWrite();
			$query->update(
				['_id' => new MongoDB\BSON\ObjectId($id)], 
				['$set' => array(
					'name' => $name, 
					'mobile' => $mobile,
					'rollnumber' => $rollnumber,
					'batch' => $batch,
					'gender' => $gender,
					'address' => $address,
					'status' => $status,
					'department' => new MongoDB\BSON\ObjectId($department),
					'userType' => 'student',
				)]
			);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->user_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while updating users: ' . $ex->getMessage(), 500);
		}
	}
	
	function update_user($_id, $name, $email) {
		try {
			$query = new MongoDB\Driver\BulkWrite();
			$query->update(['_id' => new MongoDB\BSON\ObjectId($_id)], ['$set' => array('name' => $name, 'email' => $email)]);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->user_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while updating users: ' . $ex->getMessage(), 500);
		}
	}
	
	function delete_user($_id) {
		try {
			$query = new MongoDB\Driver\BulkWrite();
			$query->delete(['_id' => new MongoDB\BSON\ObjectId($_id)]);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->user_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while deleting users: ' . $ex->getMessage(), 500);
		}
	}

	function delete_student($id) {
		try {
			$query = new MongoDB\Driver\BulkWrite();
			$query->delete(['_id' => new MongoDB\BSON\ObjectId($id)]);
			
			$result = $this->conn->executeBulkWrite($this->database.'.'.$this->user_collection, $query);
			
			if($result == 1) {
				return TRUE;
			}
			
			return FALSE;
		} catch(MongoDB\Driver\Exception\RuntimeException $ex) {
			show_error('Error while deleting users: ' . $ex->getMessage(), 500);
		}
	}
	
}
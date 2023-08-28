<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;

class Login extends CI_Controller {
	 
	function __construct() {
		parent::__construct();
		$this->load->model('usermodel');
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

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    public function adminindex()
    {
       $this->load->view('auth/adminlogin');
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isStudentLoggedIn');
        $isAdminLoggedIn = $this->session->userdata('isAdminLoggedIn');
       
        // print_r($isLoggedIn);    
        // die();
        if(isset($isLoggedIn) && $isLoggedIn == TRUE)
        {
            redirect('student/dashboard');
        }
        elseif(isset($isAdminLoggedIn) && $isAdminLoggedIn == TRUE)
        {
            redirect('admin/dashboard');
        }else{
            $this->load->view('auth/login');
        }
    }

    public function logout(){
        $this->session->sess_destroy();
          redirect('/');
    }


    public function adminlogin(){

        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {

                $CI =& get_instance();
                $CI->config->load('mongodb', TRUE);
                $config = $CI->config->item('mongodb');
                $this->manager = new Manager($config['mongo_connection']);

                $pipeline = [
                        [
                            '$match' => [
                                'username' => $this->input->post('username'),
                                'passsword' => md5($this->input->post('password'))
                            ],
                        ]
                    ];

                    $result = $this->aggregate($pipeline, 'admin',$config);

                // $result = $this->usermodel->studentlogin($this->input->post('rollnumber'), $this->input->post('mobile'));
           
                if($result == TRUE) {
                    $sessionArray = array('_id'=>$result[0]->_id,
                                        'username'=>'Administrator',
                                        'username'=>$result[0]->username,
                                        'isLoggedIn' => TRUE,
                                        'isAdminLoggedIn'=>TRUE
                                );

                $this->session->set_userdata($sessionArray);

               

                    redirect('/admin/dashboard');
                } else {
                    $data['error'] = 'Error occurred during saving data';
                    $this->load->view('auth/adminlogin', $data);
                }
            } else {
                $data['error'] = 'Error occurred during saving data: all fields are required';
                $this->load->view('auth/adminlogin', $data);
            }
        } else {
            $this->load->view('auth/adminlogin');
        }

    }

    public function login(){

        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('rollnumber', 'Roll Number', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {

                $CI =& get_instance();
                $CI->config->load('mongodb', TRUE);
                $config = $CI->config->item('mongodb');
                $this->manager = new Manager($config['mongo_connection']);

                $pipeline = [
                        [
                            '$match' => [
                                'rollnumber' => $this->input->post('rollnumber'),
                                'mobile' => $this->input->post('mobile'),
                                'status' => 'Active'
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
                                '_id' => 1,
                                'user_id' => '$_id',
                                'batch' => 1,
                                'department' => '$departmentinfo',
                                'name' => 1,
                                'gender' => 1,
                                'rollnumber' => 1,
                                'address' => 1,
                                'userType' => 1,
                                'isLoggedIn' => 1,
                                'isStudentLoggedIn' => 1,
                                'mobile' => 1
                            ],
                        ]
                    ];

                    $result = $this->aggregate($pipeline, 'users',$config);

                // $result = $this->usermodel->studentlogin($this->input->post('rollnumber'), $this->input->post('mobile'));
           
                if($result == TRUE) {
                    $sessionArray = array('_id'=>$result[0]->_id,
                                        'name'=>$result[0]->name,
                                        'rollnumber'=>$result[0]->rollnumber,
                                        'department'=>$result[0]->department,
                                        'batch'=>$result[0]->batch,
                                        'gender'=>$result[0]->gender,
                                        'mobile'=>$result[0]->mobile,
                                        'address'=> $result[0]->address,
                                        'userType'=>$result[0]->userType,
                                        'status'=>$result[0]->status,
                                        'isLoggedIn' => TRUE,
                                        'isStudentLoggedIn'=>TRUE
                                );

                $this->session->set_userdata($sessionArray);
                    redirect('/student/dashboard');
                } else {
                    $data['error'] = 'Error occurred during saving data';
                    $this->load->view('auth/login', $data);
                }
            } else {
                $data['error'] = 'Error occurred during saving data: all fields are required';
                $this->load->view('auth/login', $data);
            }
        } else {
            $this->load->view('auth/login');
        }

    }

	
	
}
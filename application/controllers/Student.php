<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;

class Student extends CI_Controller {

	function __construct() {
		parent::__construct();
        $isLoggedIn = $this->session->userdata('isStudentLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('usermodel');

	}
	 
    public function profile()
    {
        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $data['userdata'] =  $this->session->userdata;

         $this->load->view('include/student/header.php',$data);
         $this->load->view('student/profile',$data);
         $this->load->view('include/student/footer.php',$data);
    } 
    public function index()
    {
        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;
        
        $data['userdata'] =  $this->session->userdata;

         $this->load->view('include/student/header.php',$data);
         $this->load->view('student/dashboard',$data);
         $this->load->view('include/student/footer.php',$data);
    }


         
    public function search()
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);
        $userdata = $this->session->userdata;
        $query = $this->input->post();

      
        $filterData = $this->usermodel->student_filter_list($userdata,$config,$query);



                foreach ($filterData as $eachData) {
                        // print_r($eachData);
                        ?>
                <tr>

                <td><?php echo $eachData->rollnumber; ?></td>
                <td><?php echo $eachData->name; ?></td>
                <td><?php echo $eachData->mobile; ?></td>
                <td><?php echo $eachData->address; ?></td>
                </tr>
                <?php
                    }



    }


    
	
}
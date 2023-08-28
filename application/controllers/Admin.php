<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
        $isLoggedIn = $this->session->userdata('isAdminLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('usermodel');
        $this->load->model('batchmodel');
        $this->load->model('departmentmodel');

	}


    public function departmentindex()
    {
        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;
        $departments = $this->departmentmodel->getDepartments($config);
        
        $data['userdata'] =  $this->session->userdata;
        $data['departments'] =  $departments;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/departments',$data);
         $this->load->view('include/admin/footer.php',$data);
    }

    public function departmentadd()
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;

        $departments = $this->departmentmodel->getDepartments($config);

        
        $data['userdata'] =  $this->session->userdata;
        $data['departments'] =  $departments;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/add_department',$data);
         $this->load->view('include/admin/footer.php',$data);
    }


     public function departmentregister()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('department', 'Department', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {
                $result = $this->departmentmodel->register_department($this->input->post());
                if($result === TRUE) {
                    redirect('admin/department');
                } else {
                    $data['error'] = 'Error occurred during add data';
                    $this->load->view('admin/add_department', $data);
                }
            } else {
                $data['error'] = 'error occurred during saving data: all fields are mandatory';
                $this->load->view('admin/add_department', $data);
            }
        } else {
            $this->load->view('admin/add_department');
        }
    }

    public function departmentedit($id=null)
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;

        $departments = $this->departmentmodel->getDepartments($config,$id);
       
        $data['userdata'] =  $this->session->userdata;
        $data['departments'] =  $departments;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/edit_department',$data);
         $this->load->view('include/admin/footer.php',$data);
    }

    public function departmentupdate()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('department', 'Department', 'trim|required');


            if ($this->form_validation->run() !== FALSE) {
                $result = $this->departmentmodel->update_department($this->input->post());
                if($result === TRUE) {
                    redirect('admin/department');
                } else {
                    $data['error'] = 'Error occurred during updating data';
                    $this->load->view('admin/edit_department', $data);
                }
            } else {
                $data['error'] = 'error occurred during saving data: all fields are mandatory';
                $this->load->view('admin/edit_department', $data);
            }
        } else {
            $data['user'] = $this->departmentmodel->get_user($_id);
            $this->load->view('admin/edit_department', $data);
        }
    }

    public function departmentdelete($id) 
    {
        if ($id) {
            $this->departmentmodel->delete_department($id);
        }
        redirect('admin/department');
    }


	  
    public function batchindex()
    {
        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;
        $batches = $this->batchmodel->getBatches($config);
        
        $data['userdata'] =  $this->session->userdata;
        $data['batches'] =  $batches;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/batches',$data);
         $this->load->view('include/admin/footer.php',$data);
    }

    public function batchadd()
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;

        $nextRoll = $this->usermodel->getnextRollnumber($config);
        $batches = $this->batchmodel->getBatches($config);

        
        $data['userdata'] =  $this->session->userdata;
        $data['batches'] =  $batches;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/add_batch',$data);
         $this->load->view('include/admin/footer.php',$data);
    }


     public function batchregister()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('batch', 'Batch Year', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {
                $result = $this->batchmodel->register_batch($this->input->post());
                if($result === TRUE) {
                    redirect('admin/batch');
                } else {
                    $data['error'] = 'Error occurred during add data';
                    $this->load->view('admin/add_batch', $data);
                }
            } else {
                $data['error'] = 'error occurred during saving data: all fields are mandatory';
                $this->load->view('admin/add_batch', $data);
            }
        } else {
            $this->load->view('admin/add_batch');
        }
    }

    public function batchedit($id=null)
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;

        $batches = $this->batchmodel->getBatches($config,$id);

       
        $data['userdata'] =  $this->session->userdata;
        $data['batches'] =  $batches;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/edit_batch',$data);
         $this->load->view('include/admin/footer.php',$data);
    }

    public function batchupdate()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('batch', 'Batch Year', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {
                $result = $this->batchmodel->update_batch($this->input->post());
                if($result === TRUE) {
                    redirect('admin/batch');
                } else {
                    $data['error'] = 'Error occurred during updating data';
                    $this->load->view('admin/edit_batch', $data);
                }
            } else {
                $data['error'] = 'error occurred during saving data: all fields are mandatory';
                $this->load->view('admin/edit_batch', $data);
            }
        } else {
            $data['user'] = $this->batchmodel->get_user($_id);
            $this->load->view('admin/edit_batch', $data);
        }
    }

    public function batchdelete($id) 
    {
        if ($id) {
            $this->batchmodel->delete_batch($id);
        }
        redirect('admin/batch');
    }


  
    public function index()
    {
        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;
        
        $data['userdata'] =  $this->session->userdata;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/dashboard',$data);
         $this->load->view('include/admin/footer.php',$data);
    }

      
    public function studentadd()
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;

        $nextRoll = $this->usermodel->getnextRollnumber($config);
        $batches = $this->batchmodel->getBatches($config);
        $departments = $this->departmentmodel->getDepartments($config);

        
        $data['userdata'] =  $this->session->userdata;
        $data['batches'] =  $batches;
        $data['nextRoll'] =  $nextRoll;
        $data['departments'] =  $departments;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/add_student',$data);
         $this->load->view('include/admin/footer.php',$data);
    }

   
  
    public function studentedit($id=null)
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);

        $userdata = $this->session->userdata;

        $studentData = $this->usermodel->getStudent($id,$config);
        $batches = $this->batchmodel->getBatches($config);
        $departments = $this->departmentmodel->getDepartments($config);

       
        
        $data['userdata'] =  $this->session->userdata;
        $data['studentData'] =  $studentData;
        $data['batches'] =  $batches;
        $data['departments'] =  $departments;

         $this->load->view('include/admin/header.php',$data);
         $this->load->view('admin/edit_student',$data);
         $this->load->view('include/admin/footer.php',$data);
    }


    public function studentregister()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
            $this->form_validation->set_rules('rollnumber', 'Rollnumber', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {
                $result = $this->usermodel->register_student($this->input->post());
                if($result === TRUE) {
                    redirect('/');
                } else {
                    $data['error'] = 'Error occurred during add data';
                    $this->load->view('admin/add_student', $data);
                }
            } else {
                $data['error'] = 'error occurred during saving data: all fields are mandatory';
                $this->load->view('admin/add_student', $data);
            }
        } else {
            $this->load->view('admin/add_student');
        }
    }


    public function studentdelete($id) 
    {
        if ($id) {
            $this->usermodel->delete_student($id);
        }
        redirect('/');
    }



    public function studentupdate()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
            $this->form_validation->set_rules('rollnumber', 'Rollnumber', 'trim|required');

            if ($this->form_validation->run() !== FALSE) {
                $result = $this->usermodel->update_student($this->input->post());
                if($result === TRUE) {
                    redirect('/');
                } else {
                    $data['error'] = 'Error occurred during updating data';
                    $this->load->view('admin/edit_student', $data);
                }
            } else {
                $data['error'] = 'error occurred during saving data: all fields are mandatory';
                $this->load->view('admin/edit_student', $data);
            }
        } else {
            $data['user'] = $this->usermodel->get_user($_id);
            $this->load->view('admin/edit_student', $data);
        }
    }


         
    public function studentsearch()
    {

        $CI =& get_instance();
        $CI->config->load('mongodb', TRUE);
        $config = $CI->config->item('mongodb');
        $this->manager = new Manager($config['mongo_connection']);
        $userdata = $this->session->userdata;
        $query = $this->input->post();

      
        $filterData = $this->usermodel->admin_student_filter_list($userdata,$config,$query);

                        // print_r($filterData);
                foreach ($filterData as $eachData) {
                        ?>
                <tr>

                <td><?php echo $eachData->rollnumber; ?></td>
                <td><?php echo $eachData->name; ?></td>
                <td><?php echo $eachData->batch; ?></td>
                <td><?php echo $eachData->department; ?></td>
                <td><?php echo $eachData->mobile; ?></td>
                <td><?php echo $eachData->address; ?></td>
                <td>
                    <div class="amoutn_action d-flex align-items-center">
                    <div class="dropdown ms-4">
                    <a class=" dropdown-toggle hide_pils" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div style="padding:13px" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                   
                    <?php echo anchor('/student/edit/' . $eachData->_id, 'Edit'); ?>
                    <br/>
                    <?php echo anchor('/admin/studentdelete/' . $eachData->_id, 'Delete', array('onclick' => "return confirm('Do you want delete this record')")); ?>
                    </div>
                    </div>
                    </div> </td>
                </tr>
                <?php
                    }



    }


    
	
}
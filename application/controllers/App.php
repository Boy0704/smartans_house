<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public $image = '';
	
	public function index()
	{
        if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function admin()
	{
        // if ($this->session->userdata('username') == '') {
        //     redirect('app/login');
        // }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function power_usage()
    {
    	if ($_GET) {
    		$data = array(
				'konten' => 'detail_power_usage',
	            'judul_page' => 'Power Usage',
			);
			$this->load->view('v_index', $data);
    	}else{
    		$data = array(
				'konten' => 'power_usage',
	            'judul_page' => 'Power Usage',
			);
			$this->load->view('v_index', $data);
    	}
    }

    public function water_usage()
    {
    	if ($_GET) {
    		$data = array(
				'konten' => 'detail_water_usage',
	            'judul_page' => 'Water Usage',
			);
			$this->load->view('v_index', $data);
    	}else{
    		$data = array(
				'konten' => 'water_usage',
	            'judul_page' => 'Water Usage',
			);
			$this->load->view('v_index', $data);
    	}
    }

   
	

	

	
}

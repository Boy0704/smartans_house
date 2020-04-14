<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartans_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Smartans_user_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartans_user/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartans_user/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartans_user/index.html';
            $config['first_url'] = base_url() . 'smartans_user/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartans_user_model->total_rows($q);
        $smartans_user = $this->Smartans_user_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'smartans_user_data' => $smartans_user,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'smartans_user/smartans_user_list',
            'konten' => 'smartans_user/smartans_user_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Smartans_user_model->get_by_id($id);
        if ($row) {
            $data = array(
		'ID_USER' => $row->ID_USER,
		'EMAIL' => $row->EMAIL,
		'PASSWORD' => $row->PASSWORD,
		'FIRST_NAME' => $row->FIRST_NAME,
		'LAST_NAME' => $row->LAST_NAME,
		'MOBILE_NO' => $row->MOBILE_NO,
		'LOCATION_ID' => $row->LOCATION_ID,
		'ROOM_ID' => $row->ROOM_ID,
		'ACTIVE_FLAG' => $row->ACTIVE_FLAG,
		'LEVEL' => $row->LEVEL,
	    );
            $this->load->view('smartans_user/smartans_user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_user'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'smartans_user/smartans_user_form',
            'konten' => 'smartans_user/smartans_user_form',
            'button' => 'Create',
            'action' => site_url('smartans_user/create_action'),
	    'ID_USER' => set_value('ID_USER'),
	    'EMAIL' => set_value('EMAIL'),
	    'PASSWORD' => set_value('PASSWORD'),
	    'FIRST_NAME' => set_value('FIRST_NAME'),
	    'LAST_NAME' => set_value('LAST_NAME'),
	    'MOBILE_NO' => set_value('MOBILE_NO'),
	    'LOCATION_ID' => set_value('LOCATION_ID'),
	    'ROOM_ID' => set_value('ROOM_ID'),
	    'ACTIVE_FLAG' => set_value('ACTIVE_FLAG'),
	    'LEVEL' => set_value('LEVEL'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'EMAIL' => $this->input->post('EMAIL',TRUE),
		'PASSWORD' => md5($this->input->post('PASSWORD',TRUE)),
		'FIRST_NAME' => $this->input->post('FIRST_NAME',TRUE),
		'LAST_NAME' => $this->input->post('LAST_NAME',TRUE),
		'MOBILE_NO' => $this->input->post('MOBILE_NO',TRUE),
		'LOCATION_ID' => $this->input->post('LOCATION_ID',TRUE),
		'ROOM_ID' => $this->input->post('ROOM_ID',TRUE),
		'ACTIVE_FLAG' => $this->input->post('ACTIVE_FLAG',TRUE),
		'LEVEL' => $this->input->post('LEVEL',TRUE),
	    );

            $this->Smartans_user_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('smartans_user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Smartans_user_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'smartans_user/smartans_user_form',
                'konten' => 'smartans_user/smartans_user_form',
                'button' => 'Update',
                'action' => site_url('smartans_user/update_action'),
		'ID_USER' => set_value('ID_USER', $row->ID_USER),
		'EMAIL' => set_value('EMAIL', $row->EMAIL),
		'PASSWORD' => md5(set_value('PASSWORD', $row->PASSWORD)),
		'FIRST_NAME' => set_value('FIRST_NAME', $row->FIRST_NAME),
		'LAST_NAME' => set_value('LAST_NAME', $row->LAST_NAME),
		'MOBILE_NO' => set_value('MOBILE_NO', $row->MOBILE_NO),
		'LOCATION_ID' => set_value('LOCATION_ID', $row->LOCATION_ID),
		'ROOM_ID' => set_value('ROOM_ID', $row->ROOM_ID),
		'ACTIVE_FLAG' => set_value('ACTIVE_FLAG', $row->ACTIVE_FLAG),
		'LEVEL' => set_value('LEVEL', $row->LEVEL),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_user'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('ID_USER', TRUE));
        } else {
            $data = array(
		'EMAIL' => $this->input->post('EMAIL',TRUE),
		'PASSWORD' => $this->input->post('PASSWORD',TRUE),
		'FIRST_NAME' => $this->input->post('FIRST_NAME',TRUE),
		'LAST_NAME' => $this->input->post('LAST_NAME',TRUE),
		'MOBILE_NO' => $this->input->post('MOBILE_NO',TRUE),
		'LOCATION_ID' => $this->input->post('LOCATION_ID',TRUE),
		'ROOM_ID' => $this->input->post('ROOM_ID',TRUE),
		'ACTIVE_FLAG' => $this->input->post('ACTIVE_FLAG',TRUE),
		'LEVEL' => $this->input->post('LEVEL',TRUE),
	    );

            $this->Smartans_user_model->update($this->input->post('ID_USER', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('smartans_user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Smartans_user_model->get_by_id($id);

        if ($row) {
            $this->Smartans_user_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('smartans_user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_user'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('EMAIL', 'email', 'trim|required');
	$this->form_validation->set_rules('PASSWORD', 'password', 'trim|required');
	$this->form_validation->set_rules('FIRST_NAME', 'first name', 'trim|required');
	$this->form_validation->set_rules('LAST_NAME', 'last name', 'trim|required');
	$this->form_validation->set_rules('MOBILE_NO', 'mobile no', 'trim|required');
	$this->form_validation->set_rules('LOCATION_ID', 'location id', 'trim|required');
	$this->form_validation->set_rules('ROOM_ID', 'room id', 'trim|required');
	$this->form_validation->set_rules('ACTIVE_FLAG', 'active flag', 'trim|required');
	$this->form_validation->set_rules('LEVEL', 'level', 'trim|required');

	$this->form_validation->set_rules('ID_USER', 'ID_USER', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Smartans_user.php */
/* Location: ./application/controllers/Smartans_user.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-04-09 12:23:44 */
/* https://jualkoding.com */
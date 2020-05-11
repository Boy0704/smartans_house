<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartans_location extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Smartans_location_model');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartans_location/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartans_location/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartans_location/index.html';
            $config['first_url'] = base_url() . 'smartans_location/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartans_location_model->total_rows($q);
        $smartans_location = $this->Smartans_location_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'smartans_location_data' => $smartans_location,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'smartans_location/smartans_location_list',
            'konten' => 'smartans_location/smartans_location_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Smartans_location_model->get_by_id($id);
        if ($row) {
            $data = array(
		'ID' => $row->ID,
		'LOCATION_ID' => $row->LOCATION_ID,
		'LOCATION_NAME' => $row->LOCATION_NAME,
	    );
            $this->load->view('smartans_location/smartans_location_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_location'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'smartans_location/smartans_location_form',
            'konten' => 'smartans_location/smartans_location_form',
            'button' => 'Create',
            'action' => site_url('smartans_location/create_action'),
	    'ID' => set_value('ID'),
	    'LOCATION_ID' => set_value('LOCATION_ID'),
        'LOCATION_NAME' => set_value('LOCATION_NAME'),
        'LOCATION_ADDRESS' => set_value('LOCATION_ADDRESS'),
        'ACTIVE_FLAG' => set_value('ACTIVE_FLAG'),
        'PAYGATE_FLAG' => set_value('PAYGATE_FLAG'),
	    'DUE_DATE' => set_value('DUE_DATE'),
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
		'LOCATION_ID' => $this->input->post('LOCATION_ID',TRUE),
        'LOCATION_NAME' => $this->input->post('LOCATION_NAME',TRUE),
        'LOCATION_ADDRESS' => $this->input->post('LOCATION_ADDRESS',TRUE),
        'ACTIVE_FLAG' => $this->input->post('ACTIVE_FLAG',TRUE),
        'PAYGATE_FLAG' => $this->input->post('PAYGATE_FLAG',TRUE),
		'DUE_DATE' => $this->input->post('DUE_DATE',TRUE),
	    );

            $this->Smartans_location_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('smartans_location'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Smartans_location_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'smartans_location/smartans_location_form',
                'konten' => 'smartans_location/smartans_location_form',
                'button' => 'Update',
                'action' => site_url('smartans_location/update_action'),
		'ID' => set_value('ID', $row->ID),
		'LOCATION_ID' => set_value('LOCATION_ID', $row->LOCATION_ID),
        'LOCATION_NAME' => set_value('LOCATION_NAME', $row->LOCATION_NAME),
        'LOCATION_ADDRESS' => set_value('LOCATION_ADDRESS', $row->LOCATION_ADDRESS),
        'ACTIVE_FLAG' => set_value('ACTIVE_FLAG', $row->ACTIVE_FLAG),
        'PAYGATE_FLAG' => set_value('PAYGATE_FLAG', $row->PAYGATE_FLAG),
		'DUE_DATE' => set_value('DUE_DATE', $row->DUE_DATE),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_location'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('ID', TRUE));
        } else {
            $data = array(
		'LOCATION_ID' => $this->input->post('LOCATION_ID',TRUE),
        'LOCATION_NAME' => $this->input->post('LOCATION_NAME',TRUE),
        'LOCATION_ADDRESS' => $this->input->post('LOCATION_ADDRESS',TRUE),
        'ACTIVE_FLAG' => $this->input->post('ACTIVE_FLAG',TRUE),
        'PAYGATE_FLAG' => $this->input->post('PAYGATE_FLAG',TRUE),
		'DUE_DATE' => $this->input->post('DUE_DATE',TRUE),
	    );

            $this->Smartans_location_model->update($this->input->post('ID', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('smartans_location'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Smartans_location_model->get_by_id($id);

        if ($row) {
            $this->Smartans_location_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('smartans_location'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_location'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('LOCATION_ID', 'location id', 'trim|required');
	$this->form_validation->set_rules('LOCATION_NAME', 'location name', 'trim|required');

	$this->form_validation->set_rules('ID', 'ID', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Smartans_location.php */
/* Location: ./application/controllers/Smartans_location.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-04-09 12:43:04 */
/* https://jualkoding.com */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartans_room extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Smartans_room_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartans_room/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartans_room/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartans_room/index.html';
            $config['first_url'] = base_url() . 'smartans_room/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartans_room_model->total_rows($q);
        $smartans_room = $this->Smartans_room_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'smartans_room_data' => $smartans_room,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'smartans_room/smartans_room_list',
            'konten' => 'smartans_room/smartans_room_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Smartans_room_model->get_by_id($id);
        if ($row) {
            $data = array(
		'ID' => $row->ID,
		'LOCATION_ID' => $row->LOCATION_ID,
		'ROOM_ID' => $row->ROOM_ID,
		'ROOM_NAME' => $row->ROOM_NAME,
	    );
            $this->load->view('smartans_room/smartans_room_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_room'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'smartans_room/smartans_room_form',
            'konten' => 'smartans_room/smartans_room_form',
            'button' => 'Create',
            'action' => site_url('smartans_room/create_action'),
	    'ID' => set_value('ID'),
	    'LOCATION_ID' => set_value('LOCATION_ID'),
	    'ROOM_ID' => set_value('ROOM_ID'),
	    'ROOM_NAME' => set_value('ROOM_NAME'),
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
		'ROOM_ID' => $this->input->post('ROOM_ID',TRUE),
		'ROOM_NAME' => $this->input->post('ROOM_NAME',TRUE),
	    );

            $this->Smartans_room_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('smartans_room'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Smartans_room_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'smartans_room/smartans_room_form',
                'konten' => 'smartans_room/smartans_room_form',
                'button' => 'Update',
                'action' => site_url('smartans_room/update_action'),
		'ID' => set_value('ID', $row->ID),
		'LOCATION_ID' => set_value('LOCATION_ID', $row->LOCATION_ID),
		'ROOM_ID' => set_value('ROOM_ID', $row->ROOM_ID),
		'ROOM_NAME' => set_value('ROOM_NAME', $row->ROOM_NAME),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_room'));
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
		'ROOM_ID' => $this->input->post('ROOM_ID',TRUE),
		'ROOM_NAME' => $this->input->post('ROOM_NAME',TRUE),
	    );

            $this->Smartans_room_model->update($this->input->post('ID', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('smartans_room'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Smartans_room_model->get_by_id($id);

        if ($row) {
            $this->Smartans_room_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('smartans_room'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_room'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('LOCATION_ID', 'location id', 'trim|required');
	$this->form_validation->set_rules('ROOM_ID', 'room id', 'trim|required');
	$this->form_validation->set_rules('ROOM_NAME', 'room name', 'trim|required');

	$this->form_validation->set_rules('ID', 'ID', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Smartans_room.php */
/* Location: ./application/controllers/Smartans_room.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-04-09 12:43:10 */
/* https://jualkoding.com */
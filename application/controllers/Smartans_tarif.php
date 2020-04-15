<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartans_tarif extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Smartans_tarif_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartans_tarif/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartans_tarif/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartans_tarif/index.html';
            $config['first_url'] = base_url() . 'smartans_tarif/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartans_tarif_model->total_rows($q);
        $smartans_tarif = $this->Smartans_tarif_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'smartans_tarif_data' => $smartans_tarif,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'smartans_tarif/smartans_tarif_list',
            'konten' => 'smartans_tarif/smartans_tarif_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Smartans_tarif_model->get_by_id($id);
        if ($row) {
            $data = array(
		'ID_TARIF' => $row->ID_TARIF,
		'LOCATION_ID' => $row->LOCATION_ID,
		'ROOM_NO' => $row->ROOM_NO,
		'TARIF_ROOM' => $row->TARIF_ROOM,
		'TARIF_LISTRIK' => $row->TARIF_LISTRIK,
		'TARIF_AIR' => $row->TARIF_AIR,
	    );
            $this->load->view('smartans_tarif/smartans_tarif_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_tarif'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'smartans_tarif/smartans_tarif_form',
            'konten' => 'smartans_tarif/smartans_tarif_form',
            'button' => 'Create',
            'action' => site_url('smartans_tarif/create_action'),
	    'ID_TARIF' => set_value('ID_TARIF'),
	    'LOCATION_ID' => set_value('LOCATION_ID'),
	    'ROOM_NO' => set_value('ROOM_NO'),
	    'TARIF_ROOM' => set_value('TARIF_ROOM'),
	    'TARIF_LISTRIK' => set_value('TARIF_LISTRIK'),
        'TARIF_AIR' => set_value('TARIF_AIR'),
        'START_DATE' => set_value('START_DATE'),
	    'END_DATE' => set_value('END_DATE'),
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
		'ROOM_NO' => $this->input->post('ROOM_NO',TRUE),
		'TARIF_ROOM' => $this->input->post('TARIF_ROOM',TRUE),
		'TARIF_LISTRIK' => $this->input->post('TARIF_LISTRIK',TRUE),
        'TARIF_AIR' => $this->input->post('TARIF_AIR',TRUE),
        'START_DATE' => $this->input->post('START_DATE',TRUE),
		'END_DATE' => $this->input->post('END_DATE',TRUE),
	    );

            $this->Smartans_tarif_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('smartans_tarif'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Smartans_tarif_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'smartans_tarif/smartans_tarif_form',
                'konten' => 'smartans_tarif/smartans_tarif_form',
                'button' => 'Update',
                'action' => site_url('smartans_tarif/update_action'),
		'ID_TARIF' => set_value('ID_TARIF', $row->ID_TARIF),
		'LOCATION_ID' => set_value('LOCATION_ID', $row->LOCATION_ID),
		'ROOM_NO' => set_value('ROOM_NO', $row->ROOM_NO),
		'TARIF_ROOM' => set_value('TARIF_ROOM', $row->TARIF_ROOM),
		'TARIF_LISTRIK' => set_value('TARIF_LISTRIK', $row->TARIF_LISTRIK),
        'TARIF_AIR' => set_value('TARIF_AIR', $row->TARIF_AIR),
        'START_DATE' => set_value('START_DATE', $row->START_DATE),
		'END_DATE' => set_value('END_DATE', $row->END_DATE),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_tarif'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('ID_TARIF', TRUE));
        } else {
            $data = array(
		'LOCATION_ID' => $this->input->post('LOCATION_ID',TRUE),
		'ROOM_NO' => $this->input->post('ROOM_NO',TRUE),
		'TARIF_ROOM' => $this->input->post('TARIF_ROOM',TRUE),
		'TARIF_LISTRIK' => $this->input->post('TARIF_LISTRIK',TRUE),
        'TARIF_AIR' => $this->input->post('TARIF_AIR',TRUE),
        'START_DATE' => $this->input->post('START_DATE',TRUE),
		'END_DATE' => $this->input->post('END_DATE',TRUE),
	    );

            $this->Smartans_tarif_model->update($this->input->post('ID_TARIF', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('smartans_tarif'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Smartans_tarif_model->get_by_id($id);

        if ($row) {
            $this->Smartans_tarif_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('smartans_tarif'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('smartans_tarif'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('LOCATION_ID', 'location id', 'trim|required');
	$this->form_validation->set_rules('ROOM_NO', 'room no', 'trim|required');
	$this->form_validation->set_rules('TARIF_ROOM', 'tarif room', 'trim|required');
	$this->form_validation->set_rules('TARIF_LISTRIK', 'tarif listrik', 'trim|required');
	$this->form_validation->set_rules('TARIF_AIR', 'tarif air', 'trim|required');

	$this->form_validation->set_rules('ID_TARIF', 'ID_TARIF', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Smartans_tarif.php */
/* Location: ./application/controllers/Smartans_tarif.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-04-09 12:46:58 */
/* https://jualkoding.com */
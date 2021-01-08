<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mahasiswa_model');
    }

    public function index()
    {
        $this->load->view('mahasiswa_view');
    }

    public function ajax_list()
    {
        $list = $this->mahasiswa_model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $mhs) {
            $no++;
            $row = array();
            $row[] = null;
            $row[] = $mhs->nim;
            $row[] = $mhs->nama;
            $row[] = $mhs->jenis_kelamin;
            $row[] = $mhs->jurusan;
            $row[] = $mhs->tanggal_lahir;

            $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit" onclick="edit_mahasiswa(' . "'" . $mhs->id . "'" . ')">Ubah</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_mahasiswa(' . "'" . $mhs->id . "'" . ')">Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mahasiswa_model->count_all(),
            "recordsFiltered" => $this->mahasiswa_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = [
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'jurusan' => $this->input->post('jurusan'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir')
        ];
        $insert = $this->mahasiswa_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->mahasiswa_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = [
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'jurusan' => $this->input->post('jurusan'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir')
        ];
        $this->mahasiswa_model->update($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->mahasiswa_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['input_error'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nim') == '') {
            $data['input_error'][] = 'nim';
            $data['error_string'][] = 'NIM tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('nama') == '') {
            $data['input_error'][] = 'nama';
            $data['error_string'][] = 'Nama tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('jenis_kelamin') == '') {
            $data['input_error'][] = 'jenis_kelamin';
            $data['error_string'][] = 'Jenis Kelamin tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('jurusan') == '') {
            $data['input_error'][] = 'jurusan';
            $data['error_string'][] = 'Jurusan tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('tanggal_lahir') == '') {
            $data['input_error'][] = 'tanggal_lahir';
            $data['error_string'][] = 'Tanggal Lahir tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit;
        }
    }
}

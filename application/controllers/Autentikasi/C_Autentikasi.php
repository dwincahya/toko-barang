<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Autentikasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Autentikasi/M_Pengguna');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('toko-barang');
        }

        $this->form_validation->set_rules('nama', 'Nama / Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login System';
            $data['content_view'] = 'Autentikasi/V_Index';
            $this->load->view('Layout/V_Index', $data);
        } else {
            $nama     = $this->input->post('nama', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->M_Pengguna->login($nama, $password);

            if ($user) {
                $session_data = [
                    'nomor_induk'    => $user->nomor_induk,
                    'nama'           => $user->nama,
                    'nama_lengkap'   => $user->nama_lengkap,
                    'responsibility' => $user->responsibility,
                    'logged_in'      => TRUE
                ];
                $this->session->set_userdata($session_data);
                redirect('toko-barang');
            } else {
                $this->session->set_flashdata('error', 'Nama Pengguna atau Password salah!');
                redirect('login');
            }
        }
    }

    public function register()
    {
        if ($this->input->method() !== 'post') {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(405)
                ->set_output(json_encode(['status' => false, 'message' => 'Method Not Allowed']));
            return;
        }

        $nomor_induk    = $this->input->post('nomor_induk', TRUE);
        $nama           = $this->input->post('nama', TRUE);
        $nama_lengkap   = $this->input->post('nama_lengkap', TRUE);
        $password       = $this->input->post('password', TRUE);
        $responsibility = $this->input->post('responsibility', TRUE);

        if (empty($nama) || empty($password)) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['status' => false, 'message' => 'Nama dan Password wajib diisi!']));
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'nomor_induk'    => $nomor_induk ?? '12345',
            'nama'           => $nama,
            'nama_lengkap'   => $nama_lengkap ?? $nama,
            'password'       => $hashed_password,
            'responsibility' => $responsibility ?? 'admin'
        ];

        $insert = $this->db->insert('pengguna', $data);

        if ($insert) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(201)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'User berhasil dibuat!',
                    'data'    => [
                        'nama' => $nama,
                        'responsibility' => $data['responsibility']
                    ]
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['status' => false, 'message' => 'Gagal menyimpan ke database.']));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}

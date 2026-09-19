<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pengguna extends CI_Model {

    private $table = 'pengguna';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login($nama, $password)
    {
        $user = $this->db->get_where($this->table, ['nama' => $nama])->row();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }
}
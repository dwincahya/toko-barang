<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_tokobarang_tables extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'nomor_induk' => array(
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
                'null'           => FALSE,
            ),
            'nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => FALSE,
                'unique'     => TRUE,
            ),
            'password' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'nama_lengkap' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'responsibility' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'admin',
                'null'       => FALSE,
            ),
            'created_at' => array(
                'type'    => 'TIMESTAMP',
                'default' => NULL, 
            ),
        ));
        $this->dbforge->add_key('nomor_induk', TRUE);
        $this->dbforge->create_table('pengguna');

        $data_user = [
            'nama'           => 'Admin',
            'password'       => password_hash('Admin123', PASSWORD_BCRYPT),
            'nama_lengkap'   => 'Administrator',
            'responsibility' => 'admin'
        ];
        $this->db->insert('pengguna', $data_user);


        $this->dbforge->add_field(array(
            'nomor_barang' => array(
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
                'null'           => FALSE,
            ),
            'nama_barang' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'harga' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'stok' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'kategori' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE,
            ),
        ));
        $this->dbforge->add_key('nomor_barang', TRUE); 
        $this->dbforge->create_table('barang');


        $this->dbforge->add_field(array(
            'nomor_penjualan' => array(
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
                'null'           => FALSE,
            ),
            'nomor_barang' => array(
                'type'     => 'INT',
                'unsigned' => TRUE,
                'null'     => FALSE,
            ),
            'nama_barang' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'jumlah' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'harga' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'pembeli' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'alamat_pembeli' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'telepon_pembeli' => array(
                'type'       => 'VARCHAR', 
                'constraint' => '20',
                'null'       => FALSE,
            ),
            'tanggal' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        ));
        $this->dbforge->add_key('nomor_penjualan', TRUE);
        $this->dbforge->create_table('riwayat_penjualan');


        $this->dbforge->add_field(array(
            'nomor_pembelian' => array( 
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
                'null'           => FALSE,
            ),
            'nama_barang' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'nomor_induk' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE,
            ),
            'stok' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'harga' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'vendor' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE,
            ),
            'tanggal' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        ));
        $this->dbforge->add_key('nomor_pembelian', TRUE); 
        $this->dbforge->create_table('riwayat_pembelian_barang');
    }

    public function down()
    {
        $this->dbforge->drop_table('riwayat_pembelian_barang', TRUE);
        $this->dbforge->drop_table('riwayat_penjualan', TRUE);
        $this->dbforge->drop_table('barang', TRUE);
        $this->dbforge->drop_table('pengguna', TRUE);
    }
}
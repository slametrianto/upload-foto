<?php
class Mahasiswa extends CI_Controller
{
    public function index()
    {
        $data['mahasiswa'] = $this->maha->tampil_data()->result();

        $this->load->view('templates/sidebar');
        $this->load->view('templates/header');
        $this->load->view('templates/footer');
        $this->load->view('mahasiswa', $data);
    }


    public function tambah_aksi()
    {
        $nama = $this->input->post('nama');
        $nim = $this->input->post('nim');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $jurusan = $this->input->post('jurusan');
        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');
        $no_tlp = $this->input->post('no_tlp');
        $foto = $_FILES['foto'];
        if ($foto = '') {
        } else {
            //folder untuk mengupload foto
            $config['upload_path'] = './assets/poto';
            //file yg diizinkan untuk diupload
            $config['allowed_types'] = 'jpg|png|gif';

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                echo "Upload gagal ";
                die();
            } else {
                $foto = $this->upload->data('file_name');
            }
        }

        $data = array(
            'nama' => $nama,
            'nim' => $nim,
            'tgl_lahir' => $tgl_lahir,
            'jurusan' => $jurusan,
            'alamat' => $alamat,
            'email' => $email,
            'no_tlp' => $no_tlp,
            'foto' => $foto

        );

        $this->maha->input_data($data, 'tb_mahasiswa');
        redirect('mahasiswa/index');
    }

    public function hapus($id)
    {

        $where = array('id' => $id);
        $this->maha->hapus_data($where, 'tb_mahasiswa');
        redirect('mahasiswa/index');
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data['mahasiswa'] = $this->maha->edit_data($where, 'tb_mahasiswa')->result();

        $this->load->view('templates/sidebar');
        $this->load->view('templates/header');
        $this->load->view('templates/footer');
        $this->load->view('edit', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $nim = $this->input->post('nim');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $jurusan = $this->input->post('jurusan');

        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');
        $no_tlp = $this->input->post('no_tlp');


        $data = array(
            'nama' => $nama,
            'nim' => $nim,
            'tgl_lahir' => $tgl_lahir,
            'jurusan' => $jurusan,

            'alamat' => $alamat,
            'email' => $email,
            'no_tlp' => $no_tlp


        );
        $where = array(
            'id' => $id
        );
        $this->maha->update_data($where, $data, 'tb_mahasiswa');
        redirect('mahasiswa/index');
    }

    public function detail($id)
    {
        $this->load->model('maha');
        $detail = $this->maha->detail_data($id);
        $data['detail'] = $detail;

        $this->load->view('templates/sidebar');
        $this->load->view('templates/header');
        $this->load->view('templates/footer');
        $this->load->view('detail', $data);
    }

    public function print()
    {
        $data['mahasiswa'] = $this->maha->tampil_data('tb_mahasiswa')->result();
        $this->load->view('print_mahasiswa', $data);
    }
}

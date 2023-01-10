<?php
defined('BASEPATH')or exit('No direct script access allowed');
class M_dashboard extends CI_Model{


    public function get_data_kk_all($limit, $start){
        return $this->db->get('tbl_kk', $limit, $start)->result();
    }

    public function get_data_kk_no($no){
        return $this->db->get_where('tbl_kk',['id_kk' => $no])->row();
    }

    public function get_kk_all(){
        return $this->db->get('tbl_kk')->result();
    }

    public function get_anggota_kk_all($id_kk){
        return $this->db->get_where('tbl_anggota_kk',['id_kk' => $id_kk])->result();
    }


    public function cari($keyword){
        $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_kk.no_kk LIKE '%$keyword%' OR tbl_anggota_kk.nik LIKE '%$keyword%' OR tbl_anggota_kk.nama_lengkap LIKE '%$keyword%' ";
        return $this->db->query($q)->result();
    }


    public function add_data(){
        $data_kk = [
            'no_kk' => $this->input->post('nokk'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'alamat' => $this->input->post('alamat'),
            'ket_bantuan' => $this->input->post('bantuan'),
            'ket_rumah' => $this->input->post('rumah'),
            'tahun_bantuan' => $this->input->post('thnbantuan'),
            'status_rumah' => $this->input->post('status_rumah'),
            'no_rumah_baru' => $this->input->post('no_new'),
            'alamat_domisili' => $this->input->post('alamat_domisili')
        ];

        


        if($this->db->insert('tbl_kk', $data_kk)){
            
            $id_kk = $this->db->get_where('tbl_kk',['no_kk' => $this->input->post('nokk')])->row()->id_kk;

            $no_kk = $id_kk;
            $nama = $_POST['nama'];
            $nik = $_POST['nik'];
            $jk = $_POST['jk'];
            $tahun_lahir = $_POST['th'];
            // $umur = $_POST['umur'];
            $data_anggota_kk = array();

            $index = count($nik);

            for($i=0; $i<$index; $i++){
                $u = date('Y') - $tahun_lahir[$i];
                if($u < 17){
                    //anak
                    $umur = 'Anak';
                } else if($u >= 17 & $u <60){
                    //dewasa
                    $umur = 'Dewasa';
                } else if($u >= 60){
                    //lansia
                    $umur = 'Lansia';
                }

                array_push($data_anggota_kk, array(
                    'nik' => $nik[$i],
                    'id_kk' => $no_kk,
                    'nama_lengkap' => $nama[$i],
                    'tahun_lahir' => $tahun_lahir[$i],
                    'jk' => $jk[$i],
                    'umur' => $umur
                ));
            }

            if($this->db->insert_batch('tbl_anggota_kk', $data_anggota_kk)){
                $this->session->set_flashdata('scs_msg','Data baru berhasil di tambahkan');
        redirect('dashboard');
            } else {
                $this->session->set_flashdata('err_msg','Data baru gagal di tambahkan');
        redirect('dashboard');
            }

        } else {
            $this->session->set_flashdata('err_msg','Terjadi kesalahan, harap coba kembali');
        redirect('dashboard');
        }
    }

    public function edit_data_kk($no){
        $data_kk = [
            'no_kk' => $this->input->post('nokk'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'alamat' => $this->input->post('alamat'),
            'ket_bantuan' => $this->input->post('bantuan'),
            'ket_rumah' => $this->input->post('rumah'),
            'tahun_bantuan' => $this->input->post('thnbantuan'),
            'status_rumah' => $this->input->post('status_rumah'),
            'no_rumah_baru' => $this->input->post('no_new'),
            'alamat_domisili' => $this->input->post('domisili')
        ];

        if($this->db->where('id_kk', $no)->update('tbl_kk', $data_kk)){
            $this->session->set_flashdata('scs_msg','Data KK berhasil di perbarui');
        redirect('dashboard');
        } else {
            $this->session->set_flashdata('err_msg','Data KK gagal di perbarui');
        redirect('dashboard');
        }
    }

    public function edit_anggota_kk($id_kk){
        $nama = $_POST['nama'];
        $nik = $_POST['nik'];
        $jk = $_POST['jk'];
        $tahun_lahir = $_POST['th'];
        // $umur = $_POST['umur'];
        // $id_anggota = $_POST['id_anggota'];
        $id = $_POST['id_anggota'];

        $data_anggota_kk = array();
        
        $index = count($id);

        for($i=0; $i<$index; $i++){
            $u = date('Y') - $tahun_lahir[$i];
                if($u < 17){
                    //anak
                    $umur = 'Anak';
                } else if($u >= 17 & $u <60){
                    //dewasa
                    $umur = 'Dewasa';
                } else if($u >= 60){
                    //lansia
                    $umur = 'Lansia';
                }
            array_push($data_anggota_kk, array(
                'id_anggota' => $id[$i],
                'nik' => $nik[$i],
                'nama_lengkap' => $nama[$i],
                'tahun_lahir' => $tahun_lahir[$i],
                'jk' => $jk[$i],
                'umur' => $umur
            ));
        }

        // var_dump($data_anggota_kk);die;
        if($this->db->update_batch('tbl_anggota_kk', $data_anggota_kk, 'id_anggota')){
            $this->session->set_flashdata('scs_msg','Data Berhasil di ubah');
            redirect('dashboard/edit_anggota/' . $id_kk);
        } else {
            redirect('dashboard/edit_anggota/' . $id_kk);
        }
    }

    public function add_anggota_kk($id_kk){
        $no_kk = $id_kk;
        $nama = $_POST['nama'];
        $nik = $_POST['nik'];
        $jk = $_POST['jk'];
        $tahun_lahir = $_POST['th'];
        // $umur = $_POST['umur'];
        $data_anggota_kk = array();

        $index = count($nik);

        for($i=0; $i<$index; $i++){
            $u = date('Y') - $tahun_lahir[$i];
                if($u < 17){
                    //anak
                    $umur = 'Anak';
                } else if($u >= 17 & $u <60){
                    //dewasa
                    $umur = 'Dewasa';
                } else if($u >= 60){
                    //lansia
                    $umur = 'Lansia';
                }
            array_push($data_anggota_kk, array(
                'nik' => $nik[$i],
                'id_kk' => $no_kk,
                'nama_lengkap' => $nama[$i],
                'tahun_lahir' => $tahun_lahir[$i],
                'jk' => $jk[$i],
                'umur' => $umur
            ));
        }

        if($this->db->insert_batch('tbl_anggota_kk', $data_anggota_kk)){
            $this->session->set_flashdata('scs_msg','Data baru berhasil di tambahkan');
    redirect('dashboard');
        } else {
            $this->session->set_flashdata('err_msg','Data baru gagal di tambahkan');
    redirect('dashboard');
        } 
    }



}
<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Dashboard extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('M_dashboard','model');
    }

    public function index(){
        $data['admin'] = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Dashboard';
        $this->load->library('pagination');
        $config['base_url'] = 'http://localhost/program/dashboard/index';
        $config['total_rows'] = $this->db->get('tbl_kk')->num_rows();

        $config['num_links'] = 5;
        $config['per_page'] = 100;

        if($this->input->get('cari')){
            $config['full_tag_open'] = '<nav class="d-none"><ul class="pagination justify-content-center">';
        }

        $start = $this->uri->segment(3);

        $this->pagination->initialize($config);

        $data['kk'] = $this->model->get_data_kk_all($config['per_page'], $start);

        if($this->input->get('cari')){
            $keyword = $this->input->get('cari');
            $cari = $this->model->cari($keyword);
            $data['kk'] = $cari;
        } 
        
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index');
        $this->load->view('templates/footer');
    }

    public function add(){
        $data['admin'] = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Tambah Data';

        $this->form_validation->set_rules('nokk','nokk','required|trim|is_unique[tbl_kk.no_kk]',['is_unique' => 'No. KK sudah terdaftar']);
        $this->form_validation->set_rules('rt','rt','required|trim');
        $this->form_validation->set_rules('rw','rw','required|trim');
        $this->form_validation->set_rules('alamat','alamat','required|trim');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/add');
            $this->load->view('templates/footer');
        } else {
            $this->model->add_data();
        }

    }


    public function delete($no){
        $this->db->delete('tbl_kk',['id_kk' => $no]);
        $this->db->delete('tbl_anggota_kk',['id_kk' => $no]);
        $this->session->set_flashdata('scs_msg','Data berhasil di hapus');
        redirect('dashboard');
    }


    public function edit($no = null){
        cek_edit_kk();
        $data['admin'] = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row();
        $data['kk'] = $this->model->get_data_kk_no($no);
        $data['title'] = 'Edit Data';

        $this->form_validation->set_rules('nokk','nokk','required|trim');
        $this->form_validation->set_rules('rt','rt','required|trim');
        $this->form_validation->set_rules('rw','rw','required|trim');
        $this->form_validation->set_rules('alamat','alamat','required|trim');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/edit');
            $this->load->view('templates/footer');
        } else {
            $this->model->edit_data_kk($no);
        }

    }

    public function del_people($id_kk,$id){
        if($this->db->delete('tbl_anggota_kk',['id_anggota' => $id])){
            $this->session->set_flashdata('scs_msg','Data berhasil di hapus');
        redirect('dashboard/edit_anggota/'. $id_kk);
        } else {
            $this->session->set_flashdata('err_msg','Data berhasil di hapus');
        redirect('dashboard/edit_anggota/' . $id_kk);
        }
    }


    public function edit_anggota($id_kk = null){
        cek_edit_kk();
        $data['admin'] = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Edit Anggota KK';
        $data['anggota'] = $this->model->get_anggota_kk_all($id_kk);
        $data['id_kk'] = $id_kk;
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/edit_anggota');
        $this->load->view('templates/footer');   
    }

    public function edit_anggota_kk($id_kk = null){
        cek_edit_kk();
        return $this->model->edit_anggota_kk($id_kk);
    }

    public function add_anggota($id_kk = null){
        cek_edit_kk();
        $data['admin'] = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Tambah Anggota KK';
        $data['id_kk'] = $id_kk;
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/add_anggota');
        $this->load->view('templates/footer');
    }

    public function add_anggota_kk($id_kk = null){
        cek_edit_kk();
        return $this->model->add_anggota_kk($id_kk);
    }

    public function export_excel(){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga.xls");
        $data['kk'] = $this->db->get('tbl_kk')->result();

        $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak'";
        $data['jml_anak'] = $this->db->query($a)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

        $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;



        $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa'";
        $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

        $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

        $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;




        $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia'";
        $data['jml_lansia'] = $this->db->query($c)->row()->umur;

        $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

        $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        $this->load->view('dashboard/gen_excel', $data);
    }

    public function cari(){
        $tipe = $_POST['tipe'];
        $cari = $_POST['cari'];


        if($tipe == 'kk'){
            $data['kk'] = $this->db->like('no_kk', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if($tipe == 'rt'){
            $data['kk'] = $this->db->where('rt', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if($tipe == 'nik'){
            $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nik LIKE '%$cari%'";
            $data['kk'] = $this->db->query($q)->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if($tipe == 'nama'){
            $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nama_lengkap LIKE '%$cari%'";
            $data['kk'] = $this->db->query($q)->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if($tipe == 'rw'){
            $data['kk'] = $this->db->where('rw', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if($tipe == 'status_rumah'){
            $data['kk'] = $this->db->like('status_rumah', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } 

    }

    public function export_excel_rt($cari){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by rt.xls");
        $data['kk'] = $this->db->where('rt', $cari)->get('tbl_kk')->result();

        $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $cari";
        $data['jml_anak'] = $this->db->query($a)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

        $q11 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_anak_perempuan'] = $this->db->query($q11)->row()->umur;


        
        $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $cari";
        $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

        $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

        $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;



        $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $cari";
        $data['jml_lansia'] = $this->db->query($c)->row()->umur;

        $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

        $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_kk($cari){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by kk.xls");
        $data['kk'] = $this->db->like('no_kk', $cari)->get('tbl_kk')->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_nik($cari){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by nik.xls");
        $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nik LIKE '%$cari%'";
        $data['kk'] = $this->db->query($q)->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_nama($cari){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by nama.xls");
        $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nama_lengkap LIKE '%$cari%'";
        $data['kk'] = $this->db->query($q)->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_rw($cari){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by rw.xls");

        $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $cari";
        $data['jml_anak'] = $this->db->query($a)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

        $q11 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_anak_perempuan'] = $this->db->query($q11)->row()->umur;
        


        $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $cari";
        $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

        $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

        $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;



        $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $cari";
        $data['jml_lansia'] = $this->db->query($c)->row()->umur;

        $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

        $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        $data['kk'] = $this->db->where('rw', $cari)->get('tbl_kk')->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_status_rumah($cari){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by status rumah.xls");
        $data['kk'] = $this->db->like('status_rumah', $cari)->get('tbl_kk')->result();
        $this->load->view('dashboard/gen_excel', $data);
    }


}
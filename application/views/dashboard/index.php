<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow mt-3 mb-5">
        <div class="card-body">
          <h5>Data Masyarakat</h5>
          <hr>
            <a href="<?= base_url('dashboard/add'); ?>" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah Data</a>
            <a href="<?=  base_url('dashboard/export_excel'); ?>" class="btn btn-success export-excel"><i class="far fa-file-excel"></i> Export Excel</a>
            <div class="table-responsive-xxl" >
              <br>

          <?php if($this->session->flashdata('err_msg')){ ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?= $this->session->flashdata('err_msg') ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php } else if($this->session->flashdata('scs_msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?= $this->session->flashdata('scs_msg') ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <?php } ?>
<div class="row">
<div class="col-lg-5 ms-auto">

  <div class="input-group mb-3">
    <input type="text" class="form-control" id="cari" placeholder="Cari..." aria-label="Text input with dropdown button">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Opsi Pencarian</button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item opsi-pencarian" data-tipe="nama" href="#">Nama</a></li>
        <li><a class="dropdown-item opsi-pencarian" data-tipe="nik" href="#">No. NIK</a></li>
        <li><a class="dropdown-item opsi-pencarian" data-tipe="kk" href="#">No. KK</a></li>
        <li><a class="dropdown-item opsi-pencarian" data-tipe="rt" href="#">No. RT</a></li>
        <li><a class="dropdown-item opsi-pencarian" data-tipe="rw" href="#">No. RW</a></li>
        <li><a class="dropdown-item opsi-pencarian" data-tipe="status_rumah" href="#">Status Rumah</a></li>
      </ul>
  </div>
</div>

</div>

              <table class="table table-bordered mt-3" id="idTable">
                            <thead>
                            
                                <tr>
                                    <th rowspan="2">No Rumah / No rumah baru</th>
                                    
                                    <th rowspan="2">Nama / NIK</th>
                                    <th rowspan="2">Tanggal lahir</th>
                                    <th colspan="2" class="bg-danger text-light">Anak < 17 th</th>
                                    <th colspan="2" class="bg-info text-light">Dewasa 17 - 59 th</th>
                                    <th colspan="2" class="bg-warning text-light">Lansia > 60 th</th>
                                    <th rowspan="2">Alamat KTP / Alamat Domisili</th>
                                    <th rowspan="2">Status Rumah</th>
                                    <th rowspan="2">Ket. Bantuan</th>
                                    <th rowspan="2">Ket. Rumah</th>
                                    <th rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>
                                </tr>
                            </thead>
                              
                      
                            <tbody id="d_warga">
                            <?php foreach($kk as $k){ ?>
                              <?php $jml_anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->num_rows();
                              
                              $rowspan = $jml_anggota + 2;
                              
                            ?>
                                <tr>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->rw .' / '. $k->no_rumah_baru ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No.Rt: <?= $k->rt ?> <br> No.KK: <?= $k->no_kk ?></strong></td>

                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>

                                    <td rowspan="<?= $rowspan ?>"><?= $k->alamat .' / '. $k->alamat_domisili ?></td>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->status_rumah ?></td>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->ket_bantuan ?>

                                    <?php if($k->ket_bantuan == 'Sudah'){ echo'('. $k->tahun_bantuan .')'; } ?>

                                    </td>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->ket_rumah ?></td>
                                    <td rowspan="<?= $rowspan ?>">

                                      <a href="<?= base_url('dashboard/delete/') . $k->id_kk; ?>" onclick="return confirm('Apakah anda yakin menghapus data ini?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                  
                                      <div class="dropdown">
                                        <a class="btn btn-success btn-sm mt-2" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                          <i class="fa fa-edit"></i>
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                          <li><a class="dropdown-item" href="<?= base_url('dashboard/edit/') . $k->id_kk; ?>">Edit data KK</a></li>
                                          <li><a class="dropdown-item" href="<?= base_url('dashboard/edit_anggota/') . $k->id_kk; ?>">Edit anggota KK</a></li>
                                          <li><a class="dropdown-item" href="<?= base_url('dashboard/add_anggota/') . $k->id_kk; ?>">Tambah anggota KK</a></li>
                                        </ul>
                                      </div>

                                    </td>
                                </tr>
                                <?php
                                $anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->result();
                                foreach($anggota as $a){
                                
                                ?>
                                <tr>
                                    <td><?= $a->nama_lengkap ?>/<?= $a->nik ?></td>
                                    <!-- <td><?= $a->tahun_lahir ?></td> -->
                                    <td><?php $date = date_create($a->tahun_lahir); echo date_format($date, 'd F Y'); ?></td>


                                    <!-- Anak -->
                 <?php if($a->umur == 'Anak'){ ?>
                  <?php if($a->jk == 'L'){ ?>
                    <td>1</td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td>1</td>
                  <?php } ?>
                <?php }else{  ?>
                  <td></td>
                  <td></td>
                <?php } ?>

                <!-- Dewasa -->
                <?php if($a->umur == 'Dewasa'){ ?>
                  <?php if($a->jk == 'L'){ ?>
                    <td>1</td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td>1</td>
                  <?php } ?>
                <?php }else{  ?>
                  <td></td>
                  <td></td>
                <?php } ?>
                 
                <!-- Lansia -->
                <?php if($a->umur == 'Lansia'){ ?>
                  <?php if($a->jk == 'L'){ ?>
                    <td>1</td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td>1</td>
                  <?php } ?>
                <?php }else{  ?>
                  <td></td>
                  <td></td>
                <?php } ?>



                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </tbody>
                           
                        </table>
          <!-- pagination -->
          <?= $this->pagination->create_links() ?>
            
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
    $('.opsi-pencarian').on('click', function(){
      var tipe = $(this).data('tipe');
      var cari = $('#cari').val();
      
      if(cari == ''){
        alert('harap masukkan isi pencarian');
        $('.export-excel').attr('href','<?= base_url('dashboard/export_excel/'); ?>');
      } else {

        if(tipe == 'nik'){
          $('.export-excel').attr('href','<?= base_url('dashboard/export_excel_nik/'); ?>' + cari);
        } else if(tipe == 'nama'){
          $('.export-excel').attr('href','<?= base_url('dashboard/export_excel_nama/'); ?>' + cari);
        } else if(tipe == 'rt'){
          $('.export-excel').attr('href','<?= base_url('dashboard/export_excel_rt/'); ?>' + cari);
        } else if(tipe == 'kk'){
          $('.export-excel').attr('href','<?= base_url('dashboard/export_excel_kk/'); ?>' + cari);
        } else if(tipe == 'rw'){
          $('.export-excel').attr('href','<?= base_url('dashboard/export_excel_rw/'); ?>' + cari);
        } else if(tipe == 'status_rumah'){
          $('.export-excel').attr('href','<?= base_url('dashboard/export_excel_status_rumah/'); ?>' + cari);
        }

        $.ajax({
          url: '<?= base_url('dashboard/cari'); ?>',
          data: {tipe:tipe, cari:cari},
          method: 'POST',
          success: function(d){
            $('#d_warga').html(d);
          }
        });
      }

    });

</script>
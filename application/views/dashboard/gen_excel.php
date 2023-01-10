<table border="1" cellpadding="7">
                            <thead>
                            
                                <tr>
                                    <th rowspan="2">No Rumah / No Rumah Baru</th>
                                    
                                    <th rowspan="2">Nama / NIK</th>
                                    <th rowspan="2">Lahir</th>
                                    <th colspan="2">Anak</th>
                                    <th colspan="2">Dewasa</th>
                                    <th colspan="2">Lansia</th>
                                    <th rowspan="2">Alamat KTP / Alamat Domisili</th>
                                    <th rowspan="2">Status Rumah</th>
                                    <th rowspan="2">Ket. Bantuan</th>
                                    <th rowspan="2">Ket. Rumah</th>
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
                            <tbody>
                            <?php foreach($kk as $k){ ?>
                              <?php $jml_anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->num_rows();
                              
                              $rowspan = $jml_anggota + 2;
                              $rowspan2 = $jml_anggota + 1;
                              
                            ?>
                                <tr>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->rw .' / '. $k->no_rumah_baru ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Rt: <?= $k->rt ?> / No.KK: <?= $k->no_kk ?></strong></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->alamat .' / '. $k->alamat_domisili ?></td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->status_rumah ?></td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->ket_bantuan ?>

                                    <?php if($k->ket_bantuan == 'Sudah'){ echo'('. $k->tahun_bantuan .')'; } ?>

                                    </td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->ket_rumah ?></td>
                                </tr>
                                <?php
                                $anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->result();
                                foreach($anggota as $a){
                                
                                ?>
                                <tr>
                                    <td><?= $a->nama_lengkap ?>/<?= $a->nik ?></td>
                                    <td><?= $a->tahun_lahir ?></td>


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
<?php if(empty($jml_anak_laki) & empty($jml_anak_perempuan) & empty($jml_dewasa_laki) & empty($jml_dewasa_perempuan) & empty($jml_lansia_laki) & empty($jml_lansia_perempuan) & empty($jml_anak) & empty($jml_dewasa) & empty($jml_lansia)){ ?>
<?php } else { ?>
<tr>
  <td colspan="13"></td>
</tr>

<tr>
  <th colspan="13">Jumlah Warga</th>
</tr>

<tr>
  <th colspan="3" rowspan="2"></th>
  <th colspan="2">Anak</th>
  <th colspan="2">Dewasa</th>
  <th colspan="2">Lansia</th>
  <th colspan="4" rowspan="2"></th>
</tr>

<tr>
  <th>L</th>
  <th>P</th>
  <th>L</th>
  <th>P</th>
  <th>L</th>
  <th>P</th>
</tr>

<tr>
  <th colspan="3">Jumlah</th>
  <td><?= $jml_anak_laki ?></td>
  <td><?= $jml_anak_perempuan ?></td>
  <td><?= $jml_dewasa_laki ?></td>
  <td><?= $jml_dewasa_perempuan ?></td>
  <td><?= $jml_lansia_laki ?></td>
  <td><?= $jml_lansia_perempuan ?></td>
  <th colspan="4"></th>
</tr>

<tr>
  <th colspan="3">Total</th>
  <td colspan="2"><?= $jml_anak ?></td>
  <td colspan="2"><?= $jml_dewasa ?></td>
  <td colspan="2"><?= $jml_lansia ?></td>
  <th colspan="4"></th>
</tr>

<?php } ?>
                        </table>

<br><br>
                        <table border="1">
                          <tr>
                            <th colspan="2">Keterangan</th>
                          </tr>
                          <tr>
                            <td>Anak</td>
                            <td>< 17 Th</td>
                          </tr>
                          <tr>
                            <td>Dewasa</td>
                            <td>17 - 59 Th</td>
                          </tr>
                          <tr>
                            <td>Lansia</td>
                            <td>> 60 Th</td>
                          </tr>
                        </table>



                        
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5>Tambah Data</h5>
                    <hr>
                    <form action="<?= base_url('dashboard/add'); ?>" method="post">

                    <!-- form kk -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>No. KK</label>
                                <input type="number" value="<?= set_value('nokk'); ?>" name="nokk" id="nokk" class="form-control">
                                <?= form_error('nokk','<small class="text-danger">','</small>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>RT</label>
                                <input type="number" value="<?= set_value('rt'); ?>" name="rt" id="rt" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah</label>
                                <input type="text" value="<?= set_value('rw'); ?>" name="rw" id="rw" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah Baru</label>
                                <input type="text" value="<?= set_value('no_new'); ?>" name="no_new" id="no_new" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Status Rumah</label>
                                <select name="status_rumah" required id="status_rumah" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="Rumah Pribadi">Rumah Pribadi</option>
                                    <option value="Kos">Kos</option>
                                    <option value="Toko">Toko</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat KTP</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="5"><?= set_value('alamat'); ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat Domisili</label>
                                <textarea name="alamat_domisili" id="alamat_domisili" class="form-control" rows="5"><?= set_value('alamat_domisili'); ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Ket. Rumah</label>
                                <textarea name="rumah" id="rumah" class="form-control" rows="5"><?= set_value('nokk'); ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="ket-bantuan">
                            <div class="form-group">
                                <label>Ket. Bantuan</label>
                                <select name="bantuan" id="bantuan" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>
                            </div>

                            <div class="thn-bantuan d-none">
                                <div class="form-group mt-2">
                                            <label>Tahun Menerima Bantuan</label>
                                            <select name="thnbantuan" id="thnbantuan" class="form-control">
                                                <option value="">--Pilih--</option>
                                                <?php
                                                for($i=date('Y'); $i>=date('Y')-30; $i-=1){
                                                echo"<option value='$i'> $i </option>";
                                                }
                                            ?>
                                            </select>
                                </div>
                            </div>


                        </div>
                        
                        <hr class="mt-3">
                    </div>
                    <!-- end form kk -->


                    <h5>Anggota KK</h5>
                    
                    <!-- Anggota kk -->
                    <div class="control-group after-add-more">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik[]" id="nik" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama[]" id="nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk[]" id="jk" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <!-- <select name="th[]" id="th" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <?php
                                            for($i=date('Y'); $i>=date('Y')-100; $i-=1){
                                            echo"<option value='$i'> $i </option>";
                                            }
                                        ?>
                                    </select> -->

                                    <input type="date" class="form-control" name="th[]" id="th">

                                </div>
                            </div>
                          
                            <div class="col-lg-1">
                                <span class="btn btn-secondary btn-sm mt-4 btn-add"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- end Anggota kk -->

                    

                    <!-- btn submit -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Data</button>

                        </div>
                    </div>
                    <!-- end btn submit -->

                    </form>


                   
                    
                    <!-- copy-form -->

                <div class="copy" style="display: none;">
                    <div class="control-group theCopy">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik[]" id="nik" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama[]" id="nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk[]" id="jk" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <!-- <select name="th[]" id="thn" class="form-control thcopy" required>
                                        <option value="">--Pilih--</option>
                                        <?php
                                            for($i=date('Y'); $i>=date('Y')-100; $i-=1){
                                            echo"<option value='$i' data-val='$i'> $i </option>";
                                            }
                                        ?>
                                    </select> -->
                                    <input type="date" class="form-control" name="th[]" id="th">
                                </div>
                            </div>
            
                            <div class="col-lg-1">
                                <span class="btn btn-danger btn-sm mt-4 btn-remove"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- end-copy-form -->


                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function() {
        $(".btn-add").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".btn-remove",function(){ 
            $(this).parents(".control-group").remove();
        });


        $('#bantuan').on('click', function(){
            const bantuan = $('#bantuan').val();
            // console.log(bantuan);
            if(bantuan == 'Sudah'){
                $('.thn-bantuan').removeClass('d-none');
            //    console.log('sudah');
            } else if(bantuan == 'Belum'){
                $('.thn-bantuan').addClass('d-none');
            //    console.log('belum');
            } else if(bantuan == ''){
                $('.thn-bantuan').addClass('d-none');
            }
        });
    });
</script>
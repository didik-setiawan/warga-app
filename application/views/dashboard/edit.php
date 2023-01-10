<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5>Edit Data</h5>
                    <hr>

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

                    <form action="" method="post">
                    <!-- form kk -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>No. KK</label>
                                <input type="number" value="<?= $kk->no_kk ?>" name="nokk" id="nokk" class="form-control">
                                <?= form_error('nokk','<small class="text-danger">','</small>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>RT</label>
                                <input type="number" value="<?= $kk->rt ?>" name="rt" id="rt" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah</label>
                                <input type="text" value="<?= $kk->rw ?>" name="rw" id="rw" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah Baru</label>
                                <input type="text" value="<?= $kk->no_rumah_baru ?>" name="no_new" id="no_new" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Status Rumah</label>
                                <select name="status_rumah" required id="status_rumah" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php $st = ['Rumah Pribadi','Kos','Toko']; 
                                    foreach($st as $c){
                                    ?>
                                        <?php if($kk->status_rumah == $c){ ?>
                                            <option value="<?= $c ?>" selected><?= $c ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $c ?>"><?= $c ?></option>
                                        <?php  }?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat KTP</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="5"><?= $kk->alamat ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat Domisili</label>
                                <textarea name="domisili" id="domisili" class="form-control" rows="5"><?= $kk->alamat_domisili ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Ket. Rumah</label>
                                <textarea name="rumah" id="rumah" class="form-control" rows="5"><?= $kk->ket_rumah ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="ket-bantuan">
                            <div class="form-group">
                                <label>Ket. Bantuan</label>
                                <select name="bantuan" id="bantuan" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <?php $bantuan = ['Sudah','Belum']; foreach($bantuan as $b){ ?>
                                        <?php if($b == $kk->ket_bantuan){ ?>
                                            <option value="<?= $b ?>" selected><?= $b ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $b ?>"><?= $b ?></option>
                                        <?php } ?>
                                        <?php } ?>
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
                                            ?>

                                                <?php if($i == $kk->tahun_bantuan){ ?>
                                                    <option value="<?= $i ?>" selected><?= $i ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>

                                            <?php } ?>
                                        </select>
                            </div>
                            </div>
                        </div>

                        <hr class="mt-3">
                    </div>
                    <!-- end form kk -->

                    <!-- btn submit -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit Data</button>
                        </div>
                    </div>
                    <!-- end btn submit -->

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function() {
        $(".btn-add").click(function(){ 
            console.log('ok');
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".btn-remove",function(){ 
            $(this).parents(".control-group").remove();
        });
    });

    var bantuan = $('#bantuan').val();
        if(bantuan == 'Sudah'){
            $('.thn-bantuan').removeClass('d-none');
    }


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

</script>
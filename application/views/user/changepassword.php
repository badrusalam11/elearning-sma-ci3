<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <form action="<?= base_url('user/changepassword') ?>" method="post">
                <div class="form-group">
                    <label for="current_password">Current password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password">
                    <?= form_error('current_password', '<small class="pl-3 text-danger">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label for="new_password1">New password</label>
                    <input type="password" class="form-control" id="new_password1" name="new_password1">
                    <?= form_error('new_password1', '<small class="pl-3 text-danger">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label for="new_password2">Repeat password</label>
                    <input type="password" class="form-control" id="new_password2" name="new_password2">
                    <?= form_error('new_password2', '<small class="pl-3 text-danger">', '</small>') ?>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button type=" submit" class="btn btn-primary">Change password</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
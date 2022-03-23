<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Change Password</h1>
                                    
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form action="" method="post" class="user">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" value="<?= $email ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password1" id="password1" placeholder="New password">
                                        <?= form_error('password1', '<small class="pl-3 text-danger">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password2" id="password2" placeholder="Repeat password">
                                        <?= form_error('password2', '<small class="pl-3 text-danger">', '</small>') ?>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
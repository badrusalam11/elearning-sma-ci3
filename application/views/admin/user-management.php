<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <?php
            if (validation_errors()) {
                echo '<div class="alert alert-danger" role="alert">';
                echo validation_errors();
                echo '</div>';
            }
            ?>
            <?php echo form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?php echo $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal" onclick="showAddUser()">Add New User</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Role</th>
                        <!-- <th scope="col">Role</th> -->
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    // echo '<pre>' . var_export($subMenu, true) . '</pre>';
                    // die;
                    foreach ($getUser as $gu) { ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $gu['name'] ?></td>
                            <td><?= $gu['email'] ?></td>
                            <td><?= date("l, j F Y, H:i:s", $gu['date_created']) ?></td>
                            <td><?= $gu['role_name'] ?></td>
                            <!-- <td><?php foreach ($gu['teacher'] as $t) {
                                                echo $t['subject_name'] . " - ";
                                            } ?></td> -->
                            <p class="bg-danger"></p>
                            <td><?php echo ($gu['is_active'] == 1) ? '<p class="bg-primary text-white text-center">active</p>' : '<p class="bg-secondary text-white text-center">inactive</p>' ?></td>
                            <td>
                                <a href="#" class="badge badge-success" onclick='showEditUser(<?= json_encode($gu, JSON_FORCE_OBJECT); ?>)' data-toggle="modal" data-target="#editModal">Edit</a>
                                <a href="#" class="badge badge-danger" onclick='showDeleteUser(<?= json_encode($gu); ?>)' data-toggle="modal" data-target="#deleteModal">Delete</a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/adduser') ?>" method="post" id="userForm">
                <div class="modal-body">
                    <input type="text" name="id" id="id" hidden>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Full name" required>
                        </div>
                        <!-- <div class="col">
                                <input type="text" class="form-control" placeholder="Last name">
                            </div> -->
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="defaultCheck1">
                                    Active?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="role_id">Role</label>
                            <select class="form-control" id="role_id" name="role_id" required>
                                <?php foreach ($getRole as $gr) { ?>
                                    <option value="<?= $gr['id'] ?>"><?= $gr['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="student-form" style="display: none;">
                        <div class="row mb-2">
                            <div class="col">
                                <label for="NISN">NISN</label>
                                <input type="text" class="form-control" id="NISN" name="NISN" placeholder="NISN">
                            </div>
                            <div class="col">
                                <label for="class">Class</label>
                                <input type="text" class="form-control" id="class" name="class" placeholder="Class">
                            </div>

                        </div>

                    </div>
                    <div class="teacher-form" style="display: none;">
                        <div class="row mb-2">
                            <div class="col">
                                <label for="NIP">NIP</label>
                                <input type="text" class="form-control" id="NIP" name="NIP" placeholder="NIP">
                            </div>

                        </div>
                        <div class="subject-array">
                            <div class="row mb-2 subject-content">
                                <div class="col">
                                    <label for="Subject">Subject</label>
                                    <select class="form-control subject_id" name="subject_id[]" required>
                                        <?php foreach ($subject as $s) { ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="add_subject"><i class="fas fa-plus-circle"></i> Add Subject</button>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/edituser') ?>" method="post">
                <div class="modal-body">
                    <input type="text" name="id" id="edit-id" hidden>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="name">Name</label>
                            <input type="text" id="edit-name" name="name" class="form-control" placeholder="Full name" required>
                        </div>
                        <!-- <div class="col">
                                <input type="text" class="form-control" placeholder="Last name">
                            </div> -->
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" id="edit-email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="edit-is_active" name="is_active" checked>
                                <label class="form-check-label" for="defaultCheck1">
                                    Active?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="role_id">Role</label>
                            <input type="text" id="edit-role_id" name="role_id" hidden>
                            <input type="text" class="form-control" id="edit-role_name" readonly>
                        </div>
                    </div>

                    <div class="student-form" style="display: none;">
                        <div class="row mb-2">
                            <div class="col">
                                <label for="NISN">NISN</label>
                                <input type="text" class="form-control" id="edit-NISN" name="NISN" placeholder="NISN">
                            </div>
                            <div class="col">
                                <label for="class">Class</label>
                                <input type="text" class="form-control" id="edit-class" name="class" placeholder="Class">
                            </div>

                        </div>

                    </div>
                    <div class="teacher-form" style="display: none;">
                        <div class="row mb-2">
                            <div class="col">
                                <label for="NIP">NIP</label>
                                <input type="text" class="form-control" id="edit-NIP" name="NIP" placeholder="NIP">
                            </div>

                        </div>
                        <div class="subject-array">
                            <div class="row mb-2 subject-content">
                                <div class="col">
                                    <label for="Subject">Subject</label>
                                    <select class="form-control subject_id" name="subject_id[]" required>
                                        <?php foreach ($subject as $s) { ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="add_subject"><i class="fas fa-plus-circle"></i> Add Subject</button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="edit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/deleteUser') ?>" method="post">
                    <input type="text" id="delete-id" name="id" hidden>
                    <input type="text" id="delete-role_id" name="role_id" hidden>

                    <p>
                        Do you want to delete user <b id="delete-name"></b> ?
                    </p>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php echo form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?php echo $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal" onclick='showInsertRole()'>Add New Role</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($role as $r) { ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $r['name'] ?></td>
                            <td>
                                <a href="<?= base_url('admin/roleaccess/') . $r['id'] ?>" class="badge badge-warning">Access</a>
                                <a href="#" class="badge badge-success" onclick='showEditRole(<?= json_encode($r) ?>)' data-toggle="modal" data-target="#exampleModal">Edit</a>
                                <a href="#" class="badge badge-danger" onclick='showDeleteRole(<?= json_encode($r) ?>)' data-toggle="modal" data-target="#deleteModal">Delete</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="role" method="post">
                <input type="text" id="id" name="id" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" aria-describedby="emailHelp" placeholder="Role Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/roleDelete/')?>" method="post">
                    <input type="text" id="idDelete" name="idDelete" hidden>

                    <p>
                        Do you want to delete Role: <b id="roleDelete"></b> ?
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
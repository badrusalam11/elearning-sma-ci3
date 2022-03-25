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
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal" onclick="showAddSubject()">Add New Subject</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Subject Name</th>
                        <th scope="col">Cluster</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    // echo '<pre>' . var_export($subMenu, true) . '</pre>';
                    // die;
                    foreach ($subject as $s) { ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $s['name'] ?></td>
                            <td><?= $s['cluster'] ?></td>
                            <td>
                                <a href="#" class="badge badge-success" onclick='showEditSubject(<?= json_encode($s); ?>)' data-toggle="modal" data-target="#exampleModal">Edit</a>
                                <a href="#" class="badge badge-danger" onclick='showDeleteSubject(<?= json_encode($s); ?>)' data-toggle="modal" data-target="#deleteModal">Delete</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="subjectForm">
                <div class="modal-body">
                    <input type="text" name="id" id="id" hidden>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="name">Subject Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Subject" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <label for="cluster">Cluster</label>
                            <select class="form-control" id="cluster" name="cluster" required>
                                <option value="MIPA">MIPA</option>
                                <option value="IPS">IPS</option>
                                <option value="GENERAL">GENERAL</option>
                            </select>
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
                <form action="<?= base_url('admin/deleteSubject') ?>" method="post">
                    <input type="text" id="delete-id" name="id" hidden>

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
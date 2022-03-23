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
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal" onclick="showAddSubMenu()">Add New Submenu</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">URL</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Active</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    // echo '<pre>' . var_export($subMenu, true) . '</pre>';
                    // die;
                    foreach ($subMenu as $sm) { ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $sm['title'] ?></td>
                            <td><?= $sm['menu'] ?></td>
                            <td><?= $sm['url'] ?></td>
                            <td><?= $sm['icon'] ?></td>
                            <p class="bg-danger"></p>
                            <td><?php echo ($sm['is_active'] == 1) ? '<p class="bg-primary text-white text-center">active</p>' : '<p class="bg-secondary text-white text-center">inactive</p>' ?></td>
                            <td>
                                <a href="#" class="badge badge-success" onclick='showEditSubMenu(<?= json_encode($sm); ?>)' data-toggle="modal" data-target="#exampleModal">Edit</a>
                                <a href="#" class="badge badge-danger" onclick='showDeleteSubMenu(<?= json_encode($sm); ?>)' data-toggle="modal" data-target="#deleteModal">Delete</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="submenu" method="post">
                <div class="modal-body">
                    <input type="text" name="id" id="id" hidden>
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Sub Menu Title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <?php foreach ($menu as $m) { ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" aria-describedby="emailHelp" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" aria-describedby="emailHelp" placeholder="Icon">
                        <!-- <select name="icon" id="icon">
                            
                        </select> -->

                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked="checked">
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
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
                <form action="deleteSubMenu" method="post">
                    <input type="text" id="idDelete" name="idDelete" hidden>

                    <p>
                        Do you want to delete menu <b id="menuDelete"></b> ?
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
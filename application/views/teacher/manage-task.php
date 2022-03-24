<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $subject; ?></h1>
    <div class="btn btn-primary mb-4" data-toggle="modal" data-target="#inputModal"><i class="fa fa-plus"></i> Add Task</div>
    <div class="col-lg">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <table class="table table-striped bg-white border">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Submitted Date</th>
                <th scope="col">Deadline</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($task as $t) { ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $t['title'] ?></td>
                    <td><?= $t['date'] = date("l, j F Y, H:i:s", $t['date']) ?></td>
                    <td><?= $t['deadline'] = date("l, j F Y, H:i", $t['deadline']) ?></td>
                    <td>
                        <div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal" onclick='showDetailTask(<?= json_encode($t) ?>)'><i class="fas fa-info-circle"></i></div>
                        <div class="btn btn-sm btn-warning" data-toggle="modal" data-target="#inputModal" onclick='showEditTask(<?= json_encode($t) ?>)'><i class="fas fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick='showDeleteTask(<?= json_encode($t) ?>)'><i class="fas fa-trash"></i></div>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td style="font-weight:bold;" class="col-2">Title</td>
                        <td style="" class="col-2">:</td>
                        <td style="word-wrap: break-word" class="col-8" id="detail-title"></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;" scope="col">Date</td>
                        <td>:</td>
                        <td id="detail-date"></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;" scope="col">Deadline</td>
                        <td>:</td>
                        <td id="detail-deadline"></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;" scope="col">Attachment</td>
                        <td>:</td>
                        <td id="detail-attachment"></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;" scope="col">Content</td>
                        <td>:</td>
                        <td id="detail-content"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal input -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputModalLabel">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="<?= base_url('teacher/addtask') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" id="id" hidden>
                    <input type="text" name="subject_id" id="subject_id" value="<?= $this->uri->segment(3) ?>" hidden>
                    <table class="table">
                        <tr>
                            <td style="width:50px;font-weight:bold;">Title</td>
                            <td style="width:10px">:</td>
                            <td>
                                <input type="text" class="form-control" id="title" name="title" placeholder="ex: Tugas Trigonometri" required>
                            </td>
                        </tr>
                        <!-- <tr id="date-hidden" hidden>
                            <td style="width:50px;font-weight:bold;" scope="col">Date</td>
                            <td style="width:10px">:</td>
                            <td>
                                <input type="text" class="form-control" id="input-date" readonly>
                            </td>
                        </tr> -->
                        <tr>
                            <td style="width:50px;font-weight:bold;" scope="col">Deadline</td>
                            <td style="width:10px">:</td>
                            <td>
                                <input type="date" class="form-control" id="deadline" name="deadline" required>
                            </td>
                            <!-- <?php
                                    $timestamp = strtotime("22-03-2022 15:18:05");
                                    echo "The timestamp is $timestamp.";
                                    ?> -->
                        </tr>
                        <tr>
                            <td style="width:50px;font-weight:bold;" scope="col">Attachment</td>
                            <td style="width:10px">:</td>
                            <td>
                                <!-- <input type="file" class="form-control-file custom-file-input" id="attachment" name="attachment"> -->
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                    <label class="custom-file-label" for="attachment">Choose file</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50px;font-weight:bold;" scope="col">Content</td>
                            <td style="width:10px">:</td>
                            <td>
                                <textarea name="content" id="content" cols="30" rows="10" class="form-control" id="input-content" placeholder="ex: Buatlah makalah trigonometri" required></textarea>
                                <!-- <input type="text" class="form-control" id="input-content" required> -->
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('teacher/deleteTask') ?>" method="post">
                    <input type="text" id="idDelete" name="idDelete" hidden>
                    <input type="text" id="subjectIdDelete" name="subject_id" hidden>
                    <p>
                        Do you want to delete task <b id="taskDelete"></b> ?
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
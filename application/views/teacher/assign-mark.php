<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $taskTitle; ?></h1>
    <!-- <div class="btn btn-primary mb-4" data-toggle="modal" data-target="#inputModal"><i class="fa fa-plus"></i> Add Task</div> -->
    <div class="col-lg">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <table class="table table-striped bg-white border">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Class</th>
                <th scope="col">Submission Status</th>
                <th scope="col">Submission Date</th>
                <th scope="col">Task Deadline</th>
                <th scope="col">Mark</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($studentTask as $st) { ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $st['name'] ?></td>
                    <td><?= $st['student_class'] ?></td>
                    <td class="text-white <?php echo ($st['submission_date'] > $st['task_deadline']) ? 'bg-danger' : 'bg-success' ?>">
                        <?php echo ($st['submission_date'] > $st['task_deadline']) ? "Late" : "On Time" ?>
                    </td>
                    <?php ($st['submission_date'] > $st['task_deadline']) ? $st['submission_status'] = "Late" : $st['submission_status'] = "On Time"  ?>
                    <td><?= $st['submission_date'] = date("l, j F Y, H:i:s", $st['submission_date']) ?></td>
                    <td><?= $st['task_deadline'] = date("l, j F Y, H:i:s", $st['task_deadline']) ?></td>
                    <td><?= $st['mark'] ?></td>
                    <!-- <td><?= $st['deadline'] = date("l, j F Y, H:i", $t['deadline']) ?></td> -->
                    <td>
                        <div class="btn btn-primary" data-toggle="modal" data-target="#detailModal" onclick='showMark(<?= json_encode($st) ?>)'>Mark</div>
                        <!-- <div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal" onclick='showDetailTask(<?= json_encode($t) ?>)'><i class="fas fa-info-circle"></i></div>
                        <div class="btn btn-sm btn-warning" data-toggle="modal" data-target="#inputModal" onclick='showEditTask(<?= json_encode($t) ?>)'><i class="fas fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick='showDeleteTask(<?= json_encode($t) ?>)'><i class="fas fa-trash"></i></div> -->
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
        <div class="modal-content" style="width:600px">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Mark Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td style="font-weight:bold;" class="col-2">Name</td>
                            <td style="" class="col-2">:</td>
                            <td style="word-wrap: break-word" class="col-8" id="detail-name"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;" scope="col">Class</td>
                            <td>:</td>
                            <td id="detail-class"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;" scope="col">Submission Status</td>
                            <td>:</td>
                            <td id="detail-status"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;" scope="col">Submission Date</td>
                            <td>:</td>
                            <td id="detail-submission-date"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;" scope="col">Attachment</td>
                            <td>:</td>
                            <td>
                                <a href="" id="detail-attachment" wrap="hard"></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;" scope="col">Mark</td>
                            <td>:</td>
                            <td> <input type="number" class="form-control" id="mark" name="mark" placeholder="range 1 - 100" pattern="^[1-9][0-9]?$|^100$" required>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" >Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $task['subject']; ?></h1>
    <div class="content border p-3 bg-white">
        <h3 class="section-title text-danger"><?= $task['title'] ?></h3>
        <small class="mb-2">Assign By : <?= $task['user'] ?></small>

        <!-- <div class="section_availability "></div> -->
        <div class="summarytext text-justify mb-2"><?= $task['content'] ?></div>
        <div class="summarytext text-primary">Attachment :<a href="<?= base_url('assets/task/') . $task['attachment'] ?>"><?= $task['attachment'] ?></a></div>
        <!-- <div class="section-summary-activities mdl-right h6"><span class="activity-count">Assign By : <?= $task['user'] ?></span></div> -->

        <div id="submission-status">
            <h1 class="h3 mb-4 text-danger mt-5">Submission Status</h1>
            <div class="col-lg">
                <?= $this->session->flashdata('message'); ?>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Submission status</td>
                        <td><?php echo ($check_task != null) ? "Submitted" : "Not submitted yet" ?></td>
                    </tr>
                    <tr>
                        <td>Mark Stattus</td>
                        <td><?php 
                        if ($check_task != null) {
                            if ($check_task['mark'] != 0) {
                                echo "Marked";
                            }
                            else {
                                echo "Not Marked yet";
                            }
                        }
                        else {
                            echo "Not Marked yet";
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <td>Deadline</td>
                        <td><?php echo ($task['deadline'] != null) ? date("l, j F Y, H:i", $task['deadline']) : "" ?></td>
                    </tr>
                    <tr>
                        <td>Remaining Time</td>
                        <td <?php 
                        // task is not submitted yet
                        if ($check_task == null) {
                            $collect = 0;
                            $timeDifference = $task['deadline'] - time();
                            // late and not submitted
                            if ($timeDifference < 0) {
                                $collect = 0;
                                echo "class='bg-danger text-white'";
                            }
                        }
                        else {
                            $timeDifference = $task['deadline'] - $check_task['date'];
                            // late task
                            if ($timeDifference < 0) {
                                $collect = 0;
                                echo "class='bg-danger text-white'";
                            }
                            // early task
                            else {
                                $collect = 1;
                                echo "class='bg-success text-white'";
                            }
                        }
                        // echo($task['deadline'] - time() < 0 ) ? "class='bg-danger text-white'": "" 
                        
                        ?>>
                            <?php 
                            if (isset($collect)) {
                                if ($collect == 1) {
                                    echo secondsToTime($timeDifference)." lebih awal";
                                }
                                // elseif ($collect == 0) {
                                //     echo secondsToTime($timeDifference);
                                // }
                                else {
                                    echo secondsToTime($timeDifference);
                                }
                            }
                            // echo ($task != null) ? secondsToTime($task['deadline'] - time()) : "" ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="container align-self-center" align="center">

                <a class="btn btn-primary btn-lg" href="<?= base_url('student/addsubmission/') . $task['id'] ?>">Add Submission</a>
            </div>

        </div>


    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
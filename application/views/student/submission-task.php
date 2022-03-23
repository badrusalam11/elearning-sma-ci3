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
            <h1 class="h3 text-danger mt-5">File Submission</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <div class="pull-left" align="left"><b>Preview</b></div>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                    <i class="fa fa-times"></i> Reset
                                                </button>
                                            </div>
                                            <br>
                                        </div>
                                        
                                        <div class="box-body"><?php echo ($check_task != null) ? "<img class='w-25' src='".base_url('assets/img/file.png')."'><p>" . $check_task['attachment'] . "</p>" : "" ?></div>
                                    </div>
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Choose a file or drag it here.</p>
                                    </div>
                                    <input type="file" name="attachment_file" class="dropzone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Task</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- <div class="container align-self-center mt-2" align="center">

                <a class="btn btn-primary btn-lg" href="<?= base_url('student/addsubmission/') ?>">Add Submission</a>
            </div> -->
        </div>


    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
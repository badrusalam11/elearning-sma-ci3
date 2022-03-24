<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="card-columns">
        <?php foreach ($teacher_subject as $ts) { ?>
            <a href="<?= base_url('teacher/mark/') . $ts['subject_id'] ?>">
                <div class="card pointer">
                    <img class="card-img-top" src="<?= base_url('assets/img/triangle.png') ?>" alt="Card image cap">
                    <div class="card-body">
                        <h4><?= $ts['name'] ?></h4>
                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                    </div>
                </div>

            </a>

        <?php } ?>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
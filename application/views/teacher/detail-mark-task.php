<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $subject; ?></h1>
    <?php foreach ($task as $t) { ?>
        <div class="content border p-2 bg-white">
            <h3 class="section-title"><a href="<?= base_url('teacher/assignMark/') . $t['id'] ?>" class=""><?= $t['title'] ?></a></h3>
            <div class="section_availability"></div>
            <div class="summarytext"></div>
            <!-- <div class="section-summary-activities mdl-right"><span class="activity-count">Deadline : <?= $t['name'] ?></span></div> -->
        </div>
    <?php } ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="main_content_iner ">
<div class="container-fluid p-0">
<div class="row justify-content-center">
<div class="col-lg-12">
<div class="single_element">
<div class="quick_activity">

</div>
</div>
</div>

<div class="col-xl-6">
<div class="white_box QA_section card_height_100">
<div class="white_box_tittle list_header m-0 align-items-center">
<div class="main-title mb-sm-15" style="margin-bottom: 20px;">
<h3 class="m-0 nowrap">Update Batch</h3>
</div>
</div>
    <form action="<?php echo base_url(); ?>index.php/admin/batchupdate" method="POST">
        <?php 
        $batches = $batches[0]; 
        ?>
        <div class="mb-3">
        <label class="form-label">Batch year</label>
        <input type="text" name="batch" value="<?php echo $batches->batch; ?>" class="form-control">
        <input type="hidden" name="id" value="<?php echo $batches->_id; ?>" class="form-control">
        </div>
        <div class="mb-5">
        <input style="background: #3686f9; color: #fff;" type="submit" name="submit" class="form-control"/>
        </div>
        
</form>
</div>
</div>
</div>
</div>
</div>
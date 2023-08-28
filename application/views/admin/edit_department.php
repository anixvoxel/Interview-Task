
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
<h3 class="m-0 nowrap">Update Department</h3>
</div>
</div>
    <form action="<?php echo base_url(); ?>index.php/admin/departmentupdate" method="POST">
        <?php 
        $departments = $departments[0]; 
        ?>
        <div class="mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="department" value="<?php echo $departments->department; ?>" class="form-control">
        <input type="hidden" name="id" value="<?php echo $departments->_id; ?>" class="form-control">
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
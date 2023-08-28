
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
<h3 class="m-0 nowrap">Register Students</h3>
</div>
</div>
    <form action="<?php echo base_url(); ?>index.php/admin/studentregister" method="POST">
        <div class="mb-3">
        <label class="form-label">Roll Number</label>
        <input type="text" name="rollnumber" value="<?php echo $nextRoll; ?>" readonly class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" required="" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Gender</label>
        <select required="" name="gender" class="form-control">
            <option>Male</option>
            <option>Female</option>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label">Select Batch</label>
        <select required="" name="batch" class="form-control">
            <?php 
            foreach ($batches as $batch) {
                   ?>
                   <option value="<?php echo $batch->batch; ?>"><?php echo $batch->batch; ?></option>
                   <?php
                }
            ?>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label">Select Department</label>
        <select required="" name="department" class="form-control">
            <?php 
            foreach ($departments as $department) {
                   ?>
                   <option value="<?php echo $department->_id; ?>"><?php echo $department->department; ?></option>
                   <?php
                }
            ?>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label">Mobile</label>
        <input required="" type="text" name="mobile" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Address</label>
        <input required="" type="text" name="address" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Status</label>
        <select required="" name="status" class="form-control">
            <option>Active</option>
            <option>Inactive</option>
        </select>
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
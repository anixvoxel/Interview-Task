
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
<h3 class="m-0 nowrap">Update Students</h3>
</div>
</div>
    <form action="<?php echo base_url(); ?>index.php/admin/studentupdate" method="POST">
        <?php 
        $studentData = $studentData[0]; 
        // print_r($studentData);
        ?>
        <div class="mb-3">
        <label class="form-label">Roll Number</label>
        <input type="text" value="<?php echo $studentData->rollnumber; ?>" readonly name="rollnumber" class="form-control">
        <input type="hidden" name="id" value="<?php echo $studentData->_id; ?>" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="<?php echo $studentData->name; ?>" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-control">
            <option <?php if($studentData->gender=='Male'){ echo 'selected'; } ?>>Male</option>
            <option <?php if($studentData->gender=='Female'){ echo 'selected'; } ?>>Female</option>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label">Select Batch</label>
        <select name="batch" class="form-control">
            <?php 
            foreach ($batches as $batch) {
                   ?>
                   <option <?php if($studentData->batch==$batch->batch){ echo 'selected'; } ?> value="<?php echo $batch->batch; ?>"><?php echo $batch->batch; ?></option>
                   <?php
                }
            ?>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label">Select Department</label>
        <select name="department" class="form-control">
            <?php 
            foreach ($departments as $department) {
                   ?>
                   <option <?php if($studentData->department==$department->department){ echo 'selected'; } ?> value="<?php echo $department->_id; ?>"><?php echo $department->department; ?></option>
                   <?php
                }
            ?>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile" value="<?php echo $studentData->mobile; ?>" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" value="<?php echo $studentData->address; ?>" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option <?php if($studentData->status=='Active'){ echo 'selected'; } ?> >Active</option>
            <option <?php if($studentData->status=='Inactive'){ echo 'selected'; } ?>>Inactive</option>
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
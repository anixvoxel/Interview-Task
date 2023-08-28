
<div class="main_content_iner ">
<div class="container-fluid p-0">
<div class="row justify-content-center">
<div class="col-lg-12">
<div class="single_element">
<div class="quick_activity">

</div>
</div>
</div>

<div class="col-xl-5">
<div class="white_box QA_section card_height_100">
<div class="white_box_tittle list_header m-0 align-items-center">
<div class="main-title mb-sm-15">
<h3 class="m-0 nowrap">Batches</h3>
<!-- <a class="btn btn-primary" style="margin:20px" href="<?php echo base_url(); ?>index.php/batch/add">Add new</a> -->
</div>

</div>
<div class="QA_table ">
<?php // print_r( $this->session->userdata); die(); ?>
<table class="table">
<thead>
<tr>
<th scope="col">Batch</th>
<th scope="col">&nbsp;</th>
</tr>
</thead>
<tbody>
    <?php
foreach ($batches as $eachData) {
                        ?>
                <tr>

                <td><?php echo $eachData->batch; ?></td>
                <td>
                    <div class="amoutn_action d-flex align-items-center">
                    <div class="dropdown ms-4">
                    <a class=" dropdown-toggle hide_pils" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div style="padding:13px" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                   
                    <?php echo anchor('/batch/edit/' . $eachData->_id, 'Edit'); ?>
                    <br/>
                    <?php echo anchor('/admin/batchdelete/' . $eachData->_id, 'Delete', array('onclick' => "return confirm('Do you want delete this record')")); ?>
                    </div>
                    </div>
                    </div> </td>
                </tr>
                <?php
                    }
                    ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>

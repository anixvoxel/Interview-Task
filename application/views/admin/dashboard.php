
<div class="main_content_iner ">
<div class="container-fluid p-0">
<div class="row justify-content-center">
<div class="col-lg-12">
<div class="single_element">
<div class="quick_activity">

</div>
</div>
</div>

<div class="col-xl-12">
<div class="white_box QA_section card_height_100">
<div class="white_box_tittle list_header m-0 align-items-center">
<div class="main-title mb-sm-15">
<h3 class="m-0 nowrap">Students</h3>
<a class="btn btn-primary" style="margin:20px" href="<?php echo base_url(); ?>index.php/student/add">Add new</a>
</div>
<div class="box_right d-flex lms_block">
<div class="serach_field-area2">
<div class="search_inner">
<form Active="#">
<div class="search_field">
<input id="search_text" type="text" placeholder="Search here...">
</div>
<button type="submit"> <i class="ti-search"></i> </button>
</form>
</div>
</div>
</div>
</div>
<div class="QA_table ">
<?php // print_r( $this->session->userdata); die(); ?>
<table class="table">
<thead>
<tr>
<th scope="col">Roll Number</th>
<th scope="col">Name</th>
<th scope="col">Batch</th>
<th scope="col">Department</th>
<th scope="col">Mobile</th>
<th scope="col">Address</th>
<th scope="col">&nbsp;</th>
</tr>
</thead>
<tbody id="result">
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"<?php echo base_url(); ?>index.php/admin/ajaxsearch/fetch",
   method:"POST",
   data:{query:query},
   success:function(data){
    $('#result').html(data);
   }
  })
 }

 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});
</script>
<style type="text/css">
    .pCard_card .pCard_up{
        background: #ccc !important;
        height: 148px;
    }
    .pCard_card .pCard_up .pCard_text{
        top: 50px;
    }
    .pCard_card{
        height: 325px;
    }
</style>
<div class="main_content_iner ">
<div class="container-fluid p-0">
<div class="row justify-content-center">
<div class="col-lg-12">
<div class="single_element">
<div class="quick_activity">

</div>
</div>
</div>

<div class="col-xl-7">
<div class="white_box QA_section card_height_100">
<div class="white_box_tittle list_header m-0 align-items-center">
<div class="main-title mb-sm-15">
<h3 class="m-0 nowrap">My Profile</h3>
</div>
</div>
<div class="white_box mb_30">
<div class="pCard_card">
<div class="pCard_up">
<div class="pCard_text" style="color:#000;">
<h2 style="color:#000;"><?php print_r($userdata['name']); ?></h2>
<p style="color:#000;"> <?php print_r($userdata['department']->department); ?> | <?php print_r($userdata['batch']); ?></p>
</div>

</div>
<div class="pCard_down">
<div>
<p>Registration Number</p>
<p><?php print_r($userdata['rollnumber']); ?></p>
</div>
<div>
<p>Mobile</p>
<p><?php print_r($userdata['mobile']); ?></p>
</div>
<div>
<p>Address</p>
<p><?php print_r($userdata['address']); ?></p>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</script>
<!-- Main Banner Starts -->
<?php if(!empty($page_data['banner_image'])){ ?>
<div class="main-banner" style="background: url(<?php echo base_url('uploads/frontend/banners/' . $page_data['banner_image']); ?>) center top;">
    <div class="container px-md-0">
        <h2><span><?php echo $page_data['page_title']; ?></span></h2>
    </div>
</div>
<?php } ?>
<?php if(!empty($page_data['page_title'])){ ?>
<div class="breadcrumb">
    <div class="container px-md-0">
        <ul class="list-unstyled list-inline">
            <li class="list-inline-item"><a href="<?php echo base_url('home') ?>">Home</a></li>
            <li class="list-inline-item active"><?php echo $page_data['page_title']; ?></li>
        </ul>
    </div>
</div>
<?php } ?>
<!-- Main Container Starts -->
<div class="container px-md-0 main-container">
    <?php echo $page_data['content']; ?>
</div>
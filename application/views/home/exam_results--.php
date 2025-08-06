<style type="text/css">
    #print {
        margin-bottom: 20px;
        margin-top: 0px;
        padding: 2px 15px;
        font-size: 14px;
        font-weight: 500;
    }
</style>
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
    <p><?php echo $page_data['description']; ?></p>
    <?php echo form_open('home/examResultsPrintFn', array('class' => 'printIn')); ?>
    <div class="box2 form-box">
        <div class="row">
            <div class="col-md-4 mb-sm">
                <div class="form-group">
                    <label class="control-label"> <?=translate('exam')?> <span class="required">*</span></label>
                    <?php
                        $array = array();
                        $result = $this->home_model->getExamList($branchID);
                        if (count($result)) {
                            $array[''] = translate('select');
                            foreach ($result as $row) {
                                if ($row['term_id'] != 0) {
                                    $term = $this->db->select('name')->where('id', $row['term_id'])->get('exam_term')->row()->name;
                                    $name = $row['name'] . ' (' . $term . ')';
                                } else {
                                    $name = $row['name'];
                                }
                                $array[$row['id']] = $name;
                            }
                        } else {
                            $array[0] = translate('no_information_available');
                        }

                        echo form_dropdown("exam_id", $array, set_value('exam_id'), "class='form-control' data-plugin-selectTwo");
                    ?>
                    <span class="error"></span>
                </div>
            </div>
            <div class="col-md-4 mb-sm">
                <div class="form-group">
                    <label class="control-label"> <?=translate('academic_year')?> <span class="required">*</span></label>
                        <?php
                        $arrayYear = array("" => translate('select'));
                        $years = $this->db->get('schoolyear')->result();
                        foreach ($years as $year) {
                            $arrayYear[$year->id] = $year->school_year;
                        }
                        echo form_dropdown("session_id", $arrayYear, set_value('session_id', $global_config['session_id']), "class='form-control'
                        data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
                        ?>
                    <span class="error"></span>
                </div>
            </div>
            <div class="col-md-4 mb-sm">
                <div class="form-group">
                    <label class="control-label"> <?=translate('register_no')?> <span class="required">*</span></label>
                    <input type="text" class="form-control" name="register_no" value="<?=set_value('register_no')?>" autocomplete="off" />
                    <span class="error"></span>
                </div>
            </div>
            <div class="col-md-4 mb-sm">
                <div class="form-group">
                    <label class="control-label"> <?=translate('pin')?> <span class="required">*</span></label>
                    <input type="text" class="form-control" name="pin" value="<?=set_value('pin')?>" placeholder="Enter Result Pin" autocomplete="off" />
                    <span class="error"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="grade_scale" value="<?php echo $page_data['grade_scale']; ?>">
        <input type="hidden" name="attendance" value="<?php echo $page_data['attendance']; ?>">
        <button type="submit" class="btn btn-1" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing"><i class="fas fa-plus-circle"></i> <?=translate('check_result')?></button>
    </div>
    <?php echo form_close(); ?>
    <div class="row">
        <div class="col-md-12">
            <div id="card_holder" style="display: none;">
                <div class="box2 form-box">
                    <button type="button" class="btn btn-1" id="print"><i class="fas fa-print"></i> <?=translate('print')?></button>
                    <div id="card"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Container Ends -->
<script type="text/javascript">
    $(document).ready(function () {
        $('form.printIn').on('submit', function(e){
            e.preventDefault();
            var btn = $(this).find('[type="submit"]');
            var $this = $(this);
            $("#card_holder").hide();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    btn.button('loading');
                },
                success: function (data) {
                    $('.error').html("");
                    if (data.status == "fail") {
                        $.each(data.error, function (index, value) {
                            $this.find("[name='" + index + "']").parents('.form-group').find('.error').html(value);
                        });
                        btn.button('reset');
                    } else if (data.status == 0) {
                        btn.button('reset');
                        swal({
                            toast: true,
                            position: 'top-end',
                            type: 'error',
                            title: data.error,
                            confirmButtonClass: 'btn btn-default',
                            buttonsStyling: false,
                            timer: 8000
                        });
                    } else {
                        $('#card').html(data.card_data);
                        $("#card_holder").show(200);
                    }
                },
                error: function () {
                    btn.button('reset');
                    alert("An error occured, please try again");
                },
                complete: function () {
                    btn.button('reset');
                }
            });
        });

$('#print').on('click', function(e){
    var oContent = document.getElementById('card').innerHTML; // Get the content of the element with id 'card'
    var printWindow = window.open('', '_blank'); // Open a new window

    // Write the HTML content along with necessary CSS links directly into the new window
    printWindow.document.write('<html><head><title></title>');
    printWindow.document.write('<link rel="stylesheet" href="' + base_url + 'assets/vendor/bootstrap/css/bootstrap.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="' + base_url + 'assets/css/custom-style.css">');
    printWindow.document.write('<link rel="stylesheet" href="' + base_url + 'assets/css/certificate.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(oContent); // Write the content of the 'card' element
    printWindow.document.write('</body></html>');

    // Close the document and focus the window
    printWindow.document.close();
    printWindow.focus();

    // Print the content
    setTimeout(function () {
        printWindow.print();
        printWindow.close(); // Close the window after printing
    }, 500); // Wait for 500 milliseconds before printing (optional)
});


        
    });
</script>
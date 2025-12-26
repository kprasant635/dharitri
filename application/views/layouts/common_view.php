<?php
    include('navbar.php');
    // if(isset($_view) && $_view) {
    //     $this->load->view($_view);
    // }      
?>

<section id="comview-section-for-application-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-application-btn" value="0">
</section>

<section id="comview-section-for-daReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-daReport-btn" value="0">
</section>

<section id="comview-section-for-lmReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-lmReport-btn" value="0">
</section>

<section id="comview-section-for-skReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-skReport-btn" value="0">
</section>

<section id="comview-section-for-coReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-coReport-btn" value="0">
</section>

<section id="comview-section-for-boReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-boReport-btn" value="0">
</section>

<section id="comview-section-for-adcReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-adcReport-btn" value="0">
</section>

<section id="comview-section-for-dcReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-dcReport-btn" value="0">
</section>

<section id="comview-section-for-dptReport-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-dptReport-btn" value="0">
</section>

<section id="comview-section-for-proceeding-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-proceeding-btn" value="0">
</section>

<section id="comview-section-for-premium-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-premium-btn" value="0">
</section>

<section id="comview-section-for-history-btn" class="comview-all-section">
    <input type="hidden" id="fetched-for-history-btn" value="0">
</section>



<script>
    var baseurl_common = '<?php echo base_url(); ?>';
    var service = '<?php echo $show_nav['service_code']; ?>';
    var case_no = '<?php echo $show_nav['case_no'] ?>';
    var process = '<?php echo $show_nav['process'] ?>';
    var reports = '<?php echo $show_nav['reports']; ?>'.split(',');
    var default_report = "<?php echo $show_nav['default_report']; ?>";

    $(document).on('ready', ()=>{
        // var reportRoles = [];
        reports.forEach(element => {
            var roleReport = element.trim();
            if(roleReport == 'ast') {
                $('#daReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'lm') {
                $('#lmReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'sk') {
                $('#skReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'co') {
                $('#coReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'bo') {
                $('#boReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'adc') {
                $('#adcReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'dc') {
                $('#dcReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'dpt') {
                $('#dptReport').attr({style:'display:block;'});
            }
            else if(roleReport == 'proceeding') {
                $('#proceeding').attr({style:'display:block;'});
            }
            else if(roleReport == 'premium') {
                $('#premium').attr({style:'display:block;'});
            }
        });

        switch (default_report) {
            case 'co':
                $('#coReport-btn').click();
                break;
            case 'lm':
                $('#lmReport-btn').click();
                break;
            case 'sk':
                $('#skReport-btn').click();
                break;
            case 'ast':
                $('#daReport-btn').click();
                break;
            default:
                break;
        }
        // if(default_report == "co") {
        //     $('#coReport-btn').click();
        // }
    });

    $('.btn-report-nav').on('click', function(e) {
        var current_id = e.currentTarget.id;
        $comview_section_for = $('#comview-section-for-'+current_id);
        $fetched_for = $('#fetched-for-'+current_id);

        //section hide, tab current active
        $('.comview-all-section').hide();
        $('.tab-list').removeClass('tab-current');
        $('#'+current_id).parent('li').addClass('tab-current');

        //if section is already fetched then 1
        if ($fetched_for.val() == 1)
        {
            $comview_section_for.show();
            return;
        }

        var url = '';
        if(current_id == 'application-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/application';
        }
        else if(current_id == 'daReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/daReport';
        }
        else if(current_id == 'lmReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/lmReport';
        }
        else if(current_id == 'skReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/skReport';
        }
        else if(current_id == 'coReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/coReport';
        }
        else if(current_id == 'boReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/boReport';
        }
        else if(current_id == 'adcReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/adcReport';
        }
        else if(current_id == 'dcReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/dcReport';
        }
        else if(current_id == 'dptReport-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/dptReport';
        }
        else if(current_id == 'proceeding-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/proceeding';
        }
        else if(current_id == 'premium-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/premium';
        }
        else if(current_id == 'history-btn') {
            url = baseurl_common+'index.php/v2/ReportsController/history';
        }

        if(url != '') {
            // console.log('loading start');
            $('.loader-wrap').attr({style:'display:block;'});
            $comview_section_for.html('');
            $.ajax({
                url: url,
                type: 'POST',
                data: {service_code:service, case_no:case_no, process:process},
                success: (response)=>{
                    // console.log('loading stop');
                    $('.loader-wrap').attr({style:'display:none;'});
                    // console.log(response);
                    $comview_section_for.show();
                    $comview_section_for.html(response);
                    $('<input>', {
                        'type': 'hidden',
                        'id': 'fetched-for-'+current_id,
                        'value': '1'
                    }).appendTo($comview_section_for);
                },
                error: (error)=>{
                    console.log(error);
                }
            });
        }
    });
</script>

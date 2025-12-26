<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }
    .btn-info{

    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px' id="print_direct">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('SdlacMinutesHeading') ?></span>
                <hr>
            </div>

            <div class="reza-body">
                <span class="reza-title" style="font-size: 17px"><?php echo $this->lang->line('MinutesAgainstCases') ?></span>
                <br>
                <br>
                <?php if ($caseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table'  width="100%">

                        <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                            <tr  style="background-color: white; ">
                                <td style="padding: 15px!important; width: 30%">
                                    <?php echo $i .'. '.' Case No ' .'<b>'. $case->case_no .'<b>'. '  :  '  ?>
                                </td>

                                <?php foreach ($minutes as $minute):  ?>

                                    <?php if ($minute->case_no == $case->case_no):  ?>
                                        <td>
                                            <?php echo $minute->note_on_order ?>
                                        </td>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<div class="container">
    <div class="row mt-4 mb-5 justify-content-center text-center">
        <div class="col-6">
            <button
                type="button"
                onclick="printDiv('print_direct');"
                id="print"
                class="btn btn-success text-white"
            >
                Print Notice
            </button>
        </div>
    </div>
</div>

<script>
    // -js-to print notice
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents
    }
</script>

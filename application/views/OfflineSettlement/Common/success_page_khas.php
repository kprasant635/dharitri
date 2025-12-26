<style>
    #card {
        width: 100%;
        display: block;
        text-align: center;
        font-family: "Source Sans Pro", sans-serif;
        margin-bottom: 30px;
    }

    #upper-side {
        padding: 2em;
        background-color: #8bc34a;
        display: block;
        color: #fff;
        border-top-right-radius: 8px;
        border-top-left-radius: 8px;
    }


    #status {
        font-weight: lighter;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 1em;
        margin-top: -0.2em;
        margin-bottom: 0;
    }

    #lower-side {
        padding: 2em 2em 5em 2em;
        background: #fff;
        display: block;
        border-bottom-right-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    #lower-side2 {
        padding: 0em 2em 2em 2em;
        background: #fff;
        display: block;
        border-bottom-right-radius: 8px;
        border-bottom-left-radius: 8px;
        color: red;
    }

    #message {
        margin-top: -0.5em;
        color: #757575;
        letter-spacing: 1px;
        font-size: 18px;
    }

    #contBtn {
        position: relative;
        top: 1.5em;
        text-decoration: none;
        background: #8bc34a;
        color: #fff;
        margin: auto;
        padding: 0.8em 3em;
        -webkit-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.21);
        -moz-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.21);
        box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.21);
        border-radius: 25px;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    #contBtn:hover {
        -webkit-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.41);
        -moz-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.41);
        box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.41);
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    #viewBtn {
        position: relative;
        top: 0.5em;
        text-decoration: none;
        background: #9C27B0;
        color: #fff;
        margin: auto;
        padding: 0.8em 3em;
        -webkit-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.21);
        -moz-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.21);
        box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.21);
        border-radius: 25px;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    #viewBtn:hover {
        -webkit-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.41);
        -moz-box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.41);
        box-shadow: 0px 15px 30px rgba(50, 50, 50, 0.41);
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }
</style>

<div class="row" style='padding-top: 15px; margin-bottom: 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php echo $this->lang->line('offlineSettlementSidebar') ?> /
        <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas" style="text-decoration: none">
            Khas Land /
        </a>
        Apply

        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu
            </button>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 25px; margin-top: 25px">

            <div id='card' class="animated fadeIn">
                <div id='upper-side'>

                    <i id="checkmark" class="fa fa-check-square-o" style="font-size: 80px"></i>

                    <h2 id='status'>
                        Success
                    </h2>
                </div>
                <div id='lower-side'>
                    <p id='message'>
                        Offline Settlement Application
                        Application No:   <br>
                        <span style="font-weight: bold; color: #8bc34a; font-size: 22px"> <?php echo $caseNo ?>  </span>
                        <br> Successfully submitted on
                        <?= date ("F j, Y",strtotime(date('Y-m-d h:i:s'))) ?> and
                        <br>
                        <b> Forwarded to DC for further processing</b>
                    </p>
                    <a href="<?= base_url()?>index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas" id="contBtn">
                        <b>Apply Offline Application </b>
                    </a>
                </div>

                <div id='lower-side2'>
                    <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/getMyAppliedApplicationList" id="viewBtn">
                        <b>Offline Application List </b>
                    </a>

                   <div style="margin-top: 60px">* Kindly noted the application number for further use *</div>
                </div>


            </div>

    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>
</div>
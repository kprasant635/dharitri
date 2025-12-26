<div class="container-fluid login" >
    <div class='row col-lg-12'  >
        <div class="panel panel-primary">
            <div class="panel-heading">Case Search</div>
            <div class="panel-body">
                <div class='col-lg-12'>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">FMUT</a></li>
                        <li><a data-toggle="tab" href="#menu1">FPART</a></li>
                        <li><a data-toggle="tab" href="#menu2">OMUT</a></li>
                        <li><a data-toggle="tab" href="#menu3">OPART</a></li>
                        <li><a data-toggle="tab" href="#menu4">OCONV</a></li>
                        <!--<li><a data-toggle="tab" href="#menu5">RE-CLASSIFICATION</a></li>-->
                        <li><a data-toggle="tab" href="#menu8">C-Services</a></li>
                        <li><a data-toggle="tab" href="#menu9">NR Case</a></li>
                        <li><a data-toggle="tab" href="#menu10">Misc Case</a></li>
                        <li><a data-toggle="tab" href="#menu5">Reclass</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <form method="post">
                                <input type="hidden" name="casetype" value="1"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select Field MUT Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="2"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select Field PART Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="3"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select OFFICE MUT Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="4"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select OFFICE PART Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu4" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="5"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select CONV Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu5" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="6"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select RECLASS Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 hide ">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu8" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="8"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select Citizen Case</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
												
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 hide">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
												<span class='red'>Type exact case number</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
						<div id="menu9" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="9"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select NR Case</h4>
                                    <hr>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="2">Case No Search</label>
												
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 hide">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
												<span class='red'>Type exact case number</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
						<div id="menu10" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="10"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select Misc Case</h4>
                                    <hr>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="3">Case No Search</label>	
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 hide">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
												<span class='red'>Type exact case number</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" class="btn btn-primary" value="Search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu7" class="tab-pane fade">
                            <form method="post">
                                <input type="hidden" name="casetype" value="8"/>
                                <div class="row">
                                    <h4 style="text-align: center">Select Search Type</h4>
                                    <hr>
                                    <div class="col-lg-4 ">
                                        <div class="form-group">

                                            <div class="col-sm-10">
                                                <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Case No Search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <div class="col-sm-12">
                                                <label class="checkbox-inline"><input type="radio"  name="category" value="0">Pattadar Name Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="col-lg-8 col-lg-offset-2">

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Enter Search Value Here" name="search" class="form-control" >
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" 
                                                       class="btn btn-primary" value="Search">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>   
<style>
.nav-tabs li{
	background:#3bafda;
	color:#fff;
}
.nav-tabs > li.active > a, .nav-tabs > li.active{
	background:#800000 !important;
	color:#fff;
}
.nav-tabs li a{
	color:#fff;
	font-size:19px;
	font-weight:bold;
}


</style>    
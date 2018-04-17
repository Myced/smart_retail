<?php
$output = '';

$date = date("Y");

$output = '
    <div class="row ">
                <div class="col-md-12">
                    <div class="text-center text-bold">
                        &copy; copyright ' . $date . ' SMART RETAIL
                    </div>
                    
                    <br><br>
                    <div class="form-group row">
                        <label class="col-md-4 control-label text-right">
                            Product Name:
                        </label>
                        <div class="col-md-8">
                            SMART RETAIL
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4 control-label text-right">
                            Version:
                        </label>
                        <div class="col-md-8">
                            2.0
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4 control-label text-right">
                            Credit:
                        </label>
                        <div class="col-md-8">
                            @tncedric, Ndive, Jevis Consultant, Frank Ekombe
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4 control-label text-right">
                            Development:
                        </label>
                        <div class="col-md-8">
                            <div class="row">
                                <img src="images/jevis_assocx150.png" alt="JEVIS AND ASSOCIATES">
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-2">
                                    <strong>IN ASSOCIATION WITH </strong>
                                </div>
                            </div>
                            
                            <div class="row">
                                <img src="images/pefscom_logox150.png" alt="PEFSCOM SYSTEMS">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <br>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="thanks text-center text-success">
                        <strong><<<<<<<<< Thank You for Choosing Smart Retail >>>>>>>>> </strong>
                    </div>
                </div>
            </div>
            ';

echo $output;
?>
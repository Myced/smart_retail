<?php
//warning, danger and success
if(isset($error))
{
    //Show error message here
    ?>
<br>
<div class="row wow shake">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-danger alert-dismissable">
            <strong>
                <i class="fa fa-exclamation-circle"></i>
                Error!
            </strong>
            <?php echo $error; ?>
            <button  role="close" data-dismiss="alert" class="close">&times;</button>
        </div>
    </div>
</div>
    <?php
}
if(isset($success))
{
    //show success notification here
    ?>
<br>
<div class="row wow slideInDown">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-success alert-dismissable" id="alert">
            <strong>
                <i class="fa fa-check"yi></i>
                Success!
            </strong>
            <?php echo $success; ?>
            <button  role="close" data-dismiss="alert" class="close">&times;</button>
        </div>
    </div>
</div>
    <?php
}

if(isset($warning))
{
    ?>
<br>
<div class="row wow pulse"  data-wow-iteration="5" data-wow-duration="1500ms">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-warning alert-dismissable" >
            <strong>
                <i class="fa fa-exclamation-triangle"></i>
                Warning!
            </strong>
            <?php echo $warning; ?>
            <button  role="close" data-dismiss="alert" class="close">&times;</button>
        </div>
    </div>
</div>
    <?php
}

if(isset($activate_error))
{
    //Show error message here
    ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="">
            <div class="text-center"> 
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                    <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                    <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                </svg>

                <p class="error">
                    <strong> <?= $activate_error; ?> </strong>
                </p>
            </div>
            
        </div>
    </div>
</div>
    <?php
}

if(isset($activate_success))
{
    //Show error message here
    ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="">
            <div class="text-center"> 
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                    <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                </svg>

                <p class="success">
                    <strong> <?= $activate_success; ?> </strong>
                </p>
            </div>
            
        </div>
    </div>
</div>
    <?php
}
?>
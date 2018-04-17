<div class="row">
        <div class="col-md-12">
            <?php 
            $link = $db->connect();
            
            $query = "SELECT * FROM `company` ORDER BY `id` DESC LIMIT 1";
            $res = mysqli_query($link, $query);
            
            while ($r = mysqli_fetch_array($res))
            {
                ?>
            <div class="col-md-3">
                <?php
                $photo = $r['photo'];
                
                if(!empty($photo) && file_exists($photo))
                {
                    ?>
                <div>
                    <div class="image-box">
                        <img src="<?php echo $photo; ?>" alt="Company Logo" class="letter_head_logo">
                    </div>
                </div>
                    <?php
                }
                else
                {
                    ?>
                <div class="image-box">
                    <div class="">
                        <img src="images/no.jpg" alt="Company Logo" class="letter_head_logo">
                    </div>
                </div>
                    <?php
                }
                ?>
            </div>
            
            <div class="col-md-8">
                <div class="text-center">
                    <div class="row letter_head_heading">
                        <?php echo $r['company_name']; ?>
                    </div>
                    
                    <div class="row header_content">
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo $r['contact']; ?>
                            </div>

                            <div class="col-md-3">
                                <?php echo 'No Fax'; ?>
                            </div>

                            <div class="col-md-3">
                                <?php echo $r['email']; ?>
                            </div>

                            <div class="col-md-3">
                                <?php echo $r['pobox']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
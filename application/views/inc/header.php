<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Basic Page Needs  -->
        <meta charset="utf-8">
        <title>Media View</title>

        <!-- Mobile Specific-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS-->
        


   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


    </head>
    <body>

        


    
        

        
        
            
            

        <?php
        if ($this->session->flashdata('message_error') != '') {
            echo '<div class="alert pink">' . $this->session->flashdata('message_error') . '</div>';
        }
        if ($this->session->flashdata('message_success') != '') {
            echo '<div class="alert greenb">' . $this->session->flashdata('message_success') . '</div>';
        }
        if ($this->session->flashdata('message_notice') != '') {
            echo '<div class="alert light_pink">' . $this->session->flashdata('message_notice') . '</div>';
        }
        if ($this->session->flashdata('message_info') != '') {
            echo '<div class="alert light_blue">' . $this->session->flashdata('message_info') . '</div>';
        }
        ?>


        <!--</body>-->


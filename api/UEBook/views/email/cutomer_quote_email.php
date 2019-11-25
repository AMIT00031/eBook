<?php 
$mail_content = (object)$mali_data;
?>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container" style="border: 1px solid;">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <img src="<?php echo base_url('assets/front/images/logo1.png') ?>" alt="logo" width=""/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12" style="margin-top: 20px;">
                    <div><p style="font-size:20px;color:#5C5C5C;">Dear Editor!</p></div>
                    <div class="quote">We have received a quote with requested descriptions: </div><br>

                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Seeking Property To</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->seeking_property_to) ? $mail_content->seeking_property_to : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Property Type</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->property_type) ? $mail_content->property_type : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Number of Bedroom</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->bedroom) ? $mail_content->bedroom : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Number of Bathroom</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->bathroom) ? $mail_content->bathroom : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Area</strong>
                                </td>
                                <td>
                                    <?php echo !empty($mail_content->area) ? $mail_content->area : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Property Must Have</strong>
                                </td>
                                <td>
                                    <?php echo !empty($mail_content->property_must_have) ? $mail_content->property_must_have : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Location Must Have</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->location) ? $mail_content->location : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Children</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->children) ? $mail_content->children : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Pets</strong>
                                </td>
                                <td>
                                    <?php echo!empty($mail_content->pets) ? $mail_content->pets : '' ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <p style="font-size:14px;color:#5C5C5C; font-weight: 600">From<br></p>
                    <p style="font-size:14px;color:#5C5C5C; font-weight: 600">Propery Seeker Admin</p>
                </div>
            </div>
            <br>
            <hr style="border-top: 1px solid #6b5555;width: 60%;">
        </div>
    </body>
</html>

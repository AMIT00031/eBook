<?php
//dump($response);die;
    if (!empty($response)) {
        $approval_url = !empty($response->links) ? $response->links[1]->href : '';
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<meta http-equiv="Content-Security-Policy" content="script-src 'self' ">--> 
        <!--<meta http-equiv="Content-Security-Policy" content="default-src 'self' base-uri 'self' https://*.paypal.com">-->
        <!--<script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js" type="text/javascript"></script>-->
        <script type='text/javascript' src='https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js'></script>

        <!--<script src="<?php // echo base_url('assets/front/js/checkout.js')?>"></script>-->
        <!--<script src="<?php // echo base_url('assets/front/js/paypal.js')?>"></script>-->
        
        <script type="text/javascript">
            var ppp = PAYPAL.apps.PPP({
                "approvalUrl": "<?php echo $approval_url ?>",
                "placeholder": "ppplus",
                "mode": "sandbox",
                "payerEmail": "jeevan@seoessence.com",
                "payerFirstName": "jeevan",
                "payerLastName": "singh",
                "payerTaxId": "",
                "country": "MX",
                "payerPhone": "9897146547"
            });
    </script>
    </head>
    
    <body>
        <div id="ppplus"></div>
        
    </body>
    
    
</html>
<!DOCTYPE html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>
<?php
//dump($paypal_data);die;
?>

<body>
    <div id="paypal-button-container"></div>
    <script>
        var base_url = "<?php echo base_url(); ?>";
        var userId = "<?php echo !empty($paypal_data['user_id']) ? $paypal_data['user_id']  : ''; ?>";
//        alert(base_url);
        paypal.Button.render({
            env: '<?php echo !empty($paypal_data['env']) ? $paypal_data['env']  : ''; ?>', // sandbox | production
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox: "<?php echo !empty($paypal_data['SandboxClientId']) ? $paypal_data['SandboxClientId']  : ''; ?>",
                production: "<?php echo !empty($paypal_data['ProductionClientId']) ? $paypal_data['ProductionClientId']  : ''; ?>"
            },
            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,
            // payment() is called when the button is clicked
            payment: function (data, actions) {

                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: {total: "<?php echo !empty($paypal_data['amount']) ? $paypal_data['amount']  : ''; ?>", currency: "<?php echo !empty($paypal_data['currency']) ? $paypal_data['currency']  : ''; ?>"}
                            }
                        ]
                    }
                });
            },
            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function (data, actions) {
                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function () {
                    alert('paypal authorized successfully please click ok to continue.');
                    window.location = base_url + "paypal_payment/execute_payment?payment_id=" + data.paymentID + "&payer_id=" + data.payerID + "&token=" + data.paymentToken+"&user_id="+userId;
                });
            }

        }, '#paypal-button-container');

    </script>
</body>
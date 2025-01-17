<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago del producto</title>

    
</head>
<body>
    
<div id="paypal-button-container"></div>

<script src="https://www.paypal.com/sdk/js?client-id=AZngSZMPtOpffDb_uChrAU9x269R01s32OYn0vL67Su_4aksQP5dYieg7M0WzsgFHQMSI9ZBm9km14m5&currency=USD"></script>

<script>
    paypal.Buttons({
        style: {
            color:  'blue',
            shape:  'pill',
            label:  'pay',
        },
        
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: 100
                    }
                }]
            });
            
        },
        
        onApprove: function(data, actions) {
            actions.order.capture().then(function(detalles){
                console.log(detalles);
            });
        },
        
        onCancel: function(data){
            alert('Su pago ha sido cancelado');
            console.log(data);
        }
       
    }).render('#paypal-button-container');
</script>
</body>
</html>
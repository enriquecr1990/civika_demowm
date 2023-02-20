$(document).ready(function(){
    VSACHK.onVisaCheckoutReady();
});

var VSACHK = {
    onVisaCheckoutReady : function (){
        V.init( {
            apikey: "ECTBTLCNBLJ416KFH71U218ccgM7g-VBVZM0MW9kgXGOW9KNQ",
            paymentRequest:{
                currencyCode: "MXN",
                subtotal: "1000.00"
            }
        });
        V.on("payment.success", function(payment)
        {alert(JSON.stringify(payment)); });
    }
}
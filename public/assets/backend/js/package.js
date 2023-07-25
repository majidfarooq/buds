
// $('.must_be_float').keyup(function () {
//   alert(this.value)
//   // this.value = this.value
//   //   .match(/\d*/g).join('')
//   //   .match(/(\d{0,3})(\d{0,3})(\d{0,4})/).slice(1).join('-')
//   //   .replace(/-*$/g, '');
// });

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
//
// $(".calculate_amount").change(function () {
//   if ($('#price').val()) {
//     var price = parseFloat($('#price').val())
//     if (price > 0) {
//       if ($('#tax').val()) {
//         var tax = parseFloat($('#tax').val())
//       } else {
//         var tax = 0
//       }
//       if ($('#delivery_fee').val()) {
//         var delivery_fee = parseFloat($('#delivery_fee').val())
//       } else {
//         var delivery_fee = 0
//       }
//       tax_amount = (price * tax) / 100
//       var total = price + tax_amount + delivery_fee
//       var price = $('#amount').val(parseFloat(total))
//     }
//
//   } else {
//     var price = 0
//   }
//
//
// });

$(".calculate_amount").change(function () {
    if ($('#amount').val()) {
        var total_price = parseFloat($('#amount').val())
        if (total_price > 0) {
            // Tax Calculation 
            if ($('#tax').val()) {
                var tax = parseFloat($('#tax').val())
            } else {
                var tax = 0
            }

            var price_before_tax = (total_price * 100) / (100 + tax);
            var tax_amount = total_price - price_before_tax

            // Markup Calculations
            if ($('#mark_up').val()) {
                var mark_up = parseFloat($('#mark_up').val())
            } else {
                var mark_up = 0
            }

            var markup_amount = price_before_tax * (mark_up / 100);
            var amount_before_markup = price_before_tax - markup_amount

            if ($('#delivery_fee').val()) {
                var delivery_fee = parseFloat($('#delivery_fee').val())
            } else {
                var delivery_fee = 0
            }

            var price_before_delivery = amount_before_markup - delivery_fee;


            var price = $('#price').val(parseFloat(price_before_delivery).toFixed(2));
            $('#tax_amount').html(parseFloat(tax_amount + '%').toFixed(2));
            $('#mark_up_amount').html(parseFloat(markup_amount + '%').toFixed(2));
        }
    } else {
        var price = 0
    }

});

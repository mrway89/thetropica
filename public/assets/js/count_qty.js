
$("body").on('click', '.plus', function () {
    if ($(this).prev().val()) {
        $(this).prev().val(+$(this).prev().val() + 1);
        $(this).prev('.txt-qty').trigger('change');
    }
});
$("body").on('change','.txt-qty',function () {
    if ($(this).val() > 1){
        $(this).prev('.minus').addClass('active');
    } else {
        $(this).prev('.minus').removeClass('active');
    }
});
$("body").on('click', '.minus', function () {
    if ($(this).next().val() > 1) {
        if ($(this).next().val() > 1)
            $(this).next().val(+$(this).next().val() - 1);
            $(this).next('.txt-qty').trigger('change');
    }
});
$("body").on('click', '.txt-qty', function () {
    if ($(this).val() < 1) {
        $(this).val(1);
    }
});
// $(".txt-qty-top").focusout(function () {
//      if ($(this).val() < 1) {
//         $(this).val(1);
//     }
// });

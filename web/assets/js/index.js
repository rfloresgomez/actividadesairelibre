/**
 * Created by btt_9 on 19/04/2017.
 */
$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $('select').material_select();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });
    $('#textarea1').val('New Text');
    $('#textarea1').trigger('autoresize');

    $(".quitarse").mouseenter(function () {
        $(this).html("Quitarse");
    });

    $(".quitarse").mouseleave(function () {
        $(this).html("Unido");
    });
});
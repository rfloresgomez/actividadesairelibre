/**
 * Created by btt_9 on 19/04/2017.
 */
$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $('select').material_select();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        months_full: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
        months_short: [ 'En', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
        weekdays_full: [ 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' ],
        weekdays_short: [ 'Lun', 'MAr', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom' ],
        month_prev: '&#9664;',
        month_next: '&#9654;',
        format: 'yyyy/mm/dd',
    });
    $('#textarea1').val('New Text');
    $('#textarea1').trigger('autoresize');

    $(".quitarse").mouseenter(function () {
        $(this).html("Quitarse");
    });

    $(".quitarse").mouseleave(function () {
        $(this).html("Unido");
    });

    $('.collapsible').collapsible();

    $('.slider').slider();

    $('ul.tabs').tabs();

    $('.modal').modal();

});
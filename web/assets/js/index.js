/**
 * Created by btt_9 on 19/04/2017.
 */
$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $('select').material_select();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 1, // Creates a dropdown of 15 years to control year
        monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
        monthsShort: [ 'En', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
        weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
        weekdaysShort: [ 'L', 'M', 'X', 'J', 'V', 'S', 'D' ],
        showMonthsShort: undefined,
        showWeekdaysFull: undefined,
        month_prev: '&#9664;',
        month_next: '&#9654;',
        format: 'yyyy/mm/dd',
        firstDay: 1,
        min: new Date(),
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        labelMonthNext: 'Mes siguiente',
        labelMonthPrev: 'Mes anterior',
        labelMonthSelect: 'Selecciona un mes'
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
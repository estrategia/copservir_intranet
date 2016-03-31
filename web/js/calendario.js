Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(), //day
        "h+": this.getHours(), //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
        "S": this.getMilliseconds() //millisecond
    };

    if (/(y+)/.test(format))
        format = format.replace(RegExp.$1,
                (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1,
                    RegExp.$1.length == 1 ? o[k] :
                    ("00" + o[k]).substr(("" + o[k]).length));
    return format;
};

function eventClick(calEvent, jsEvent, view) {
    if (calEvent.href != null)
        window.location.replace(calEvent.href);
}

function viewRender(view, element) {
    var viewType = 1;
    if (view.name === 'basicWeek' || view.name === 'agendaWeek')
        viewType = 2;
    else if (view.name === 'basicDay' || view.name === 'agendaDay')
        viewType = 3;

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        data: {inicio: view.visStart.format('yyyy-MM-dd'), fin: view.visEnd.format('yyyy-MM-dd'), vista: viewType},
        url: requestUrl + '/intranet/calendario/resumen',
        success: function (data) {
            if (data.result == 'ok') {
                $('#calendar-summary').html(data.response);
            } else
                alert(data.response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error: ' + errorThrown);
        }
    });
}

$(document).ready(function () {
    /* initialize the calendar
     -----------------------------------------------------------------*/

    $('#calendar').fullCalendar({
        header: false,
        editable: false,
        droppable: false,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Vienes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        events: function (start, end, callback) {
            $.ajax({
                url: requestUrl + '/intranet/calendario/eventos',
                type: 'POST',
                dataType: 'json',
                beforeSend: function () { /*Loading.show();*/
                },
                complete: function () { /*Loading.hide();*/
                },
                data: {
                    inicio: Math.round(start.getTime() / 1000),
                    fin: Math.round(end.getTime() / 1000)
                },
                success: function (data) {
                    if (data.result == 'ok') {
                        var events = [];
                        $.each($.parseJSON(data.response), function (index, value) {
                            events.push({
                                id: value.id,
                                title: value.title,
                                start: value.start,
                                end: value.end,
                                color: value.color,
                                href: value.href,
                                allDay: false
                            });
                        });
                        callback(events);
                    } else {
                        alert(data.response);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /*Loading.hide();*/
                    alert('Error: ' + errorThrown);
                }
            });
        },
        eventClick: eventClick,
        viewRender: viewRender
    });

    //Get the current date and display on the tile
    var currentDate = $('#calendar').fullCalendar('getDate');

    $('#calender-current-day').html($.fullCalendar.formatDate(currentDate, "dddd"));
    $('#calender-current-date').html($.fullCalendar.formatDate(currentDate, "MMM yyyy"));


    $('#calender-prev').click(function () {
        $('#calendar').fullCalendar('prev');
        //currentDate = $('#calendar').fullCalendar('getDate');
        //$('#calender-current-day').html($.fullCalendar.formatDate(currentDate, "dddd"));
        //$('#calender-current-date').html($.fullCalendar.formatDate(currentDate, "MMM yyyy"));
        //return false;
    });
    $('#calender-next').click(function () {
        $('#calendar').fullCalendar('next');
        //currentDate = $('#calendar').fullCalendar('getDate');
        //$('#calender-current-day').html($.fullCalendar.formatDate(currentDate, "dddd"));
        //$('#calender-current-date').html($.fullCalendar.formatDate(currentDate, "MMM yyyy"));
    });

    $('#change-view-month').click(function () {
        $('#calendar').fullCalendar('changeView', 'month');
        $(this).parent().children().removeClass('active');
        $(this).addClass('active');
        return false;
    });

    $('#change-view-week').click(function () {
        $('#calendar').fullCalendar('changeView', 'agendaWeek');
        $(this).parent().children().removeClass('active');
        $(this).addClass('active');
        return false;
    });
    $('#change-view-day').click(function () {
        $('#calendar').fullCalendar('changeView', 'agendaDay');
        $(this).parent().children().removeClass('active');
        $(this).addClass('active');
        return false;
    });
});
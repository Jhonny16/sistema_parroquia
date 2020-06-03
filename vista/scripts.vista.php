<!-- jQuery 3 -->
<script src="../util/lte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../util/lte/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="../util/lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../util/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../util/lte/bower_components/select2/dist/js/select2.full.min.js"></script>

<!--DATA TABLE -->
<script src="../util/lte/bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="../util/lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>

<!-- bootstrap datepicker -->
<script src="../util/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../util/lte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!--DATA TIMEPICKER  -->
<script src="../util/lte/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--sweet alert-->
<script src="../util/lte/bower_components/swa/sweetalert-dev.js"></script>

<!-- SlimScroll -->
<script src="../util/lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../util/lte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../util/lte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../util/lte/dist/js/demo.js"></script>
<!--  Mostrar el cuadro arrastar imagen -->
<script src="../util/dropify/js/dropify.min.js"></script>

<script src="../util/lte/plugins/iCheck/icheck.min.js"></script>

<script src="../util/lte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../util/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- fullCalendar -->
<script src="../util/lte/bower_components/moment/min/moment.min.js"></script>

<!--MENSAJERÍA DE TEXTO DE FORMA AUTOMÁTICA-->
<script src="js/mensajes_texto.js"></script>
<script>


    $('.select2').select2()

    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })

    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })


    //Date range picker
    $('#reservation').daterangepicker();
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    });


    // * initialize the calendar
    // -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()


    // $('#calendar').fullCalendar({
    //     header    : {
    //         left  : 'prev,next today',
    //         center: 'title',
    //         right : 'month,agendaWeek,agendaDay'
    //     },
    //     buttonText: {
    //         today: 'Hoy',
    //         month: 'Mes',
    //         week : 'Semana',
    //         day  : 'Dia'
    //     },
    //     //Random default events
    //
    //     eventRender: function (eventObj, $el) {
    //         $el.popover({
    //             title: eventObj.title,
    //             content: eventObj.description,
    //             trigger: 'hover',
    //             placement: 'top',
    //             container: 'body'
    //         });
    //     },
    //
    //     // events    : [
    //     //     {
    //     //         title          : 'All Day Event',
    //     //         description: 'description for All Day Event',
    //     //         start          : new Date(y, m, 1),
    //     //         backgroundColor: '#f56954', //red
    //     //         borderColor    : '#f56954' //red
    //     //     },
    //     //     {
    //     //         title          : 'Long Event',
    //     //         start          : new Date(y, m, d - 5),
    //     //         end            : new Date(y, m, d - 2),
    //     //         backgroundColor: '#f39c12', //yellow
    //     //         borderColor    : '#f39c12' //yellow
    //     //     },
    //     //     {
    //     //         title          : 'Meeting',
    //     //         start          : new Date(y, m, d, 10, 40),
    //     //         end          : new Date(y, m, d, 21, 40),
    //     //         allDay         : false,
    //     //         backgroundColor: '#0073b7', //Blue
    //     //         borderColor    : '#0073b7' //Blue
    //     //     },
    //     //     {
    //     //         title          : 'Lunch',
    //     //         start          : new Date(y, m, d, 12, 0),
    //     //         end            : new Date(y, m, d, 14, 0),
    //     //         allDay         : false,
    //     //         backgroundColor: '#00c0ef', //Info (aqua)
    //     //         borderColor    : '#00c0ef' //Info (aqua)
    //     //     },
    //     //     {
    //     //         title          : 'Birthday Party',
    //     //         start          : new Date(y, m, d + 1, 19, 0),
    //     //         end            : new Date(y, m, d + 1, 22, 30),
    //     //         allDay         : false,
    //     //         backgroundColor: '#00a65a', //Success (green)
    //     //         borderColor    : '#00a65a' //Success (green)
    //     //     },
    //     //     {
    //     //         title          : 'Click for Google',
    //     //         start          : new Date(y, m, 28),
    //     //         end            : new Date(y, m, 29),
    //     //         url            : 'http://google.com/',
    //     //         backgroundColor: '#3c8dbc', //Primary (light-blue)
    //     //         borderColor    : '#3c8dbc' //Primary (light-blue)
    //     //     }
    //     // ],
    //     editable  : false,
    //     droppable : false, // this allows things to be dropped onto the calendar !!!
    //
    // })

</script>
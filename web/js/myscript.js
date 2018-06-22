/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('#search_button').click(function () {
    var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
    var report_from = $('#report_from').val();
    var report_to = $('#report_to').val();
    if (report_from == '') {
        $('#from_error').html('Please select From date');
        return false;
    } else if (report_from > currentDate) {
        $('#from_error').html('Please select Valid date');
        return false;
    } else if (report_to == '') {
        $('#from_error').html('');
        $('#to_error').html('Please select To date');
        return false;
    } else if (report_from > report_to) {
        $('#to_error').html('Please select Valid date');
        return false;
    } else if (report_to > currentDate) {
        $('#to_error').html('Please select Valid date');
        return false;
    }
    $('#from_error').html('');
    $('#to_error').html('');
    // alert("Mail Sent");
});


$(document).ready(function () {
    $('.dataTable').dataTable({
        "aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
        "aLengthMenu": [[10, 20, 50, 100, 150, -1], [10, 20, 50, 100, 150, "All"]],
        "iDisplayLength": 10,
       "ordering": false,
        
    });
});


$.fn.dataTable.ext.errMode = 'none'; $('#table-id').on('error.dt', function(e, settings, techNote, message) { console.log( 'An error occurred: ', message); });
import $ from 'jquery';

$(document).ready(function(){
    $('#modal-logout').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus');
      })
})
import $ from 'jquery'

$('.isLeader').on('click', function(){
    if ($(this).is(':checked')){
        $('.workTeam').addClass('d-none')
        $("label[for= 'register_workTeam']").addClass('d-none')
    }else{
        $('.workTeam').removeClass('d-none')
        $("label[for= 'register_workTeam']").removeClass('d-none')
    }
})
    
import $ from 'jquery'

$('.isLeader').on('click', function(){
    if ($(this).is(':checked')){
        $('.workTeam').addClass('d-none')
    }else{
        $('.workTeam').removeClass('d-none')
    }
})
    
$(function(){
    $('body').on('entity-saved', function(event,data){
        if(data.num_sniic){
            $('#num-sniic').html(data.num_sniic);
        }
    });
});
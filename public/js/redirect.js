$(".redirect").click(function (e){
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
        type: "GET",
        url: "/dashboard/" + $(this).attr('id'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    .done(function(html){
        if(parseInt(html) != 0){
            $('#dashboard-content').empty().append(html);
        }
                
    });
    e.stopImmediatePropagation();
    return false;
});
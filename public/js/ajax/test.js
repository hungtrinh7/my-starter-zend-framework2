// test ajax
$(document).ready(function(){
    $("#show").click(function(e){
        e.preventDefault();
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json'
        }).success(function(data) {
            $('#show').after(data.html);
        });
    });
});
function infoAdd() {
    var name=$("#name").val();
    var age=$("#age").val();
    $.get('/users/info?name='+name+"&age="+age, function(d) {
        alert(d);
    });
}
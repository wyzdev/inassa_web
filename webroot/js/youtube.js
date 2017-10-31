$(document).ready(function(){
    $(".youtube").click(function(){
        for (var i = 1; i <= 12; i++) {
            document.getElementById('yvideo'+i).contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
        }
   });
});
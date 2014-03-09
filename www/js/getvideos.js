var neighborhoods = [];
var markerHTML = [];
(function($) {	
	$(document).ready(function () {
            getVideos();
            //drop();
            function getVideos(){
                     $.getJSON('backEnd.php',function(data){
                         var tmpHTML;
                         for (var ii=0; ii<data.length; ii++) {   
                                           neighborhoods.push(new google.maps.LatLng(data[ii].lat,data[ii].lng));
                                           tmpHtml="<div><div>Video</div><video width=\"320\" height=\"240\" controls><source src=\""+data[ii].url+"\" type=\"video/mp4\">Your browser does not support the video tag.</video></div>";
                                           markerHTML.push(tmpHtml);
                                        }
                         drop();
                     });
            }
            $('#btn1').click(function(){
                    getYT();
                function getYT(){
                    $( '#iframeYT' ).attr( 'src', url);
                }
            });
    });
})(jQuery);
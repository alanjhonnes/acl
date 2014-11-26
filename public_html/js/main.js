/**
 * Created by Alan Jhonnes on 11/3/2014.
 */
jQuery(document).ready(function ($) {
    var options = { $AutoPlay: true };
    var sliders = {};
    $(".jssor-gallery").each(function(){
        var id = $(this).attr('id');
        console.log("jssor gallery: " + id);
        sliders[id] = new $JssorSlider$(id, options);
    });

    //responsive code begin
    //you can remove responsive code if you don't want the slider scales
    //while window resizes
    function ScaleSlider() {

        $(".jssor-gallery").each(function(){
            var id = $(this).attr('id');
            if(id){
                console.log("scaling slider: " + id);
                var parentWidth = $('#' + id).parent().width();
                if (parentWidth) {
                    sliders[id].$ScaleWidth(parentWidth);
                    console.log(parentWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

        });


    }
    //Scale slider after document ready
    ScaleSlider();

    //Scale slider while window load/resize/orientationchange.
    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);
    //responsive code end
});
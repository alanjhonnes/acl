function equalize(){
    "use strict";
    $(".equalizer").each(function () {
        var $watch = $(this).find(".watch");
        var $heading = $(this).find(".panel-heading");
        var $footer = $(this).find(".panel-footer");
        $watch.css('height', 'auto');
        $heading.css('height', 'auto');
        $footer.css('height', 'auto');
        var heights = _.map($watch,function (e) {
                return $(e).height();
            }),

            maxHeight = Math.max.apply(null, heights);

        $watch.height(maxHeight);


        var headingHeights = _.map($heading, function (e) {
                return $(e).height();
            }),

            maxHeight = Math.max.apply(null, headingHeights);

        $heading.height(maxHeight);

        var footerHeights = _.map($footer, function (e) {
                return $(e).height();
            }),

            maxHeight = Math.max.apply(null, footerHeights);
        $footer.height(maxHeight);
    });
}


jQuery(document).ready(function ($) {

    $(window).on('load', function () {
        "use strict";
        /*** Bootstrap same column height ***/
        equalize();
        $(window).on('resize', equalize);
    });


    /***** Sliders *****/
  var options = {
      $FillMode: 1,
    $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
    $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
    $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
    $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
    $Loop: 0,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1

    $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
    $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
    $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
    //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
    //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
    $SlideSpacing: 5, 					                //[Optional] Space between each slide in pixels, default value is 0
    $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
    $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
    $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
    $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
    $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

    $ThumbnailNavigatorOptions: {
      $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
      $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
      $Loop: 0,
      $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1//[Optional] Horizontal space between each thumbnail in pixel, default value is 0
      $SpacingY: 0,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
      $DisplayPieces: 4,                             //[Optional] Number of pieces to display, default value is 1
      $ParkingPosition: 0,                          //[Optional] The offset position to park thumbnail
      $Orientation: 2                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1

    }
  };


    var sliders = {};
    $(".jssor-gallery").each(function () {
        var id = $(this).attr('id');
        console.log("jssor gallery: " + id);
        sliders[id] = new $JssorSlider$(id, options);
    });

    //responsive code begin
    //you can remove responsive code if you don't want the slider scales
    //while window resizes
    function ScaleSlider() {

        $(".jssor-gallery").each(function () {
            var id = $(this).attr('id');
            if (id) {
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



    $('.question-title').click(function(){
        "use strict";
        $(this).find('.question-arrow').toggleClass('question-open');
        $(this).next().slideToggle('fast');
    })
});



(function($) {
    var $_line, $_after, $_this, $_button, moving = false, prevX;
    $(window).on('mouseup', function() {
        moving = false;
    });
    $(window).on('mousemove', function(e) {
        var isMax = false;
        if(moving) {
            var deltaX = e.pageX - prevX;
            isMax = move(deltaX);
        }
        if(! isMax) {
            prevX = e.pageX;
        }
    });
    function move(deltaX) {
        var width = $_this.width();
        var right = $_line.css('right');
        var position = parseFloat(right);
        if (/[0-9]%$/.test(right)) position = width * (position/100);
        var newPosition = position - deltaX;
        var percent = (newPosition / width) * 100;
        var max = (($_button.width() + 4) / 2) / width * 100;
        var isMax = false;
        if(percent < max) {
            percent = max;
            isMax = true;
        } else if(percent > 100 - max) {
            percent = 100 - max;
            isMax = true;
        }
        $_line.css('right', percent + '%');
        $_after.css('width', percent + '%');
        return isMax;
    }
    $.fn.toppikImageSlider = function() {
        return this.each(function() {
            var $line = $('.toppik-image-slider-line', this)
                , $after = $('.toppik-image-slider-after', this)
                , $this = $(this)
                , $button  =$('.toppik-image-slider-button', this);
            $this.on('click', function() {
                if(toppik.isTablet()) {
                    $this.toggleClass('toppik-image-slider-show');
                }
            });
            $line.on('mousedown', function() {
                moving = true;
                $_line = $line;
                $_after = $after;
                $_this = $this;
                $_button = $button;
            });
        });
    }
    toppik.register('imageSlider', function() {
        $('.toppik-image-slider').toppikImageSlider();
    }, {
        initOnload : true
    });
}) (jQuery);
! function (a) {
    a.fn.drags = function (b) {
        if (b = a.extend({
            handle: "",
            cursor: "ew-resize"
        }, b), "" === b.handle) var c = this;
        else var c = this.find(b.handle);
        return c.css("cursor", b.cursor).on("mousedown", function (d) {
            if ("" === b.handle) var e = a(this).addClass("draggable");
            else var e = a(this).addClass("active-handle").parent().addClass("draggable");
            var f = e.css("z-index"),
                g = (e.outerHeight(), e.outerWidth()),
                h = e.offset().left + g - d.pageX;
            e.css("z-index", 1e3).parents().on("mousemove", function (b) {
                var d = c.parent().offset().left - 21,
                    e = c.parent().width() + d;
                c.siblings(".before").width(c.offset().left - c.parent().offset().left + 21), b.pageX + h - g >= d && b.pageX + h - g <= e && a(".draggable").offset({
                    left: b.pageX + h - g
                }).on("mouseup", function () {
                    a(this).removeClass("draggable").css("z-index", f)
                })
            }), d.preventDefault()
        }).on("mouseup", function () {
            "" === b.handle ? a(this).removeClass("draggable") : a(this).removeClass("active-handle").parent().removeClass("draggable")
        })
    }
}(jQuery);



 $(':not([data-activate-page=""])').click(function() {
            var id = $(this).attr('data-activate-page');
            if(id) {
                if (!$('body').hasClass('cms-page-view cms-before-and-afters')) $('.page-switch').removeClass('page-switch-active');
                else {
                    if ($('#' + id).parent().hasClass('container-men'))
                        $('.container-men .page-switch').removeClass('page-switch-active');
                    else
                        $('.container-women .page-switch').removeClass('page-switch-active');
                }
                $('#' + id).addClass('page-switch-active');
            }
        });

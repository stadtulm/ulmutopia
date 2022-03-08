var Project = Project || {};
(function(window, $, exports, undefined) {
    exports.ajaxUrl = ''; // will be filled by the JS code in footer.php
    exports.init = function() {
        initCarousels();
        scaleStage();
        initIslands();
        initGaleries();
        initTips();
        initMessageBoxes();
        initTooltipMenus();

        $(window).resize(function() {
            scaleStage();
        });

        if($('#contact-form').length > 0) {
            initContactForm();
        }

         $('.hamburger').click(function() {
            //$(this).toggleClass('is-active');
            $('.mobile-menu').toggleClass('active');
        });

        $('.mobile-menu .back').click(function() {
            //$('.hamburger').toggleClass('is-active');
            $('.mobile-menu').toggleClass('active');
        });
    }

    let initIslands = function() {
        //If the pages starts on on top (e.g. after reload) this moves the navbar where it needs to be
        positionIslands();

        //This moves the navigation bar to the top of the page after scrolling
        $(window).on('scroll', function() {
            positionIslands();
        });
    };


   let positionIslands = function() {
        if($(window).scrollTop() > 0) {
            $('.island-overlay').css('z-index', '2');
        } else {
            $('.island-overlay').css('z-index', '5');
        }
   };

    let scaleStage = function() {
        if(!$('.stage').hasClass('small')) {
            let scaleFactor = 656/1920;
            $('.stage').height($(window).width() * scaleFactor);
        }
    };

    let initGaleries = function () {

        $('.image-gallery a').featherlightGallery({
           // previousIcon: '&#9664;',     /* Code that is used as previous icon */
            //nextIcon: '&#9654;',         /* Code that is used as next icon */
            previousIcon: '<div class="prev-icon"></div>',     /* Code that is used as previous icon */
            nextIcon: '<div class="next-icon"></div>',         /* Code that is used as next icon */
            galleryFadeIn: 100,          /* fadeIn speed when slide is loaded */
            galleryFadeOut: 300          /* fadeOut speed before slide is loaded */
        });

        $.featherlightGallery.prototype.afterContent = function() {
            //Remove Prev/Fwd Button if it's only a single image
            if(this.$currentTarget.parents('.image-gallery').hasClass('single')) {
                this.$instance.find('.featherlight-previous, .featherlight-next').remove();
            }

            var caption = this.$currentTarget.find('.image-container').data('copyright');
            this.$instance.find('.caption').remove();
            $('<div class="caption">').text(caption).appendTo(this.$instance.find('.featherlight-content'));
        };
    }

    let initCarousels = function() {
        $('.carousel-container').each(function() {
            let carouselElement =  $(this).find('.carousel').get(0);
            let controlElement = $(this).find('.controls').get(0);
            let prevElement = $(this).find('.controls').find('.prev').get(0);
            let nextElement = $(this).find('.controls').find('.next').get(0);

            var slideCount = parseInt($(this).data('slide-count'));

            var slider = tns({
                "container": carouselElement,
                "items": slideCount,
                "rewind": false,
                "swipeAngle": false,
                "mouseDrag": true,
                "speed": 400,
                "gutter": 30,
                "nav": false,
                "controlsContainer": controlElement,
                "prevButton": prevElement,
                "nextButton": nextElement,
                edgePadding: 0,
                responsive: {
                    1480: {
                        items: slideCount,
                        edgePadding: 0,
                    },

                    1300: {
                        items: slideCount-1,
                        edgePadding: 0,
                    },

                    900: {
                        items: slideCount-1,
                        edgePadding: 0,
                    },

                    600: {
                        items: 2,
                        edgePadding: 40,
                        //loop: false,
                        //center: true
                    },

                    420: {
                        items: 1,
                        edgePadding: 40,
                        //loop: false,
                        //center: true
                    },

                    380: {
                        items: 1,
                        edgePadding: 40,
                        //loop: false,
                        //center: true
                    },

                    320: {
                        items: 1,
                        edgePadding: 40,
                        //loop: false,
                        //center: true
                    }
                }
            });
        });

        //Add the controls to the tab index
        $('.controls').attr('tabindex', '-1');
        $('.controls button').attr('tabindex', '0');
    };

    let initMessageBoxes = function() {
        setTimeout(function(){
            $('.message-box').fadeOut();
        }, 6000);
    };

    let initContactForm = function() {
        $('#contact-form').submit(function() {
            let firstName = $('#contact-form input[name="first_name"]').val();
            let lastName = $('#contact-form input[name="last_name"]').val();
            let email = $('#contact-form input[name="email"]').val();
            let institution = $('#contact-form input[name="institution"]').val();
            let message = $('#contact-form textarea[name="message"]').val();

             $.ajax({
                url: Project.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cortex_send_contact_form',
                    data: {
                       firstName: firstName,
                       lastName: lastName,
                       email: email,
                       institution: institution,
                       message: message,
                    }
                },
                dataType: 'json'
            }).done(function (result) {
                if(result.success) {
                    $('#contact-form .success-message').css('display', 'flex');
                    $('#contact-form .success-message .message').html($('#contact-form .success-message').data('message'));
                    $('#contact-form input[type=submit]').hide();
                }
            }).fail(function () {
            });

            return false;
        });
    };

    let initTooltipMenus = function() {
        $('.open-tooltip-menu').click(function() {
            let tooltipId = $(this).data('menu-id');
            $('#' + tooltipId).css('visibility', 'visible');
            $('#' + tooltipId).css('opacity', '1');
        });

        $(document).mouseup(function(e) {
            var container = $(".tooltip-menu");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $(".tooltip-menu").css('visibility', 'hidden');
                $(".tooltip-menu").css('opacity', '0');
            }
        });
    };

    let initTips = function() {
        if($('.tip-overview').length > 0) {
            $('.tip-tile .read-more').click(function() {
                $(this).parents('.tip-tile').find('.tip-description').css('max-height', '100%');
                $(this).parents('.tip-tile').find('.tip-description-fade').hide();
                $(this).remove();
                return false;
            });

            $('.show-more-tips').click(function() {
                $(this).parents('.tip-overview').find('.tip-tile').slideDown();
                $(this).remove();

                return false;
            });
        }
    };
})(window, jQuery, Project);

jQuery(function(){
    Project.init();
});

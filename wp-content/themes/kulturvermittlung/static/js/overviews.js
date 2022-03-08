var Overviews = Overviews || {};
(function(window, $, exports, undefined) {


    exports.init = function() {
        if($('#profile-filters').length > 0) {
            initProfileFilters();
        }

        if($('#offer-filters').length > 0) {
            initOfferFilters();
        }

        if($('#tip-category-select').length > 0) {
            initTipOverview();
        }
    };

    let initProfileFilters = function() {
        $('#profile-filters #categories .clickable-label').click(function() {
            filterProfiles();
        });
    };

    let filterProfiles = function() {
        $('#profile-loader').show();

        let categories = [];
        $('#categories input[name="sparten[]"]:checked').each(function() {
            categories.push($(this).val());
        });

        $.ajax({
            url: Project.ajaxUrl,
            type: 'POST',
            data: {
                action: 'kulturvermittlung_get_profiles',
                data: {
                   categories: categories,
                   searchString: ''
                }
            },
            dataType: 'json'
        }).done(function (result) {
            $('#profile-loader').hide();
            if(result.success) {
                $('.profile-overview').html(result.data.html);
            }
        }).fail(function () {});

        if($('.offer-overview').length > 0) {
            $.ajax({
                url: Project.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'kulturvermittlung_get_offers',
                    data: {
                       categories: categories,
                       searchString: ''
                    }
                },
                dataType: 'json'
            }).done(function (result) {
                if(result.success) {
                    $('.offer-overview').html(result.data.html);
                }
            }).fail(function () {});
        }
    };

    let initOfferFilters = function() {
        $('#offer-filters #categories .clickable-label').click(function() {
            filterOffers();
        });

        var slider = document.getElementById('age-slider');
        noUiSlider.create(slider, {
            start: [0, 100],
            connect: true,
            step: 1,
            range: {
                'min': 0,
                'max': 100
            },
            format: {
                from: function(value) {
                    return parseInt(value);
                },
                to: function(value) {
                    return parseInt(value);
                }
            },
            tooltips: true
        });

        //0 looks strange if it is for everybody, so shown nothing!
        $('#age-slider .noUi-tooltip').html('');

        slider.noUiSlider.on('change', function (values, handle) {
            let ageMin = '';
            if(values[0] == '1') {
                ageMin = values[0] + ' Jahr';
            } else{
                ageMin = values[0] + ' Jahre';
            }

            let ageMax = '';
            if(values[1] == '1') {
                ageMax = values[1] + ' Jahr';
            } else{
                ageMax = values[1] + ' Jahre';
            }

            $('#min-age-label').html(ageMin + ' - ' + ageMax);

            /*if(values[handle] == 0) {
                $('#min-age-label').html('alle');
                //0 looks strange if it is for everybody, so shown nothing!
                $('#age-slider .noUi-tooltip').html('');
            } else {
                $('#min-age-label').html(values[handle] + ' Jahre');
            }*/

            filterOffers();
        });
    };

    let filterOffers = function() {
        $('#offer-loader').show();
        let categories = [];
        let ageMin = 0;
        let ageMax = 100;

        if($('#age-slider').length > 0) {
            var slider = document.getElementById('age-slider');
            let sliderValues = slider.noUiSlider.get(true);
            ageMin = sliderValues[0];
            ageMax = sliderValues[1];

            slider.noUiSlider.on('change', function (values, handle) {
                $('#age-slider').attr('aria-valuenow', values[0] + '-' + values[1]);
            });
        }

        $('#categories input[name="sparten[]"]:checked').each(function() {
            categories.push($(this).val());
        });

        $.ajax({
            url: Project.ajaxUrl,
            type: 'POST',
            data: {
                action: 'kulturvermittlung_get_offers',
                data: {
                   categories: categories,
                   ageMin: ageMin,
                   ageMax: ageMax,
                   searchString: ''
                }
            },
            dataType: 'json'
        }).done(function (result) {
            $('#offer-loader').hide();
            if(result.success) {
                $('.offer-overview').html(result.data.html);
            }
        }).fail(function () {});
    };

    let initTipOverview = function() {
        $('#tip-category-select').change(function() {
            let category = $(this).val();
            if(category != '-1') {
                $.ajax({
                    url: Project.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'kulturvermittlung_get_tips',
                        data: {
                           category: category,
                        }
                    },
                    dataType: 'json'
                }).done(function (result) {
                   // $('#offer-loader').hide();
                    if(result.success) {
                        $('#tip-overview').html(result.data.html);
                    }
                }).fail(function () {});
            }
        });
    };

})(window, jQuery, Overviews);

jQuery(function(){
    Overviews.init();
});
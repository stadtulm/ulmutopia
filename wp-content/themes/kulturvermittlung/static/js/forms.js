var Forms = Forms || {};
(function(window, $, exports, undefined) {
    exports.init = function() {
        initAccessibility();
        initAddAndRemoveButtons();
        initSelect2();
        initClickableLabels();
        initRangeSliders();
        initImageUploads();
        initCheckmarks();
        revealPasswords();
        initDatePickers();
        initPreviewButton();

    };

    let initAccessibility = function() {
     $('#category-search-form input').keyup(function() {
            if($(this).val().length > 0) {
                $('#category-search-form label').hide();
            } else {
                $('#category-search-form label').closest('label').show();
            }
        });

        $('.info-icon-container').click(function(e) {
            if($(this).find('.info-tooltip').css("visibility") === "visible") {
                $(this).find('.info-tooltip').css('visibility','hidden');
                $(this).find('.info-tooltip').css('opacity','0');
            } else {
                $(this).find('.info-tooltip').css('visibility','visible');
                $(this).find('.info-tooltip').css('opacity','1');
            }
            return false;
        });

        $(document).on('keyup', function(e) {
            if (e.key == "Escape") {
                //close any open tooltip or tooltip menu
                $('.info-tooltip').css('visibility','hidden');
                $('.info-tooltip').css('opacity','0');

                $(".tooltip-menu").css('visibility', 'hidden');
                $(".tooltip-menu").css('opacity', '0');
            }
        });
    };

    let initAddAndRemoveButtons = function() {
        $('#add-video-link-input').click(function() {
            addVideoLink();
            return false;
        });

        $('#add-file-input').click(function() {
            let clonedInput = $('#files .input-container').first().clone();
            clonedInput.find('input').val('');
            clonedInput.find('.remove').removeClass('hidden');

            $('#files').append(clonedInput);
            return false;
        });

        $('#add-gallery-input').click(function() {
            //Add the gallery input
            let clonedInput = $('#image-gallery-upload-template').clone();
            clonedInput.attr('id', '');
            clonedInput.removeClass('hidden');
            clonedInput.find('input').val('');
            clonedInput.find('input').attr('name', 'image_gallery_image[]');

            $('#image-uploads').append(clonedInput);

            let previewContainer = clonedInput.find('.preview-image');
            let targetURL = clonedInput.data('upload-url');
            let width = clonedInput.data('width');
            let height = clonedInput.data('height');
            let withCropper = clonedInput.data('with-cropper');
            console.log(withCropper);

            var dropzone = clonedInput.dropzone({
                maxFilesize: 10,
                url: targetURL,
                autoProcessQueue: false,
                previewsContainer: previewContainer.get(0),
                thumbnailWidth: width/2,
                thumbnailHeight: height/2,

                thumbnail: function(file, dataURL) {
                   let dropzone = this;
                    // ignore files which were already cropped and re-rendered
                    // to prevent infinite loop
                    if (file.cropped) {
                        return;
                    }

                   if(withCropper) {
                        if (file.width < 800) {
                            // validate width to prevent too small files to be uploaded

                            return;
                        }

                        // cache filename to re-assign it to cropped file
                        var cachedFilename = file.name;

                        // remove not cropped file from dropzone (we will replace it later)
                        dropzone.removeFile(file);

                        let image = new Image();
                        let cropper = null;
                        image.src = URL.createObjectURL(file);

                        $.featherlight($('.cropper-template'), {
                            variant: 'image-cropper',
                            openSpeed: 100,
                            closeSpeed: 100,
                            closeOnClick: false,
                            closeOnEsc: false,
                            afterOpen: function () {
                                $('.image-cropper .image').append(image);

                                // viewMode 2 means no transparent allowed
                                cropper = new Cropper(image, {
                                    aspectRatio: width / height,
                                    autoCropArea: 0.5,
                                    viewMode: 2,
                                    movable: false,
                                    cropBoxResizable: true,
                                });
                            }
                        });

                        $('.image-cropper .confirm-crop').on('click', function () {
                            // Get the canvas with image data from Cropper.js
                            let canvas = cropper.getCroppedCanvas({width: width, height: height});
                            var blob = canvas.toDataURL("image/jpeg", 0.82);

                            // transform it to Blob object
                            var newFile = dataURItoBlob(blob);
                            file.previewElement.querySelector("img").src = blob;

                            console.log(previewContainer);

                            previewContainer.find('img').attr('src', blob);
                            previewContainer.find('img').hide();
                            // set 'cropped to true' (so that we don't get to that listener again)
                            newFile.cropped = true;
                            // assign original filename
                            newFile.name = cachedFilename;

                            //add cropped file to dropzone
                            dropzone.addFile(newFile);
                            // upload cropped file with dropzone
                            dropzone.processQueue();

                            $.featherlight.close();
                        });
                    } else {
                        file.cropped = true;
                        previewContainer.find('img').attr('src', file.dataURL);
                        //add cropped file to dropzone
                        dropzone.addFile(file);
                        // upload cropped file with dropzone
                        dropzone.processQueue();

                        return;
                    }
                },
                init: function() {
                    this.on("success", function(file, response) {
                        if(response.success) {
                            clonedInput.find('.image-upload-hidden-field').val(response.data.filename);
                            clonedInput.find('.remove').removeClass('hidden');
                            previewContainer.find('img').show();
                        }
                     });

                    this.on("maxfilesexceeded", function(file) {
                        console.log("File too big!");
                    });
                },
                acceptedFiles: 'image/*',

            });

            //Add the copyright notice
            clonedCopyrightInput = $('#image-gallery-copyright-template input').clone();
            clonedCopyrightInput.attr('name', 'copyright_bildergalerie[]');

            //Count the current copyright notices and set the id and placeholder accordingly
            let copyrightNoticeCount = $('input[name="copyright_bildergalerie[]"]').length + 1;

            clonedCopyrightInput.attr('id', clonedCopyrightInput.attr('id') + copyrightNoticeCount);
            clonedCopyrightInput.attr('placeholder', clonedCopyrightInput.attr('placeholder') + copyrightNoticeCount);

            $('#copyright-notices').append(clonedCopyrightInput);

            return false;
        });

        $('#add-cooperation-input').click(function (){
            addExternalCooperationInput();
            
            return false;
        });

        $(document).on('click', '.input-container .remove', function (event) {
            $(this).parent('.input-container').remove();
        });

        $(document).on('click', '.file-container .remove', function (event) {
            $(this).parent('.file-container').remove();
        });


        $(document).on('click', '.remove-cooperation', function (event) {
            if($('.external-cooperation-partners .rows .form-row').length > 1) {
                $(this).parent('.form-row').remove();
            } else {
                $(this).parent('.form-row').find('input').val('');
                $(this).parent('.form-row').find('textarea').val('');
            }
        });

        $(document).on('click', '.image-upload .remove, .image-gallery-upload .remove', function (event) {
            if($(this).parent('.image-upload, .image-gallery-upload').find('.image-upload-hidden-field').val() == '') {
                //If the user clicks the X on an empty gallery element we remove it
                $(this).parent('.image-upload, .image-gallery-upload').remove();
                $('#copyright-notices input:last-child').remove();
            } else {
                $(this).parent('.image-upload, .image-gallery-upload').find('.preview-image img').attr('src', '');
                $(this).parent('.image-upload, .image-gallery-upload').find('.preview-image img').attr('alt', '');
                $(this).parent('.image-upload, .image-gallery-upload').find('.image-upload-hidden-field').val('');
                $(this).addClass('hidden');
            }
        });

        $(document).on('click', '.remove-row', function (event) {
            $(this).siblings().find('input').val('');
            $(this).parent('.form-row').addClass('hidden');
            $('#' + $(this).data('add-more') + ' a').show();
        });
    };

    let initSelect2 = function() {
        $('.select-box').select2();
    };

    let initClickableLabels = function() {
        $('.clickable-label').click(function(){
            if($(this).hasClass('active')) {
                $(this).find('input[type=checkbox]').prop('checked', false);
            } else {
                $(this).find('input[type=checkbox]').prop('checked', 'checked');
            }

            $(this).toggleClass('active');
        });
    };

    let initImageUploads = function() {
        $('.image-upload').each(function() {
            let imageUpload = $(this);
            let previewContainer = $(this).find('.preview-image');
            let errorField = $(this).siblings('.image-error');
            let targetURL = $(this).data('upload-url');
            let width = $(this).data('width');
            let height = $(this).data('height');
            let withCropper = $(this).data('with-cropper');

            var dropzone = $(this).dropzone({
                url: targetURL,
                maxFilesize: 10,
                autoProcessQueue: false,
                previewsContainer: previewContainer.get(0),
                thumbnailWidth: width/2,
                thumbnailHeight: height/2,

                thumbnail: function(file, dataURL) {
                    errorField.hide();
                    let dropzone = this;
                    // ignore files which were already cropped and re-rendered
                    // to prevent infinite loop
                    if (file.cropped) {
                        return;
                    }

                   if(withCropper) {
                        if (file.width < 800) {
                            errorField.show();
                            return;
                        }

                        // cache filename to re-assign it to cropped file
                        var cachedFilename = file.name;

                        // remove not cropped file from dropzone (we will replace it later)
                        dropzone.removeFile(file);

                        let image = new Image();
                        let cropper = null;
                        image.src = URL.createObjectURL(file);

                        $.featherlight($('.cropper-template'), {
                            variant: 'image-cropper',
                            openSpeed: 100,
                            closeSpeed: 100,
                            closeOnClick: false,
                            closeOnEsc: false,
                            afterOpen: function () {
                                $('.image-cropper .image').append(image);

                                // viewMode 2 means no transparent allowed
                                cropper = new Cropper(image, {
                                    aspectRatio: width / height,
                                    autoCropArea: 0.5,
                                    viewMode: 2,
                                    movable: false,
                                    cropBoxResizable: true,
                                });
                            }
                        });

                        $('.image-cropper .confirm-crop').on('click', function () {
                            // Get the canvas with image data from Cropper.js
                            let canvas = cropper.getCroppedCanvas({width: width, height: height});
                            var blob = canvas.toDataURL("image/jpeg", 0.82);

                            // transform it to Blob object
                            var newFile = dataURItoBlob(blob);
                            file.previewElement.querySelector("img").src = blob;

                            previewContainer.find('img').attr('src', blob);
                            previewContainer.find('img').hide();

                            // set 'cropped to true' (so that we don't get to that listener again)
                            newFile.cropped = true;
                            // assign original filename
                            newFile.name = cachedFilename;

                            //add cropped file to dropzone
                            dropzone.addFile(newFile);
                            // upload cropped file with dropzone
                            dropzone.processQueue();

                            $.featherlight.close();
                        });
                    } else {
                        file.cropped = true;
                        previewContainer.find('img').attr('src', file.dataURL);
                        //add cropped file to dropzone
                        dropzone.addFile(file);
                        // upload cropped file with dropzone
                        dropzone.processQueue();

                        return;
                    }
                },

                init: function() {
                    this.on("addedfiles", function(listFiles) {
                       previewContainer.addClass('hidden');
                       $('form').find('input[type="submit"]').attr('disabled', true);
                       $('form').find('#main-form-loader').css('display', 'inline-block');
                    });

                    this.on("success", function(file, response) {
                        if(response.success) {
                            imageUpload.find('.image-upload-hidden-field').val(response.data.filename);
                            imageUpload.find('.remove').removeClass('hidden');
                            previewContainer.removeClass('hidden');
                            previewContainer.find('img').show();
                        }

                        $('form').find('input[type="submit"]').attr('disabled', false);
                        $('form').find('#main-form-loader').hide();
                    });
                    this.on("maxfilesexceeded", function(file) {
                        console.log("File too big!");
                    });
                },
                acceptedFiles: 'image/*',
            });
        });
    };

    let dataURItoBlob = function(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: 'image/jpeg' });
        }


    let initRangeSliders = function() {
        if($('#age-range-slider').length > 0) {
            var slider = document.getElementById('age-range-slider');
            let ageMin = $('#zielgruppe_von').val();
            let ageMax = $('#zielgruppe_bis').val();

            noUiSlider.create(slider, {
                start: [ageMin, ageMax],
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

            slider.noUiSlider.on('change', function (values, handle) {
                if(handle == 0) {
                   $('#zielgruppe_von').val(values[handle]);
                } else {
                    $('#zielgruppe_bis').val(values[handle]);
                }

                $('#age-range-slider').attr('aria-valuenow', values[0] + '-' + values[1]);
            });
        }
    };

    let addVideoLink = function() {
        let clonedInput = $('#videos .input-container').first().clone();
        clonedInput.find('input').val('');
        clonedInput.find('.remove').removeClass('hidden');
        $('#videos').append(clonedInput);
    }

    let addExternalCooperationInput = function() {
        let formRow = $('.external-cooperation-partners .rows .form-row:first-child').clone();
        formRow.find('input').val('');
        formRow.find('textarea').val('');
        $('.external-cooperation-partners .rows').append(formRow);
    }

    exports.initRegistrationForm = function() {
        $('.show-contact-person-row').click(function() {
            let rowId = $(this).data('row-id');
            $('#' + rowId).removeClass('hidden');
            $(this).hide();

            return false;
        });

        const prefix = "ulmutopia"; //  href for the page
        const formId = "register-form"; // ID of the form
        const formIdentifier = `${prefix}-${formId}`;

        $('#store-register-form').click(function() {
            saveRegisterForm(formIdentifier);
            return false;
        });

        //Only load on the registration and not the profile edit form
        if($('input[name="user_id"]').length == 0) {
            if(localStorage.getItem(formIdentifier)) {
                populateRegisterForm(formIdentifier);
                $('#form-loaded').removeClass('hidden');
            }
        }

        $('#register-form').submit(function() {
            $('.error-message').hide();
            $('.success-message').html();

            let formValid = checkRegisterForm();
            //If we send the form, we delete the zwischenspeicherung
            if(formValid) {
                localStorage.removeItem(formIdentifier);
            }
            return formValid;
        });
    };

    let checkRegisterForm = function() {
        //Check if we have at least one Sparte
        if($('input[name="sparten[]"]:checked').length == 0) {
            $('.error-message.sector').show();
            return false;
        }

        //Required Fields
        if($('input[name="name_institution_kuenstlerin"]').val() == '' ||
        $('input[name="ansprechperson_1_vorname"]').val() == '' ||
        $('input[name="ansprechperson_1_nachname"]').val() == '' ||
        $('input[name="strasse"]').val() == '' ||
        $('input[name="hausnummer"]').val() == '' ||
        $('input[name="plz"]').val() == '' ||
        $('input[name="ort"]').val() == '' ||
        $('input[name="telefon"]').val() == '' ||
        $('input[name="email"]').val() == '' ||
        $('input[name="name_institution_kuenstlerin"]').val() == '' ||
        $('textarea[name="profilbeschreibung"]').val() == '') {
            $('.error-message.required-fields').show();
            return false;
        }

        //Profile Image selected?
        if($('input[name="profile_image"]').val() == '') {
            $('.error-message.profile-image').show();
            return false;
        }

        //Title Image selected?
        if($('input[name="title_image"]').val() == '') {
            $('.error-message.title-image').show();
            return false;
        }

        //Check for gallery image copyrights
        for (let i = 1; i <= 3; i++) {
            if($('input[name="image_gallery_image_' + i + '"]').val() != '') {
                if($('input[name="copyright_bildergalerie_' + i + '"]').val() == '') {
                    $('.error-message.copyright-image-gallery').show();
                    return false;
                }
            }
        }

        //Description length
        if($('textarea[name="profilbeschreibung"]').val().length < 400 ||  $('textarea[name="profilbeschreibung"]').val().lengh > 2000) {
            $('.error-message.description ').show();
            return false;
        }

        return true;
    };

    let initCheckmarks = function() {
        $('input[type=text], input[type=email]').filter('[required]').each(function() {
            if($(this).val() != '') {
                $(this).parent('.form-field').find('.completed').show();
            } else {
                $(this).parent('.form-field').find('.completed').hide();
            }
        });


        $('input[type=text], input[type=email]').filter('[required]').on('blur', function() {
            if($(this).val() != '') {
                $(this).parent('.form-field').find('.completed').show();
            } else {
                $(this).parent('.form-field').find('.completed').hide();
            }
        });
    };

    let revealPasswords = function() {
        $('.reveal-password').click(function() {
            var passwordField = $(this).parent('.form-field').find('input');
            if(passwordField.attr('type') == 'password') {
                passwordField.attr('type', 'text');
            } else {
                passwordField.attr('type', 'password');
            }
        });
    }


    exports.initOfferForm = function() {
        $('#art_der_termine').change(function() {
            if($(this).val() == 'freie_eingabe') {
              $('#termin_fester_wert-container').addClass('hidden');
              $('#termin_freitext').removeClass('hidden');
            } else if($(this).val() == 'fester_termin') {
              $('#termin_freitext').addClass('hidden');
              $('#termin_fester_wert-container').removeClass('hidden');
            } else {
              $('#termin_freitext').addClass('hidden');
              $('#termin_fester_wert-container').addClass('hidden');
            }
        });

        $('#offer-form').submit(function() {
            $('.error-message').hide();
            $('.success-message').html();

            let formValid = checkOfferForm();
            console.log(formValid);
            return formValid;
        });
    };

    let checkOfferForm = function() {
        let i = 0;
        let valid = true;
        $('input[name="image_gallery_image[]"]').each(function() {
            if($(this).val() != '') {
                let copyrightInput = $('input[name="copyright_bildergalerie[]"]').toArray()[i];
                if($(copyrightInput).val() == '') {
                    $('.error-message.copyright-image-gallery').show();
                    valid = false;
                }
            }

            i++;
        });

        return valid;
    };

    let initDatePickers = function() {
        flatpickr.localize(flatpickr.l10ns.de);

        $('.date-picker-input').flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            altInput: true,
            altFormat: "d.m.Y, H:i \\U\\h\\r",
        });
    };

    let saveRegisterForm = function(formIdentifier) {
        let formData = $('#register-form').serializeArray();
        localStorage.setItem(formIdentifier, JSON.stringify(formData));

        $('.success-message').html('Formular erfolgreich gespeichert.');
    };

    let populateRegisterForm = function(formIdentifier) {
        const savedData = JSON.parse(localStorage.getItem(formIdentifier));
        let fieldsToPopluate = ['name_institution_kuenstlerin',
                                'untertitel',
                                'ansprechperson_1_vorname',
                                'ansprechperson_1_nachname',
                                'ansprechperson_2_vorname',
                                'ansprechperson_2_nachname',
                                'ansprechperson_3_vorname',
                                'ansprechperson_3_nachname',
                                'strasse',
                                'hausnummer',
                                'plz',
                                'ort',
                                'telefon',
                                'fax',
                                'email',
                                'image_gallery_image_1',
                                'image_gallery_image_2',
                                'image_gallery_image_3',
                                'copyright_bildergalerie_1',
                                'copyright_bildergalerie_2',
                                'copyright_bildergalerie_3',
                                'profile_image',
                                'copyright_profilbild',
                                'title_image',
                                'copyright_titelbild',
                                'my_website',
                                'my_video_channel',
                                'my_facebook',
                                'my_instagram',
                                'videokonferenzen',
                                'gemeinsames_arbeiten',
                                'kommunikation',
                                'sonstiges',
                                'social_media',
                                'videoplattformen',
                                'soundplattformen',
                                ];

        let imagePreviews = ['image_gallery_image_1', 'image_gallery_image_2', 'image_gallery_image_3', 'profile_image','title_image'];
        let textAreas = ['technische_ausstattung','profilbeschreibung'];
        let showAnsprechpartner2 = false;
        let showAnsprechpartner3 = false;

        let videos = [];
        let videoTitles = [];
        let partnerNames = [];
        let partnerUrls = [];
        let partnerDescriptions = [];

        savedData.forEach(function callback(currentRow) {
            let key = currentRow.name;
            if(fieldsToPopluate.includes(key)) {
                $('input[name="' + key + '"]').val(currentRow.value);
            } else if(key == 'sparten[]') {
                $('#' + currentRow.value).attr('checked', 'checked');
                $('.clickable-label.' + currentRow.value).addClass('active');
            } else if(key == 'videos[]') {
                videos.push(currentRow.value);
            } else if(key == 'video-titles[]') {
                videoTitles.push(currentRow.value);
            } else if(key == 'videokonferenz_moeglich') {
                if(currentRow.value == 1) {
                    $('#videokonferenz_moeglich_ja').attr('checked', 'checked');
                } else if(currentRow.value == 0) {
                    $('#videokonferenz_moeglich_nein').attr('checked', 'checked');
                }
            } else if(textAreas.includes(key)) {
                $('textarea[name="' + key + '"]').html(currentRow.value);
            } else if(key == 'kooperationspartner_intern[]') {
                $('select#kooperationspartner_intern option[value=' + currentRow.value + ']').attr('selected', 'selected');
                $('select#kooperationspartner_intern').trigger("change");
            } else if(key == 'partner_name[]') {
                partnerNames.push(currentRow.value);
            }  else if(key == 'partner_url[]') {
                partnerUrls.push(currentRow.value);
            } else if(key == 'partner_beschreibung[]') {
                partnerDescriptions.push(currentRow.value);
            }

            if(key == 'ansprechperson_2_vorname' || key == 'ansprechperson_2_nachname') {
                if(currentRow.value != '') {
                    showAnsprechpartner2 = true;
                }
            }

            if(key == 'ansprechperson_3_vorname' || key == 'ansprechperson_3_nachname') {
                if(currentRow.value != '') {
                    showAnsprechpartner3 = true;
                }
            }

            //Show the preview images
            if(imagePreviews.includes(key)) {
                if(currentRow.value != '') {
                    let previewImage = $('input[name="' + key + '"]').siblings('.preview-image');
                    let path = previewImage.data('path');
                    previewImage.append('<div class="dz-image"><img src="' + path + currentRow.value + '"></div>');
                }
            }
        });

        //Show Ansprechpartner rows, if the fields are populated
        if(showAnsprechpartner2) {
            let rowId = $('#add-contact-person-2 a').data('row-id');
            $('#' + rowId).removeClass('hidden');
            $('#add-contact-person-2 a').hide();
        }

        if(showAnsprechpartner3) {
            let rowId = $('#add-contact-person-3 a').data('row-id');
            $('#' + rowId).removeClass('hidden');
            $('#add-contact-person-3 a').hide();
        }

        let i = 0;
        videos.forEach(function callback(video) {
            if(i > 0) {
                addVideoLink();
            }

            $('#videos .input-container').last().find('input').first().val(video);
            let videoTitle = videoTitles[i];
            $('#videos .input-container').last().find('input').last().val(videoTitle);
            i++;
        });

        i = 0;
        partnerNames.forEach(function callback(partnerName) {
            if(i > 0) {
                addExternalCooperationInput();
            }

            let partnerUrl = partnerUrls[i];
            let partnerDescription = partnerDescriptions[i];
            console.log(partnerDescription);

            $('.external-cooperation-partners .form-row').last().find('input[name="partner_name[]"]').val(partnerName);
            $('.external-cooperation-partners .form-row').last().find('input[name="partner_url[]"]').val(partnerUrl);
            $('.external-cooperation-partners .form-row').last().find('textarea[name="partner_beschreibung[]"]').val(partnerDescription);
            i++;
        });
    };


    let initPreviewButton = function() {
        $('#generate-preview-for-offer').click(function() {
            if(!$(this).hasClass('working')) {
                $(this).addClass('working');
                $('#preview-offer-loader').removeClass('hidden');
                $('#offer-form input[type=submit]').attr('disabled', true);

                $('#offer-form input[name=action]').val('kulturvermittlung_generate_preview_offer');
                let formData = $('#offer-form').serialize();
                $.ajax({
                    url: Project.ajaxUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json'
                }).done(function (result) {
                    $('#preview-offer-loader').addClass('hidden');
                    $('#generate-preview-for-offer').removeClass('working');

                    if(result.success) {
                        let id = result.data.postId;
                        let previewURL = result.data.link;
                        $('#offer-form input[type=submit]').attr('disabled', false);
                        $('#offer-form input[name=offerId]').val(id);
                        $('#offer-form input[name=action]').val('kulturvermittlung_save_offer');
                        window.open(previewURL, '_blank').focus();
                    }
                }).fail(function () {
                });
            }
            return false;
        });
    };
})(window, jQuery, Forms);

jQuery(function(){
    Forms.init();
});
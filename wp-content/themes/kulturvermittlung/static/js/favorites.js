var Favorites = Favorites || {};
(function(window, $, exports, undefined) {
    exports.loggedIn = false;

    exports.init = function() {
        $('.fav-icon').click(function(){
            let id = $(this).data('id');
            let type = $(this).data('type');

            if($(this).hasClass('is-favorite')) {
                removeFromFavorites(id, type);
                $(this).removeClass('is-favorite');
            } else {
                addToFavorites(id, type);
                $(this).addClass('is-favorite');
            }
        });
    };

    exports.checkForFavorite = function() {
        let id =  $('.fav-icon').data('id');
        let type =  $('.fav-icon').data('type');

        if(!Favorites.loggedIn) {
            let storageString = getStorageStringForType(type);
            if(localStorage.getItem(storageString) != null) {
                favorites = JSON.parse(localStorage.getItem(storageString));
                if(favorites.includes(id)) {
                    $('.fav-icon').addClass('is-favorite');
                }
            }
        } else {
            $.ajax({
                url: Project.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'kulturvermittlung_check_for_favorite',
                    data: {
                       id: id,
                       type: type,
                    }
                },
                dataType: 'json'
            }).done(function (result) {
                if(result.success) {
                    if(result.data.isFavorite) {
                        $('.fav-icon').addClass('is-favorite');
                    }
                }
            }).fail(function () {
            });
        }
    };

    let addToFavorites = function(id, type) {
        //The user has no account, so save it to the local storage
        if(!Favorites.loggedIn) {
            let storageString = getStorageStringForType(type);

            let favorites;
            if(localStorage.getItem(storageString) == null) {
                favorites = [];
            } else {
                favorites = JSON.parse(localStorage.getItem(storageString));
            }

            favorites.push(id);
            localStorage.setItem(storageString, JSON.stringify(favorites));
        } else {
            //The user has an account, so save it to his profile
            $.ajax({
                url: Project.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'kulturvermittlung_add_favorite',
                    data: {
                       id: id,
                       type: type,
                    }
                },
                dataType: 'json'
            }).done(function (result) {
                if(result.success) {
                }
            }).fail(function () {
            });
        }
    };

    let removeFromFavorites = function(id, type) {
        //The user has no account, so remove it from the local storage
        if(!Favorites.loggedIn) {
            let storageString = getStorageStringForType(type);
            if(localStorage.getItem(storageString) != null) {
                favorites = JSON.parse(localStorage.getItem(storageString));

                const index = favorites.indexOf(id);
                favorites.splice(index, 1);
                localStorage.setItem(storageString, JSON.stringify(favorites));
            }
        } else {
            $.ajax({
                url: Project.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'kulturvermittlung_remove_favorite',
                    data: {
                       id: id,
                       type: type,
                    }
                },
                dataType: 'json'
            }).done(function (result) {
                if(result.success) {
                }
            }).fail(function () {
            });
        }
    };

    exports.loadFavorites = function() {
        let profileFavorites = [];
        if(localStorage.getItem('ulmutopia_favorites_profiles') != null) {
            profileFavorites = JSON.parse(localStorage.getItem('ulmutopia_favorites_profiles'));
        }

        let offerFavorites = [];
        if(localStorage.getItem('ulmutopia_favorites_offers') != null) {
            offerFavorites = JSON.parse(localStorage.getItem('ulmutopia_favorites_offers'));
        }

        console.log(profileFavorites);

        if(profileFavorites.length > 0 || offerFavorites.length > 0 || Favorites.loggedIn) {
            $.ajax({
                url: Project.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'kulturvermittlung_load_favorites',
                    data: {
                       profileFavorites: profileFavorites,
                       offerFavorites: offerFavorites,
                    }
                },
                dataType: 'json'
            }).done(function (result) {
                if(result.success) {
                    $('#profile-favorites .profiles').html(result.data.profileFavorites);
                    $('#offer-favorites .offers').html(result.data.offerFavorites);
                    $('#send-favorites-form').append(result.data.formFields);

                    if(!result.data.hasFavorites) {
                        $('#send-favorites-form').remove();
                        $('#add-favorites-notice').removeClass('hidden');
                    }
                }
            }).fail(function () {
            });
        } else {}
    };

    let getStorageStringForType = function(type) {
        if(type == 'profile') {
            return 'ulmutopia_favorites_profiles';
        } else {
            return 'ulmutopia_favorites_offers';
        }
    };
})(window, jQuery, Favorites);

jQuery(function(){
    Favorites.init();
});
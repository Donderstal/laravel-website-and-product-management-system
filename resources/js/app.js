require('./bootstrap');

var SVGInjector = require('svg-injector')
window.company = {};
window.company.search = {};


$( document ).ready(function() {
    // Elements to inject
    var mySVGsToInject = document.querySelectorAll('img.svg-injection');

    if (mySVGsToInject) {
        // Do the injection
        SVGInjector(mySVGsToInject);
    }

    window.addEventListener('scroll', () => {
        if ( $(window).scrollTop() > $('.header').height() ) {
            $('.header-sticky').css('visibility', 'visible')
        }
        if ( $(window).scrollTop() < $('.header').height() ) {
            $('.header-sticky').css('visibility', 'hidden')
        }
    })

    // General event listeners
    document.getElementById('header__dropdown-button').addEventListener('click', () => {
        toggleDropdown()
        }
    )

    document.getElementById('header__dropdown-button--sticky').addEventListener('click', () => {
        toggleDropdown()
        }
    )

    document.getElementById('navbar__search-icon--sticky').addEventListener('click', () => {
        toggleSearchbar('sticky')
        }
    )

    document.getElementById('navbar__search-icon').addEventListener('click', () => {
        toggleSearchbar('normal')
        }
    )

    document.getElementsByClassName('navbar__company-logo')[0].addEventListener('click', () => {
        location.href = '/'
        }
    )

    //for homepage
    if ( $('.homepage__uitgelicht-pointer').length > 0 ) {
        document.getElementById('homepage__uitgelicht-pointer').addEventListener('click', () => {
            scrollToElement('homepage__featured')
        })
    }

    // for product page
    if ( $('#product-page__meer-opties').length > 0 ) {

        document.getElementById('product-page__copy-link').addEventListener('click', () => {
            copyUrlToClipboard()
        })

        document.getElementById('product-page__specificaties-bekijken').addEventListener('click', () => {
            scrollToElement('product-page__specificaties')
        })

        document.getElementById('product-page__meer-opties').addEventListener('click', () => {
            showParentElement('opties')
            }
        )

        document.getElementById('product-page__meer-voorzien-van').addEventListener('click', () => {
            showParentElement('voorzien-van')
            }
        )

        document.getElementById('product-gallery__right-button').addEventListener('click', () => {
            getNextPicture('right')
            }
        )

        document.getElementById('product-gallery__left-button').addEventListener('click', () => {
            getNextPicture('left')
            }
        )

        document.getElementById('product-image').addEventListener('click', () => {
            getLargeGallery()
            }
        )

    }
})

function copyUrlToClipboard() {
    const dummy = document.createElement('input');
    const text = window.location.href;

    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand('copy');
    document.body.removeChild(dummy);
}

function scrollToElement(elementId) {
    $('html,body').animate({
        scrollTop: $("#" + elementId).offset().top},
        'slow');
}

// Used for opening up parts of product page
function showParentElement(modifier){
    (modifier === 'opties')
    ? $('.product-page__all-options-wrapper').toggleClass('full-height')
    : $('.product-page__services-wrapper').toggleClass('full-height')
}

// Toggle dropdown nav-menu
function toggleDropdown() {
    $('.header-main-menu').toggle();
    $('.navbar__search-icon').toggle();
    $('.header').toggleClass('dropdown-nav-active')
    $('#header__dropdown-button').toggleClass('dropdown-nav-active-button')
    $('html').toggleClass('no-scroll')
    $('body').toggleClass('no-scroll')
    $('.search-bar').toggleClass('navbar__company-logo__do-not-display')
    $('.header-sticky').css('visibility', 'hidden')

    if ( $('.homepage__uitgelicht-pointer').length > 0 ) {
        $('.logo-white')
            .toggleClass('navbar__company-logo__do-not-display')
            .toggleClass('navbar__company-logo')
        $('.logo-black')
            .toggleClass('navbar__company-logo__do-not-display')
            .toggleClass('navbar__company-logo')
    }
}

// Toggle menu search bar
function toggleSearchbar() {
    if ('normal') {
        $('.navbar__searchbar').toggle()
        $('#navbar__searchbar-input').focus();        
    }
    else if ('sticky') {
        $('.navbar__searchbar--sticky').toggle()
        $('#navbar__searchbar-input--sticky').focus();       
    }
}


// Search Module
window.company.search.handleSearchRequest = function () {
    searchURL = window.location.origin + '/autos';
    if (window.companySearchState) {
        searchURL = window.company.search.handelcompanySearchState(searchURL, window.companySearchState);
    } else {
        // default
        searchURL += '/' + 'aanbod';
    }

    location.href = searchURL;

}

window.company.search.handelcompanySearchState = function(searchURL, companySearchState) {
    if (companySearchState.pathParams.carState) {
        searchURL += '/' + companySearchState.pathParams.carState;
    } else {
        searchURL += '/' + 'aanbod';
    }

    if (companySearchState.pathParams.brand) {
        searchURL += '/' + companySearchState.pathParams.brand;
    }

    if (!jQuery.isEmptyObject(companySearchState.queryParams)) {
        serializedParams = $.param(companySearchState.queryParams);
        searchURL += '?' + serializedParams;
    }
    return searchURL;
}


window.company.search.actionUpdateBrand = function(brand) {
    companySearchState.pathParams.brand = brand;
}

window.company.search.actionUpdateSort = function(sortKey) {
    if (!sortKey) {
        delete companySearchState.queryParams.order;
    } else {
        companySearchState.queryParams.order = sortKey;
    }
}

window.company.search.actionUpdateQuery = function(query) {
    if (!query) {
        delete companySearchState.queryParams.q;
    } else {
        companySearchState.queryParams.q = query;
    }
}

// Functions for scrolling through gallery
function getNextPicture(direction) {

    const currentPictureObject = gallery.find(isCurrentPicture)
    const currentPictureObjectIndex = gallery.indexOf(currentPictureObject)
    const nextPictureObjectIndex = getNextPictureObjectIndex(direction, currentPictureObjectIndex)
    displayNextPicture(nextPictureObjectIndex, currentPictureObject)
}

function isCurrentPicture(element) {
    const currentImageFileName = $('#product-image').attr('src').split('/')[5]
    return currentImageFileName == element.picture
}

function getNextPictureObjectIndex(direction, currentPictureObjectIndex) {
    let nextPictureObjectIndex = ( direction == 'left' )
        ? (currentPictureObjectIndex - 1)
        : (currentPictureObjectIndex + 1)

    if (nextPictureObjectIndex > (gallery.length - 1) ) {
        nextPictureObjectIndex = 0
    }

    if (nextPictureObjectIndex < 0) {
        nextPictureObjectIndex = (gallery.length - 1)
    }

    document.getElementById('product-gallery__counter').innerText = ( nextPictureObjectIndex + 1 )

    return nextPictureObjectIndex
}

function displayNextPicture(nextPictureObjectIndex, currentPictureObject) {
    const nextPictureFileName = gallery[nextPictureObjectIndex].picture
    const nextPicturePath = $('#product-image')
        .attr('src')
        .replace(currentPictureObject.picture, nextPictureFileName);

    $('#product-image').attr('src', nextPicturePath)
}

// Functions for opening Large gallery
/// Open large gallery 'controller'
function getLargeGallery () {
    var viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    if ( viewportWidth > 1024 ) {
        $('.product-page__header-img-wrapper').css('position', 'relative')
        $('.product-gallery__counter').css('color', 'white')
    }

    if ($('#return-button').length !== 1) {
        createLargeGalleryBackground ()
        toggleLargeGallery()
        toggleLargeGalleryButtonDiv()
        createLargeGalleryReturnButton()

        $('body').toggleClass('large-gallery__body-styles')
        $('html,body').scrollTop(0);
        $('.header-general').css('display', 'none');
    }
}

/// close large gallery 'controller'
function removeLargeGallery() {
    var viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    if ( viewportWidth > 1024 ) {
        $('.product-page__header-img-wrapper').css('position', 'absolute')
        $('.product-gallery__counter').css('color', '#022835')
    }

    toggleLargeGallery()
    toggleLargeGalleryButtonDiv()
    $('body').toggleClass('large-gallery__body-styles')
    $('.header-general').css('display', 'block');
    $('.large-gallery__background-div').remove()
    $('.large-gallery__return-button').remove()
}

// Helper functions
function createLargeGalleryBackground () {
    $('<div/>', {
        class: 'large-gallery__background-div'
    }).appendTo('body');
}

function toggleLargeGallery() {
    $('.product-page__image-header')
        .toggleClass('cell')
        .toggleClass('small-12')
        .toggleClass('large-5')
        .toggleClass('large-gallery__gallery-div')
}

function createLargeGalleryReturnButton () {
    $('<button/>', {
        text: 'TERUG',
        id: 'return-button',
        class: 'large-gallery__return-button'
    }).appendTo('body');

    $('#return-button').click(removeLargeGallery)
}

function toggleLargeGalleryButtonDiv() {
    $('.product-page__image-header__button-wrapper')
        .toggleClass('large-gallery__button-div')
}

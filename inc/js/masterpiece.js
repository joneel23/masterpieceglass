// jQuery(document).ready(function(){
//  alert('this is testing');
// });

jQuery(document).ready(function ($) {
   // $('.grid').isotope(
    //     {
    //         percentPosition: true,
    //         masonry: {
    //             columnWidth: '.grid-sizer'
    //         }
    //     }
    // );

    $('.iso-gallery-image').map(function(){
        var img = $(this).data('thumbnail');
        var img_height = $(this).data('height');
        //$(this).css('height', img_height);
        //$(this).css('background-image', 'url('+img+')');
    });

   // init Isotope
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        percentPosition: true,
        masonry: {
            columnWidth: '.grid-sizer'
        }
    });
// layout Isotope after each image loads
    $grid.imagesLoaded().progress( function() {
        $grid.isotope('layout');
    });

    // store filter for each group
    var filters = {};

    $('.filters').on( 'click', '.button', function( event ) {
        var $button = $( event.currentTarget );
        // get group key
        var $buttonGroup = $button.parents('.button-group');
        var filterGroup = $buttonGroup.attr('data-filter-group');
        // set filter for group
        filters[ filterGroup ] = $button.attr('data-filter');
        // combine filters
        var filterValue = concatValues( filters );
        // set filter for Isotope
        $grid.isotope({ filter: filterValue });
    });

// change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button', function( event ) {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            var $button = $( event.currentTarget );
            $button.addClass('is-checked');
        });
    });

    //add alt attribute for filtering
    $('.grid-item img').map(function(){
        var alt = $(this).attr('alt');
        $(this).parent().addClass(alt);
    });

// flatten object by concatting values
    function concatValues( obj ) {
        var value = '';
        for ( var prop in obj ) {
            value += obj[ prop ];
        }
        return value;
    }
});
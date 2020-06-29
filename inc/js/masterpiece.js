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
        console.log(filters);
        var filterValue = concatValues( filters );
        console.log(filterValue);
        // set filter for Isotope
        $grid.isotope({ filter: filterValue });
    });

// change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button, li', function( event ) {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            var $button = $( event.currentTarget );
            $button.addClass('is-checked');
        });
    });

    //add alt attribute for filtering
    $('.grid-item').map(function(){
        var ele_content = $(this).find('.elementor-gallery-item__title').length;
        console.log(ele_content);
        if( ele_content.toString() != "0" ){
            $(this).addClass('item-content-bg');
        }
        var alt = $(this).find('img').attr('alt');
        $(this).find('img').parents('.grid-item').addClass(alt);
    });


    $('.elementor-sub-title > span').on('click', function(event){

        $( event.currentTarget ).parent().removeClass('is-checked');
        var reset_sub_filter = {};
        var main_filter = $('#main-filter-group').find('.is-checked').attr('data-filter');
        //console.log(main_filter);
        reset_sub_filter['title'] = main_filter;
        var resetfilterValue = concatValues( reset_sub_filter );
        //console.log(resetfilterValue);
        $grid.isotope({ filter: resetfilterValue });
        event.preventDefault();
        event.stopPropagation();
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
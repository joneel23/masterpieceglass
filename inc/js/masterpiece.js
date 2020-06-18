// jQuery(document).ready(function(){
//  alert('this is testing');
// });

jQuery(document).ready(function ($) {
   $('.grid').isotope(
       {
           percentPosition: true,
           masonry: {
               columnWidth: '.grid-sizer'
           }
       }
   );
});
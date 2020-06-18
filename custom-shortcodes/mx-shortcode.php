<?php
/**
 * Created by PhpStorm.
 * User: WEB
 * Date: 6/5/2020
 * Time: 12:12 PM
 */

//=============================
// Accordion
//=============================
function custom_mx_accordion_func($atts, $content = null){
    global $mx_accordion_id, $mx_accordion_items,$mx_accordion_item_id,$mx_accordion_item_effect;
    // setting accordion id
    if(isset($mx_accordion_id)){
        $mx_accordion_id++;
    }else{
        $mx_accordion_id = 1;
    }
    $mx_accordion_item_id = 1;
    extract( shortcode_atts( array(
        'effect' => '',
        'class' => '',
    ), $atts ) );

    $mx_accordion_items = array();
    $mx_accordion_item_effect = $effect;
    if($effect != "" && $effect != "none"){
        $output = '<div class="mx-accordion mx-accordion-main animate-list '. esc_attr($class) .'" data-effect="'.esc_attr($effect).'" id="accordion-'.esc_attr($mx_accordion_id).'">';
    }else{
        $output = '<div class="mx-accordion mx-accordion-main '. esc_attr($class) .'" id="accordion-'.esc_attr($mx_accordion_id).'">';
    }
    do_shortcode($content);
    foreach($mx_accordion_items as $mx_accordion_item){
        $output .= $mx_accordion_item;
    }
    $output .= '</div>';
    return $output;
}
add_shortcode('mp_accordion', 'custom_mx_accordion_func');

function custom_mx_accordion_item_func($atts, $content = null){
    global $mx_accordion_items,$mx_accordion_id,$mx_accordion_item_id,$mx_accordion_item_effect;

    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $mobile = false;
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
        $mobile = true;
    }


    extract( shortcode_atts( array(
        'title' => '',
        'open' => '',
        'bg_color' => '',
        'image_id' => '',
        'collapse_mobile' => '',
    ), $atts ) );

    if($mx_accordion_item_effect != ""){
        $output = '<div class="panel accordion-panel animate-item" data-effect="'.esc_attr($mx_accordion_item_effect).'">';
    }else{
        $output = '<div class="panel accordion-panel">';
    }

    if(!empty($image_id)){
        $img = wp_get_attachment_image( $image_id, 'full', array( "class" => "img-responsive" ) );
    }

    if( $mobile && !empty ($collapse_mobile) ){
        $collapse = 'collapsed';
        $open = '';
        $in = '';
    } else {
        $in = 'in';
        $collapse = '';
    }

    $mx_accordion_items[] = $output.'<div class="accordion-heading"><h4 class="accordion-title"><a class="accordion-toggle '.($open == "true" || $open == "yes" ? '' : 'collapsed').'" data-toggle="collapse" data-parent="#accordion-'.esc_attr($mx_accordion_id).'" href="#accordion-'.esc_attr($mx_accordion_id).'-item-'.esc_attr($mx_accordion_item_id).'">'.$img.'<span class="accordion-icon" style="'.($bg_color != '' ? 'background-color:'.esc_attr($bg_color).';' : '').'"><i class="fa fa-caret-up"></i><i class="fa fa-caret-down"></i></span><span class="accordion-h-title">'.esc_html($title).'</span></a></h4></div><div id="accordion-'.esc_attr($mx_accordion_id).'-item-'.esc_attr($mx_accordion_item_id).'" class="accordion-collapse collapse '.($open == "true" || $open == "yes" ? $in : "").'"><div class="accordion-body">'.do_shortcode($content).'</div></div></div>';
    $mx_accordion_item_id++;
    return "";
}
add_shortcode('mp_accordion_item', 'custom_mx_accordion_item_func');
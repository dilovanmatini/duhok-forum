<?php

namespace HTML;

class Elements{
    public static $mainDarkColor = '#333';
    public static function iconLoader( String $icon_name, String $selector = '', Array $params = [] ) : String {

        $no_children = [
            'rotating-plane'
        ];

        $defaults = [
            'color' => self::$mainDarkColor,
            'inverse_color' => '#fff',
            'zoom' => 100
        ];

        $params['inverse'] ??= false;
        $params['color'] ??= $defaults['color'];
        $params['inverse_color'] ??= $defaults['inverse_color'];
        $params['zoom'] ??= $defaults['zoom'];
        $params['classes'] ??= [];
        $params['attrs'] ??= [];
        $params['style'] ??= [];

        $selector_text = ( $selector == '' ) ? '' : " {$selector}";

        $style_text = [];
        if( $params['zoom'] != $defaults['zoom'] ){
            $style_text[] = "zoom: {$params['zoom']}%;";   
        }

        $color = $params['color'];
        if( $params['inverse'] === true ){
            $color = ( $params['inverse_color'] != $defaults['inverse_color'] ) ? $params['inverse_color'] : $defaults['inverse_color'];
        }

        if( in_array( $icon_name, $no_children ) ){
            $style_text[] = "background-color:{$color};";
        }

        $style_text = count($style_text) > 0 ? ' style="'.implode( "", $style_text ).'"' : '';
        $classes_text = count($params['classes']) > 0 ? ' '.implode( ' ', $params['classes'] ) : '';

        array_walk($params['attrs'], function( &$value, $key ){
            $value = " {$key}=\"{$value}\"";
        });
        $attrs_text = count($params['attrs']) > 0 ? implode( '', $params['attrs'] ) : '';

        $html = "";
        
        if( $icon_name == 'rotating-plane' ){
            $html = "
            <div class=\"css-loader rotating-plane{$selector_text}{$classes_text}\"{$attrs_text}{$style_text}></div>";
        }
        elseif( $icon_name == 'double-bounce' ){
            $html = "
            <div class=\"css-loader double-bounce{$selector_text}{$classes_text}\"{$attrs_text}{$style_text}>
                <div class=\"double-bounce1\" style=\"background-color:{$color};\"></div>
                <div class=\"double-bounce2\" style=\"background-color:{$color};\"></div>
            </div>";
        }
        elseif( $icon_name == 'wave' ){
            $html = "
            <div class=\"css-loader wave{$selector_text}{$classes_text}\"{$attrs_text}{$style_text}>
                <div class=\"rect1\" style=\"background-color:{$color};\"></div>
                <div class=\"rect2\" style=\"background-color:{$color};\"></div>
                <div class=\"rect3\" style=\"background-color:{$color};\"></div>
                <div class=\"rect4\" style=\"background-color:{$color};\"></div>
                <div class=\"rect5\" style=\"background-color:{$color};\"></div>
            </div>";
        }
        elseif( $icon_name == 'chasing-dots' ){
            $html = "
            <div class=\"css-loader chasing-dots{$selector_text}{$classes_text}\"{$attrs_text}{$style_text}>
                <div class=\"dot1\" style=\"background-color:{$color};\"></div>
                <div class=\"dot2\" style=\"background-color:{$color};\"></div>
            </div>";
        }
        elseif( $icon_name == 'circle' ){
            $html = "
            <style type=\"text/css\">.css-loader.circle .circle0:before{background-color:{$color};}</style>
            <div class=\"css-loader circle{$selector_text}{$classes_text}\"{$attrs_text}{$style_text}>
                <div class=\"circle1 circle0\"></div>
                <div class=\"circle2 circle0\"></div>
                <div class=\"circle3 circle0\"></div>
                <div class=\"circle4 circle0\"></div>
                <div class=\"circle5 circle0\"></div>
                <div class=\"circle6 circle0\"></div>
                <div class=\"circle7 circle0\"></div>
                <div class=\"circle8 circle0\"></div>
                <div class=\"circle9 circle0\"></div>
                <div class=\"circle10 circle0\"></div>
                <div class=\"circle11 circle0\"></div>
                <div class=\"circle12 circle0\"></div>
            </div>";
        }
        elseif( $icon_name == 'three-bounce' ){
            $html = "
            <div class=\"css-loader three-bounce{$selector_text}{$classes_text}\"{$attrs_text}{$style_text}>
                <div class=\"bounce1\" style=\"background-color:{$color};\"></div>
                <div class=\"bounce2\" style=\"background-color:{$color};\"></div>
                <div class=\"bounce3\" style=\"background-color:{$color};\"></div>
            </div>";
        }
        return $html;
    }
    public static function photoResizableForm( $name, $target_id, $filename = '', &$target_id_selector = '', $_prs_prefix = 'prs_' ) : void {
        global $dm_photos, $photo_resizable_system_vars;
        
        if( empty($name) || !in_array( $name, array_keys($photo_resizable_system_vars) ) ){
            return;
        }
        
        $target_id = intval($target_id);
        $target_id_selector = "{$_prs_prefix}target_id";
        $vars = $photo_resizable_system_vars["{$name}"];
    
        if( isset($vars['default_photo']) ){
            $defualt_photo_src = $vars['default_photo'];
        }
        else{
            $defualt_photo_src = 'themes/default/layout/photos/male-not-available.gif';
        }
    
        if( !empty($filename) ){
            $filename = $dm_photos->resize( $filename, $vars['getsize'] );
            $src = $dm_photos->getsrc( $filename );
        }
        else{
            $src = $defualt_photo_src;
        }
    
        ?>
        <script type="text/javascript">
        var
        _prs_prefix = '<?=$_prs_prefix?>',
        _aspect_ratio = <?=$vars['aspect_ratio']?>,
        _auto_crop_area = <?=$vars['auto_crop_area']?>,
        _defualt_photo_src = '<?=$defualt_photo_src?>',
        _target_type = '<?=$name?>';
        _allow_upload = <?=( allow("{$vars['allow_upload']}") ? 'true' : 'false' )?>,
        _allow_remove = <?=( allow("{$vars['allow_remove']}") ? 'true' : 'false' )?>;
        </script>
        <link rel="stylesheet" href="js/cropper/cropper.min.css<?=__xcode?>">
        <script type="text/javascript" src="js/cropper/cropper.min.js<?=__xcode?>"></script>
        <script type="text/javascript" src="js/lib/photo.resizable.panel.js<?=__xcode?>"></script>
        <?php
        echo"
        <style type=\"text/css\">
        .{$_prs_prefix}panel{
            margin: 10px 0;
            background-color: #f3f3f3;
        }
        .{$_prs_prefix}panel > div{
            padding: 5px;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}main{
            text-align: left;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}picture{
            display: inline-block;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}picture > img{
            width: {$vars['width']}px;
            height: {$vars['height']}px;
            border: 1px solid #aaa;
            vertical-align: middle;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}tools{
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
               -moz-user-select: none;
                -ms-user-select: none;
                 -o-user-select: none;
                    user-select: none;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}tools i{
            width: 60px;
            height: 60px;
            padding: 10px;
            margin-left: 50px;
            font-size: 48px;
            line-height: 62px;
            background-color: rgba(0, 0, 0, 0.1);
            cursor: pointer;
            -webkit-border-radius: 100%;
            -moz-border-radius: 100%;
            border-radius: 100%;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}tools i:hover{
            background-color: rgba(0, 0, 0, 0.2);
        }
        .{$_prs_prefix}panel .{$_prs_prefix}preview{
            display: none;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}preview > img{
            max-width: 800px;
            max-height: 600px;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}footer{
            display: none;
            -webkit-user-select: none;
               -moz-user-select: none;
                -ms-user-select: none;
                 -o-user-select: none;
                    user-select: none;
        }
        .{$_prs_prefix}panel .{$_prs_prefix}footer > div > i{
            width: 28px;
            height: 28px;
            margin: 2px 1px 6px;
            font-size: 20px;
            line-height: 30px;
            background-color: rgba(0, 0, 0, 0.1);
            cursor: pointer;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }
        </style>";
        
        echo"
        <div class=\"{$_prs_prefix}panel\">
            <input type=\"hidden\" class=\"{$target_id_selector}\" value=\"{$target_id}\">
            <div class=\"{$_prs_prefix}main\">
                <div class=\"{$_prs_prefix}picture\"><img src=\"{$src}\" filename=\"{$filename}\" onerror=\"this.src='{$defualt_photo_src}';\"></div>
                <div class=\"{$_prs_prefix}tools\">";
                if( allow("{$vars['allow_remove']}") ){
                    echo"
                    <i class=\"icon-trash-o {$_prs_prefix}remove\" poptip=\"Remove Picture\"></i>";
                }
                if( allow("{$vars['allow_upload']}") ){
                    echo"
                    <i class=\"icon-plus {$_prs_prefix}new\" poptip=\"Upload New Picture\"></i>";
                }
                    
                echo"
                </div>
            </div>
            <div class=\"{$_prs_prefix}preview\">
                <img src=\"\" onerror=\"this.src='{$defualt_photo_src}';\">
            </div>
            <div class=\"{$_prs_prefix}footer dm-center\">
                <div>
                    <i class=\"icon-rotate-right {$_prs_prefix}rotate_right\" poptip=\"Rotate to right\"></i>
                    <i class=\"icon-rotate-left {$_prs_prefix}rotate_left\" poptip=\"Rotate to left\"></i>
                    <i class=\"icon-arrows-h {$_prs_prefix}scale_hor\" poptip=\"Horizontal transform\"></i>
                    <i class=\"icon-arrows-v {$_prs_prefix}scale_ver\" poptip=\"Vertical transform\"></i>
                    <i class=\"icon-search-plus {$_prs_prefix}zoom_in\" poptip=\"Zoom in\"></i>
                    <i class=\"icon-search-minus {$_prs_prefix}zoom_out\" poptip=\"Zoom out\"></i>
                </div>
                <a class=\"btn btn-cblue {$_prs_prefix}upload_btn\" href=\"#\"><i class=\"icon-upload\"></i> Upload</a>
            </div>
        </div>
        <div class=\"dis-none\">
            <form class=\"{$_prs_prefix}form\" method=\"post\" action=\"ajax.php?type=photo_resizable_system_upload\" accept=\"image/*\" enctype=\"multipart/form-data\"></form>
        </div>";
    }
};
<?php
/*
Plugin Name: Optimize Youtube Video
Text Domain: optimize-youtube-video
Description: Optimize youtube videos considering webp thumbnails and flexible output, compatible to any lazyloading plugins.
Version: 1.2.0
Author: Jundell Agbo
Author URI: https://profiles.wordpress.org/jundellagbo/
License: GPLv2 or later
*/

// include vendor libraries :)
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// // boot carbon fields
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'after_setup_theme', 'optimize_youtube_video_content_crb_load' );
function optimize_youtube_video_content_crb_load() {
    \Carbon_Fields\Carbon_Fields::boot();
}

// settings in admin allows you to enter your replace content
add_action( 'carbon_fields_register_fields', 'optimize_youtube_video_carbon_fields_settings' );
function optimize_youtube_video_carbon_fields_settings() {
    Container::make( 'theme_options', 'Optimize Youtube Video' )
    ->set_page_parent( 'options-general.php' )
    ->add_fields( array(

        Field::make( 'html', 'optimize_youtube_video_implementation_mustavoid')
        ->set_html( '
            <h1>Quick Tips</h1>
            <p>Do not add a new line for the attributes, make them one line like the usage below. Some themes or builders automatically generate a comment/shortcode for the new line, we can\'t capture your attirubte if you do that.</p>
            <p>For WP Rocket - disable "Replace Youtube videos by thumbnail" in Lazyload Tab</p>
            <p>Do not lazyload "Above the fold Content" videos for Large contentful paint to increase your page speed performance.</p>

            <h1>Usage</h1>
            <br>
            <code>
                &lt;iframe 
                    src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                    width="560"
                    height="315"
                    nopwebp="1"
                    thumbreso="sddefault"
                    thumbresomobile="mqdefault"
                    data-no-lazy
                    loading="eager"
                    data-skip-lazy
                    skip-lazy
                    ytargs="?autoplay=1&conrols=0"
                    title="Youtube Title Video"
                &gt; <br>
                
                &lt;/iframe&gt;
            </code>

            <br>

            <p><a href="#attributes">click here</a> for the attribute descriptions.</p>
            <br>

            <h1>Lazyload</h1>
            <p>Speed up images by adding <a href="https://wordpress.org/plugins/search/lazyload/" target="_blank">lazyloading plugin</a>.</p>
            <p>If you have caching plugin with lazyload feature you must follow their <a href="#lazyimgmarkup">image markup</a>.</p>
            <h3>Lazy Images Custom Binding Samples</h3>
            <p><strong>WP Rocket or Rocket Lazyload</strong>: <code>data-lazy-src="[syv_image_src]" src="data:image/svg+xml,%3Csvg%20xmlns=\'http://www.w3.org/2000/svg\'%20viewBox=\'0%200%200%200\'%3E%3C/svg%3E"</p></code>
            <p><strong>W3 Total Cache, WP Smush or any lazyloading plugins</strong>: <code>src="[syv_image_src]" loading="lazy"</p></code>
            <p>
                <a href="#imagevariables">Click here</a> for image variables.
            </p>
            <br>
        '),

        Field::make( 'checkbox', 'optimize_youtube_video_usewebpthumbnail', 'Use webp for youtube thumbnails' )
        ->set_default_value( true ),

        Field::make( 'checkbox', 'optimize_youtube_video_isuserloggedin', 'Enable lazy image binding for loggedin users' )
        ->set_default_value( true ),

        Field::make( 'text', 'optimize_youtube_video_playicon', 'Play Icon URL' )
        ->set_help_text( 'Using webp icon by default.' ),


        Field::make( 'html', 'optimize_youtube_video_playicon_html_text')
        ->set_html( '
        <strong>Available assets:</strong>
        <p><a href="'.plugin_dir_url( __FILE__ ).'assets/youtube.png" target="_blank">'.plugin_dir_url( __FILE__ ).'assets/youtube.png</a></p>
        <p><a href="'.plugin_dir_url( __FILE__ ).'assets/youtube.webp" target="_blank">'.plugin_dir_url( __FILE__ ).'assets/youtube.webp</a></p>
        ' ),

        Field::make( 'color', 'optimize_youtube_video_background', 'Video Wrap Background Color' )
        ->set_alpha_enabled( true )
        ->set_default_value( '#000000' ),

        Field::make( 'select', 'optimize_youtube_video_media_thumbnail_size', 'Media Thumbnail Size (Desktop)' )
        ->add_options( array(
            'sddefault' => 'Standard',
            'default' => 'Default',
            'mqdefault' => 'Medium',
            'hqdefault' => 'High',
            'maxresdefault' => 'Max Res'
        ) )
        ->set_default_value( 'sddefault' )
        ->set_help_text( 'You can change this to your iframe attribute.' ),
        
        Field::make( 'select', 'optimize_youtube_video_media_thumbnail_size_mobile', 'Media Thumbnail Size (Mobile)' )
        ->add_options( array(
            'sddefault' => 'Standard',
            'default' => 'Default',
            'mqdefault' => 'Medium',
            'hqdefault' => 'High',
            'maxresdefault' => 'Max Res'
        ) )
        ->set_default_value( 'mqdefault' )
        ->set_help_text( 'You can change this to your iframe attribute.' ),



        Field::make( 'html', 'optimize_youtube_video_media_thumbnail_size_html')
        ->set_html( '
        <p id="resodetails">* Standard -> sddefault 640x480</p>
        <p>* Default -> default 120x90</p>
        <p>* Medium -> mqdefault 320x180</p>
        <p>* High -> hqdefault 480x360</p>
        <p>* Max Res -> maxresdefault 1280x720</p>
        ' ),
        Field::make( 'textarea', 'optimize_youtube_video_iframeattributes', 'Youtube iFrame attributes' )
        ->set_default_value( 'frameborder=\'0\' allowfullscreen=\'1\' allow=\'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\'' )
        ->set_help_text( 'To be added to your generated iframe tag. USE SINGLE QUOTE FOR THE ATTRIBUTE VALUES LIKE WHAT YOU SEE IN THE DEFAULT' ),
        
        Field::make( 'html', 'optimize_youtube_video_imglazymarkup_id')
        ->set_html( '
            <div id="lazyimgmarkup"></div>
        '),

        Field::make( 'textarea', 'optimize_youtube_video_lazyimg_custom_binding', 'Lazy Images Custom Binding' )
        ->set_default_value( 'src="[syv_image_src]" loading="lazy"' ),
        Field::make( 'html', 'optimize_youtube_video_img_varlink_1')
        ->set_html( '
        <p>
            Custom Binding for Lazy Images to support any loazyload plugin <a href="#imagevariables">Click here</a> for image variables. Working with SRCSETS? <a href="#workingsrcset">Try this snippet!</a>
        </p>
        ' ),

        
        Field::make( 'textarea', 'optimize_youtube_video_nonlazyimg_custom_binding', 'Non-Lazy Images Custom Binding' )
        ->set_default_value( 'src="[syv_image_src]" loading="eager"' ),
        Field::make( 'html', 'optimize_youtube_video_img_varlink_2')
        ->set_html( '
        <p>
            Custom Binding for Non-Lazy Images <a href="#imagevariables">Click here</a> for image variables.
        </p>

        ' ),

        Field::make( 'text', 'optimize_youtube_video_button_arialabel', 'Youtube play button aria-label' )
        ->set_default_value( 'play Youtube video' ),

        Field::make( 'html', 'optimize_youtube_video_img_placeholder_html')
        ->set_html( '
        <h3 id="imagevariables">Image variables</h3>
        <p><code>[syv_image_src]</code> -> Current Image</p>
        <p><code>[syv_image_src_default]</code> -> Thumbnail 120x90</p>
        <p><code>[syv_image_src_sddefault]</code> -> Thumbnail 640x480</p>
        <p><code>[syv_image_src_mqdefault]</code> -> Thumbnail 320x180</p>
        <p><code>[syv_image_src_hqdefault]</code> -> Thumbnail 480x360</p>
        <p><code>[syv_image_src_maxresdefault]</code> -> Thumbnail 1280x720</p>
        ' ),


        Field::make( 'html', 'optimize_youtube_video_implementation_and_markup')
        ->set_html( '
        <h3 id="attributes">Attribute Details</h3>
        <p><strong>nopwebp</strong> - (optional) | Back to jpg format thumbnail (Not Recommended, use webp for next-gen format images by removing this attribute, removed by default)</p>
        <p><strong>ytargs</strong> - (optional) | query parameters for the video source, if you don\'t want auto play after click leave it empty, removed by default</p>
        <p><strong>thumbreso</strong> - (optional) (default: <strong>sddefault</strong>) | Resolution of the thumbnail for Desktop</p>
        <p><strong>thumbresomobile</strong> - (optional) (default: <strong>mqdefault</strong>) | Resolution of the thumbnail for Mobile</p>
        <p><a href="#resodetails">Click here</a> for resolution details.</p>
        <strong>Disabling Lazyload by adding any of these attributes</strong>
        <p><code>data-no-lazy</code> <code>loading="eager"</code> <code>data-skip-lazy</code> <code>skip-lazy</code></p>


        <br></br>
        <h1 id="workingsrcset">Working with SRCSET? Try this snippet to your Lazy Images Custom Binding</h1><br>
        <code>
            srcset="[syv_image_src_default] 120w,<br>
            [syv_image_src_mqdefault] 320w,<br>
            [syv_image_src_hqdefault] 480w,<br>         
            [syv_image_src_sddefault] 640w,<br>
            [syv_image_src_maxresdefault] 1280w"
            <br><br>

            sizes="(max-width: 320px) 120px, <br>
            (max-width: 480px) 320px, <br>
            (max-width: 640px) 480px, <br>
            1280px"
        </code>


        <br><br>
        <h1>Not using iFrame? We have a html markup for you.</h1>
        <code>
            &lt;div class="youtube-video-ts"&gt; <br>
                &lt;div data-img-webpfield data-yt-src="https://www.youtube.com/embed/dQw4w9WgXcQ" width="560" height="315" style="width: 560px; height: 315px;"&gt; <br>
                    &lt;img src="https://i.ytimg.com/vi_webp/dQw4w9WgXcQ/hqdefault.webp" width="480" height="360" alt="Youtube title here" /&gt; <br>
                    &lt;button class="play" aria-label="play Youtube video"&gt; &lt;/button&gt; <br>
                &lt;/div&gt; <br>
            &lt;/div&gt;
        </code>
        ' ),
    ));
}


function optimize_youtube_video_sanitize_output($buffer) {
    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );
    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}


add_action('wp_footer', 'optimize_youtube_video_bind_javascript', 100); 
function optimize_youtube_video_bind_javascript() { 
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . 'frontend/script.php';
    $html = ob_get_clean();
    echo optimize_youtube_video_sanitize_output($html);
}


add_action('wp_head', 'optimize_youtube_video_bind_css'); 
function optimize_youtube_video_bind_css() { 
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . 'frontend/style.php';
    $html = ob_get_clean();
    echo optimize_youtube_video_sanitize_output($html);
}



function optimize_youtube_video_getYoutubeIDFromURL( $url ) {
    $pattern = '#^(?:https?:)?(?://)?(?:www\.)?(?:youtu\.be|youtube\.com|youtube-nocookie\.com)/(?:embed/|v/|watch/?\?v=)?([\w-]{11})#iU';
    $result  = preg_match( $pattern, $url, $matches );

    if ( ! $result ) {
        return false;
    }

    // exclude playlist.
    if ( 'videoseries' === $matches[1] ) {
        return false;
    }

    return $matches[1];
}


function optimize_youtube_video_cleanYoutubeURL( $url ) {
    $pattern = '#^(?:https?:)?(?://)?(?:www\.)?(?:youtu\.be)/(?:embed/|v/|watch/?\?v=)?([\w-]{11})#iU';
    $result  = preg_match( $pattern, $url, $matches );

    if ( ! $result ) {
        return $url;
    }

    return 'https://www.youtube.com/embed/' . $matches[1];
}

function optimize_youtube_video_allowed_resolutions() {

    return [
        'default'       => [
            'width'  => 120,
            'height' => 90,
        ],
        'mqdefault'     => [
            'width'  => 320,
            'height' => 180,
        ],
        'hqdefault'     => [
            'width'  => 480,
            'height' => 360,
        ],
        'sddefault'     => [
            'width'  => 640,
            'height' => 480,
        ],

        'maxresdefault' => [
            'width'  => 1280,
            'height' => 720,
        ],
    ];
}


add_action('the_content', 'optimize_youtube_video_override_youtubeiframes'); 
function optimize_youtube_video_override_youtubeiframes( $content ) {

    if ( ! preg_match_all( '@<iframe(?<atts>\s.+)>.*</iframe>@iUs', $content, $iframes, PREG_SET_ORDER ) ) {
        return $content;
    }

    // allowed thumbnail resolutions
    $allowed_resolutions = optimize_youtube_video_allowed_resolutions();

    foreach( $iframes as $iframe ) {
        // Given the previous regex pattern, $iframe['atts'] starts with a whitespace character.
        if ( ! preg_match( '@\ssrc\s*=\s*(\'|")(?<src>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            continue;
        }

        $iframe['src'] = trim( $atts['src'] );

        // accept youtube src only
        // https://youtu.be/ID
        // https://www.youtube.com/embed/ID
        if ( '' === $iframe['src'] || !strpos( $iframe['src'], 'youtu' ) ) {
            continue;
        }

        // using default youtube embed dimension
        $iframe['width'] = 560;

        $iframe['height'] = 315;

        $iframe['nowebp'] = carbon_get_theme_option('optimize_youtube_video_usewebpthumbnail') ? false : true;

        $carbonfield_thumb_reso_default = carbon_get_theme_option('optimize_youtube_video_media_thumbnail_size');

        $carbonfield_thumb_reso_mobiledefault = carbon_get_theme_option('optimize_youtube_video_media_thumbnail_size');

        $iframe['thumbreso'] = !isset($carbonfield_thumb_reso_default) || empty($carbonfield_thumb_reso_default) ? 'sddefault' : $carbonfield_thumb_reso_default;

        $iframe['thumbresomobile'] = !isset($carbonfield_thumb_reso_mobiledefault) || empty($carbonfield_thumb_reso_mobiledefault) ? 'sddefault' : $carbonfield_thumb_reso_mobiledefault;

        $iframe['lazyload'] = true;

        $iframe['youtube'] = optimize_youtube_video_cleanYoutubeURL($iframe['src']);

        $iframe['youtube_id'] = optimize_youtube_video_getYoutubeIDFromURL($iframe['src']);

        $iframe['ytargs'] = null;

        $iframe['title'] = 'Youtube title here';

        if ( preg_match( '@\swidth\s*=\s*(\'|")(?<width>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['width'] = $atts['width'];
        }

        if ( preg_match( '@\sheight\s*=\s*(\'|")(?<height>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['height'] = $atts['height'];
        }

        if ( preg_match( '@\snowebp\s*=\s*(\'|")(?<nowebp>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['nowebp'] = true;
        }

        if ( preg_match( '@\sthumbreso\s*=\s*(\'|")(?<thumbreso>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['thumbreso'] = isset( $allowed_resolutions[$atts['thumbreso']] ) ? $atts['thumbreso'] : 'sddefault';
        }

        if ( preg_match( '@\sthumbresomobile\s*=\s*(\'|")(?<thumbresomobile>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['thumbresomobile'] = isset( $allowed_resolutions[$atts['thumbresomobile']] ) ? $atts['thumbresomobile'] : 'sddefault';
        }

        $nolazy_load_lists = '(data-no-lazy|loading="eager"|data-skip-lazy|skip-lazy)';

        $enable_lazyload_loggedin_users = carbon_get_theme_option('optimize_youtube_video_isuserloggedin');
        if ( preg_match( $nolazy_load_lists, $iframe['atts'], $atts ) || (!$enable_lazyload_loggedin_users && is_user_logged_in()) ) {
            $iframe['lazyload'] = false;
        }

        if ( preg_match( '@\sytargs\s*=\s*(\'|")(?<ytargs>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['ytargs'] = $atts['ytargs'];
        }

        if ( preg_match( '@\stitle\s*=\s*(\'|")(?<title>.*)\1@iUs', $iframe['atts'], $atts ) ) {
            $iframe['title'] = $atts['title'];
        }

        $content = str_replace( $iframe[0], optimize_youtube_video_replaceIframe($iframe), $content );
    }

    return $content;
}

function optimize_youtube_video_getimgurl( $iframe, $reso="sddefault" ) {

    $type = $iframe['nowebp'] ? 'vi' : 'vi_webp';

    $ext = $iframe['nowebp'] ? '.jpg' : '.webp';

    return 'https://i.ytimg.com/'.$type.'/'.$iframe['youtube_id'].'/'.$reso.$ext.'';

}


function optimize_youtube_video_urlreplace_fromvar($buffer="", $iframe, $reso ) {

    $buffer = str_replace('[syv_image_src]', optimize_youtube_video_getimgurl( $iframe, $reso ), $buffer);
    
    $allowed_resolutions = optimize_youtube_video_allowed_resolutions();

    foreach( $allowed_resolutions as $key => $resolution ) {
        
        $buffer = str_replace('[syv_image_src_'.$key.']', optimize_youtube_video_getimgurl( $iframe, $key ), $buffer);

    }

    return $buffer;

}

function optimize_youtube_video_replaceIframe( $iframe ) {

    // allowed thumbnail resolutions
    $allowed_resolutions = optimize_youtube_video_allowed_resolutions();

    $youtubesrc = is_null($iframe['ytargs']) ? $iframe['youtube'].'?autoplay=1' : $iframe['youtube'].$iframe['ytargs'];

    $content = '
    <div class="youtube-video-ts">
        <div data-img-webpfield data-yt-src="'.$youtubesrc.'" width="'.$iframe['width'].'" height="'.$iframe['height'].'" style="width:'.$iframe['width'].'px;height:'.$iframe['height'].'px;">
    ';

    $thumbtype = $iframe['nowebp'] ? 'vi' : 'vi_webp';
    $thumbext = $iframe['nowebp'] ? 'jpg' : 'webp';

    $lazyimgbinding = carbon_get_theme_option('optimize_youtube_video_lazyimg_custom_binding');
    if(!$lazyimgbinding) {
        $lazyimgbinding='src="[syv_image_src]" loading="lazy"';
    }

    $nonlazyimgbinding = carbon_get_theme_option('optimize_youtube_video_nonlazyimg_custom_binding');
    if(!$nonlazyimgbinding) {
        $nonlazyimgbinding='src="[syv_image_src]" loading="eager"';
    }

    $simpleyoutubevideoplayiframeattrs = carbon_get_theme_option('optimize_youtube_video_iframeattributes');

    if(wp_is_mobile()):

        $imglazycontent = optimize_youtube_video_urlreplace_fromvar($lazyimgbinding, $iframe, $iframe['thumbresomobile']);
        $imgnonlazycontent = optimize_youtube_video_urlreplace_fromvar($nonlazyimgbinding, $iframe, $iframe['thumbresomobile']);
        
        $imgattrs = $iframe['lazyload'] ? $imglazycontent : $imgnonlazycontent;
        
        $content .= '
        <img '.$imgattrs.' width="'.$allowed_resolutions[$iframe['thumbresomobile']]['width'].'" height="'.$allowed_resolutions[$iframe['thumbresomobile']]['height'].'" alt="'.$iframe['title'].'" />';
    else:

        $imglazycontent = optimize_youtube_video_urlreplace_fromvar($lazyimgbinding, $iframe, $iframe['thumbreso']);
        $imgnonlazycontent = optimize_youtube_video_urlreplace_fromvar($nonlazyimgbinding, $iframe, $iframe['thumbreso']);
        
        $imgattrs = $iframe['lazyload'] ? $imglazycontent : $imgnonlazycontent;

        $content .= '
        <img '.$imgattrs.' width="'.$allowed_resolutions[$iframe['thumbreso']]['width'].'" height="'.$allowed_resolutions[$iframe['thumbreso']]['height'].'" alt="'.$iframe['title'].'" />';
    endif;

    $content .= '<noscript>';
    $content .= '<iframe src="'.$youtubesrc.'" class="syv_noscript_iframe" width="'.$iframe['width'].'" height="'.$iframe['height'].'" '.$simpleyoutubevideoplayiframeattrs.'></iframe>';
    $content .= '</noscript>';
    $content .= '
            <button class="play" aria-label="'.carbon_get_theme_option('optimize_youtube_video_button_arialabel').'"></button>
        </div>
    </div>
    ';

    return optimize_youtube_video_sanitize_output($content);
}
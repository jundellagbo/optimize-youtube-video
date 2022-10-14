<?php
/*
Plugin Name: Optimize Youtube Video
Text Domain: optimize-youtube-video
Description: Simple plugin to optimize youtube videos and improve the site page speed score.
Version: 2.0.0
Author: Jundell Agbo
Author URI: https://profiles.wordpress.org/jundellagbo/
License: GPLv2 or later
*/

function opt_youtube_video_shortcode( $attrs ) {
    $default = array(
        'id' => null,
        'imgformat' => 'jpg',
        'width' => 480,
        'height' => 360,
        'title' => 'Youtube Video',
        'showtitle' => 0, 
        'lazyload' => 1,
        'lazysrc' => "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E",
        'lazyattr' => 'data-src',
        'ytattrs' => '?autoplay=1',
        'ytthumbail' => 'hqdefault',
        'thumbnailclass' => 'lazyload'
    );
    $param = shortcode_atts($default, $attrs);
    ob_start();
    if($param['id']):
        $therealsrc = "https://i.ytimg.com/vi/".$param['id']."/".$param['ytthumbail'].".".$param['imgformat'];
        $ytembedsrc = "https://www.youtube.com/embed/".$param['id'].$param['ytattrs'];
    ?>
    <div class="youtube-video-ts">
        <div data-img-webpfield data-yt-src="<?php echo $ytembedsrc; ?>" width="<?php echo $param['width']; ?>" height="<?php echo $param['height']; ?>" style="width: <?php echo $param['width']; ?>px; height: <?php echo $param['height']; ?>px;">
            
            <?php if($param['title'] && $param['showtitle']): ?>
            <a href="https://www.youtube.com/watch?v=<?php echo $param['id']; ?>" target="_blank" data-sessionlink="feature=player-title" class="opt-yt-title" tabindex="-1"><?php echo $param['title']; ?></a>
            <?php endif; ?>
        
            <img 
            <?php if($param['lazyload']): ?>
                src="<?php echo $param['lazysrc']; ?>"
                <?php echo $param['lazyattr']; ?>="<?php echo $therealsrc; ?>"
            <?php else: ?>
                src="<?php echo $therealsrc; ?>"
            <?php endif; ?>

            <?php if($param['thumbnailclass']): ?>
                class="<?php echo $param['thumbnailclass']; ?>"
            <?php endif; ?>
            width="<?php echo $param['width']; ?>" 
            height="<?php echo $param['height']; ?>" 
            alt="<?php echo $param['title']; ?>" />
            
            <button class="play" aria-label="play Youtube video"> 
                <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"> 
                    <path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path> 
                    <path d="M 45,24 27,14 27,34" fill="#fff"> </path> 
                </svg> 
            </button>
        </div>
    </div>
    <?php
    endif;
    $html = ob_get_clean();
    return $html;
}
add_shortcode('opt-youtube-video', 'opt_youtube_video_shortcode');

add_action('wp_head', 'opt_youtube_video_styles'); 
function opt_youtube_video_styles() { 
    ob_start();
    echo '<style type="text/css">';
    include plugin_dir_path( __FILE__ ) . 'assets/youtube.min.css';
    echo '</style>';
    $html = ob_get_clean();
    echo $html;
}

add_action('wp_footer', 'opt_youtube_video_script', 100); 
function opt_youtube_video_script() { 
    ob_start();
    echo '<script type="text/javascript">';
    include plugin_dir_path( __FILE__ ) . 'assets/youtube.min.js';
    echo '</script>';
    $html = ob_get_clean();
    echo $html;
}
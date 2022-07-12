<?php 
$simpleyoutubevideoiconurl = carbon_get_theme_option('optimize_youtube_video_playicon'); 
$simpleyoutubevideoiconurl = isset($simpleyoutubevideoiconurl) && !empty($simpleyoutubevideoiconurl) ? $simpleyoutubevideoiconurl : plugin_dir_url( __FILE__ ).'../assets/youtube.webp';
$videowrapbgcolor = carbon_get_theme_option('optimize_youtube_video_background');
$videowrapbgcolor = isset($videowrapbgcolor) && !empty($videowrapbgcolor) ? $videowrapbgcolor : '#000000';
?>
<style type="text/css" id="optimize-youtube-video-frontend-css">
    .youtube-video-ts,
    .youtube-video-ts [data-img-webpfield] {
        position: relative;
        max-width: 100%;
        display: inline-block;
    }
    .youtube-video-ts [data-img-webpfield] {
        display: flex;
        align-items: center;
        justify-content: center;
        background: <?php echo esc_attr( $videowrapbgcolor ); ?>;
    }
    .youtube-video-ts img {
        object-fit: cover;
        width: 100%;
        height: auto;
        max-height: 100%;
        max-width: 100%;
    }
    .youtube-video-ts .img-yt-ts {
        bottom: 0;
        display: block;
        left: 0;
        margin: auto;
        max-width: 100%;
        width: 100%;
        position: absolute;
        right: 0;
        top: 0;
        border: none;
        height: auto;
    }
    .youtube-video-ts iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        background: 0 0;
    }
    .youtube-video-ts .play {
        height: 100%;
        width: 100%;
        left: 0;
        top: 0;
        position: absolute;
        background: url(<?php echo esc_url( $simpleyoutubevideoiconurl ); ?>) no-repeat center;
        background-color: transparent !important;
        cursor: pointer;
        border: none;
    }
</style>
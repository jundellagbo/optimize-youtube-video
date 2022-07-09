<script type="text/javascript" id="optimize-youtube-video-frontend-js">
let ytubeplaybtn = document.querySelectorAll('.youtube-video-ts .play');
ytubeplaybtn.forEach(btn => {
   btn.addEventListener('click', (e)=> {
	   const parentNode = e.target.parentNode;
	   const ytvideosrc = parentNode.getAttribute('data-yt-src');
	   const ytwidth = parentNode.getAttribute('width');
	   const ytheight = parentNode.getAttribute('height');
       const ytiframeattrs = parentNode.getAttribute('iframeattrs');

        <?php $simpleyoutubevideoplayiframeattrs = carbon_get_theme_option('optimize_youtube_video_iframeattributes'); ?>
        <?php $simpleyoutubevideoplayiframeattrs = isset($simpleyoutubevideoplayiframeattrs) && !empty($simpleyoutubevideoplayiframeattrs) ? $simpleyoutubevideoplayiframeattrs : 'frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"' ?>

        let iframeattrs = ytiframeattrs;
        if(!iframeattrs) { iframeattrs = "<?php echo esc_js( __( $simpleyoutubevideoplayiframeattrs, 'optimize-youtube-video' ) ); ?>"; }
        parentNode.innerHTML = `<iframe src="${ytvideosrc}" width="${ytwidth}" height="${ytheight}" ${iframeattrs}></iframe>`;
    });
});
</script>
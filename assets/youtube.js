let ytubeplaybtn = document.querySelectorAll('.youtube-video-ts .play');
ytubeplaybtn.forEach(btn => {
   btn.addEventListener('click', (e)=> {
	   const parentNode = e.target.parentNode.closest('[data-yt-src]');
	   const ytvideosrc = parentNode.getAttribute('data-yt-src');
	   const ytwidth = parentNode.getAttribute('width');
	   const ytheight = parentNode.getAttribute('height');
        parentNode.innerHTML = `<iframe src="${ytvideosrc}" width="${ytwidth}" height="${ytheight}" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>`;
    });
});
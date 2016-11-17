$('.ad-gallery').adGallery({
    loader_image: requestUrl + '/libs/visita-medica/ad-gallery/loader.gif',
    update_window_hash: false,
    width: 400,
    height: 300,
    thumb_opacity: 0.7,
    hooks: {
        displayDescription: function(image) {}
    }
});

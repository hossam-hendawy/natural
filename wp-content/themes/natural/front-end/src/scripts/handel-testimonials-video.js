export function handelTestimonialsVideo(block) {
  
  block.querySelectorAll('.video-wrapper').forEach(wrapper => {
    wrapper.addEventListener('click', function (event) {
      event.stopPropagation();
      toggleVideoPlayPause(wrapper);
    });
  });
  
  function toggleVideoPlayPause(currentWrapper) {
    const videos = block.querySelectorAll('.video-player');
    const buttons = block.querySelectorAll('.play-button');
    const currentVideo = currentWrapper.querySelector('.video-player');
    const currentButton = currentWrapper.querySelector('.play-button');
    
    if (!currentVideo.paused && !currentVideo.muted) {
      currentVideo.pause();
      currentVideo.muted = true;
      currentButton.classList.remove('hide');
    } else {
      videos.forEach((video, index) => {
        if (video !== currentVideo) {
          // video.pause();
          video.muted = true;
          buttons[index].classList.remove('hide');
        }
      });
      
      currentVideo.muted = false;
      currentVideo.play();
      currentButton.classList.add('hide');
    }
  }

}

window.addEventListener("DOMContentLoaded", () => {
  var all = document.querySelectorAll(".gallery img");

  if (all.length>0) { for (let img of all) {
    img.onclick = () => {
      if (document.webkitFullscreenElement || document.fullscreenElement) {
        if (document.exitFullscreen) { document.exitFullscreen(); }
        else if (document.webkitExitFullscreen) { document.webkitExitFullscreen(); }
      }

      else {
        if (img.requestFullscreen) { img.requestFullscreen(); }
        else if (img.webkitRequestFullscreen) { imgimg.webkitRequestFullscreen(); }
      }
    };
  }}
});

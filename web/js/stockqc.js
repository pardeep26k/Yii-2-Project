$(document).ready(function(){
    $('.imageEditContainerCropper').on('click',function(element){
    var id = element.currentTarget.id;
    $('#img_'+id).cropper({
        aspectRatio: 16 / 9,
        crop: function(e) {
          // Output the result data for cropping image.
          console.log(e.x);
          console.log(e.y);
          console.log(e.width);
          console.log(e.height);
          console.log(e.rotate);
          console.log(e.scaleX);
          console.log(e.scaleY);
        }
      });
    });
});
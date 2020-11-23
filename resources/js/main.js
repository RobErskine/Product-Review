$('.delete').on('click',function(){
  var result = confirm("Are you sure you want to delete this review?");
  if (result == true) {
      return true;
  } else {
      return false;
  }
});

var startingCount = $('#comment').val().length;
$('#counter .current').html(startingCount);

$('#comment').on('keyup',function(){

  startingCount = $('#comment').val().length;
  $('#counter .current').html(startingCount);

});

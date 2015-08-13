$(function() {
  var $grid;
  $grid = $('.grid').masonry({
    columnWidth: '.grid-sizer',
    percentPosition: true,
    itemSelector: '.grid-item',
    gutter: 10
  });
  $grid.imagesLoaded().progress(function() {
    $grid.masonry('layout');
  });
});


/**
 * Routes Dashboard
 */


var areYouSureToDelete;

areYouSureToDelete = function(e) {
  if (confirm('Are you sure you want to delete this project?')) {
    return true;
  }
  return e.preventDefault();
};

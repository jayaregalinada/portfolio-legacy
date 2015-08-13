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

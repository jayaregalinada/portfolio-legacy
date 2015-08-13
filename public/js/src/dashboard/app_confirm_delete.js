var areYouSureToDelete;

areYouSureToDelete = function(e) {
  if (confirm('Are you sure you want to delete this project?')) {
    return true;
  }
  return e.preventDefault();
};

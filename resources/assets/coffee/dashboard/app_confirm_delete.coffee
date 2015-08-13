areYouSureToDelete = (e)->
  if confirm 'Are you sure you want to delete this project?'
    return true

  e.preventDefault()


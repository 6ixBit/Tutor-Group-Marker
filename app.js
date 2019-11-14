var validate_id = () => {
    var user_id = document.querySelector('.register')
    if (isNaN(parseInt(user_id))){
        alert('Your ID must be a number!')
        window.stop()
    } else {
        return False
    }
}

var dark_mode = () => {
    return False
}
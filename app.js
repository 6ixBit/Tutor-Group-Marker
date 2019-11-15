var validate_id = () => {
    var user_id = document.querySelector('.register')
    if (isNaN(parseInt(user_id))){
        alert('Your ID must be a number!')
        window.stop()
    } else {
        return False
    }
}
 
var send_reminders = () => {
    return null
}

var send_results = () => {
    return null
}
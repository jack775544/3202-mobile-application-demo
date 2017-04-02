$("#login-form").submit(function(e){
    // Stop the form from submitting so we can do it via AJAX
    e.preventDefault();

    $.post('192.168.1.22/backend/create_user.php', $('#login-form').serialize(), function (r) {
        if (r.success == true) {
            alert("User Created");
            window.location = "index.html";
        } else {
            alert("User Creation Failed");
        }
    })
});
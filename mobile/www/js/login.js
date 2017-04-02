$("#login-form").submit(function(e){
    console.log("Clicked the form");
    // Stop the form from submitting so we can do it via AJAX
    e.preventDefault();

    $.post('192.168.1.22/backend/login.php', $('#login-form').serialize(), function (r) {
        if (r.auth === true) {
            alert("You have been logged in successfully");
            window.location = "index.js";
        } else {
            alert("You aren't authorised to log in");
        }
        console.log('yeah');
    });
    console.log('blah');
});
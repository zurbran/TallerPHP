
function validateEmailField (value){
    validregex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(validregex.test(value) == true)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

function validateAlphabeticField (value){
    validregex = /^[a-z]+$/i;
    if(validregex.test(value) == true)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

function validate(){
    if(validateAlphabeticField(document.getElementById('first_name').value))
    {
        $('#alertname').hide();
    }
    else
    {
        $('#alertname').show();
    }
    if(validateAlphabeticField(document.getElementById('last_name').value))
    {
        $('#alertlastname').hide();
    }
    else
    {
        $('#alertlastname').show();
    }
    if(validateEmailField(document.getElementById('emailbox').value))
    {
        $('#alertemail').hide();
    }
    else
    {
        $('#alertemail').show();
    }
}

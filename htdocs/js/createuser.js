function showFileName()
{
   var pictureFile = document.getElementById('userpic');
  document.getElementById('picturename').value = pictureFile.files[0].name;
}


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
    
    var pass = document.getElementById('password').value;
    var passconf = document.getElementById('password_confirmation').value;

    if(pass != passconf)
    {
        $('#alertpass').text("Las contraseñas no coinciden");
        $('#alertpass').show();
    }
    else
    {
        if((pass === "")||(passconf === "")||(pass === null)||(passconf === null))
        {
            $('#alertpass').text("Falta completar campo de contraseña");
            $('#alertpass').show();
        }
        else
        {
            $('#alertpass').hide();
        }
    }
}

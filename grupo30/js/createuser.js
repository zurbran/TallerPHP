var pictureFile = null;

function showFileName()
{
    pictureFile = document.getElementById('userpic');
    document.getElementById('picturename').value = pictureFile.files[0].name;
    $('#alertpic').hide();
}


function validateEmailField (value){
    validregex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    $('#alertemail2').hide();
    if(validregex.test(value) == true)
    {
        $('#alertemail').hide();
        return 1;
    }
    else
    {
        $('#alertemail').show();
        return 0;
    }
}

function validateNameField (value){
    validregex = /^[a-z]+$/i;
    if(validregex.test(value) == true)
    {
        $('#alertname').hide();
        return 1;
    }
    else
    {
        $('#alertname').show();
        return 0;
    }
}

function validateSurnameField (value){
    validregex = /^[a-z]+$/i;
    if(validregex.test(value) == true)
    {
        $('#alertlastname').hide();
        return 1;
    }
    else
    {
        $('#alertlastname').show();
        return 0;
    }
}

function validatePasswordField (){
    // const validregex = /^(?=.*[a-z])(?=.*[A-Z])((?=.*[!@#$&*])|(?=.*\d)).{6,}$/gm;
    // $
    validregex = /^((?=.*[a-z])(?=.*[A-Z]))((?=.*[-!@#$&*])|(?=.*\d)).{6,}$/;
    
    var pass = document.getElementById('password').value;
    var passconf = document.getElementById('password_confirmation').value;

    if((pass === "")|(passconf === "")|(pass === null)|(passconf === null))
    {
        $('#alertpass').text("Falta completar campo de contraseña");
        $('#alertpass').show();
    }
    else
    {
        if(pass != passconf)
        {
            $('#alertpass').text("Las contraseñas no coinciden");
            $('#alertpass').show();
            return 0;
        }
        else
        {
            if(validregex.test(pass))
            {
                $('#alertpass').hide();
                return 1;
            }
            else
            {
                $('#alertpass').text("La contraseña debe ser de por los menos 6 carecteres incluyendo letras (mayúsculas y minúsculas) y por lo menos un número o un símbolo"); 
                 
                $('#alertpass').show();
                return 0;
            }
        }  
    }
}

function fileValidation(){
    var fileInput = document.getElementById('userpic');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg)$/i;
    if(!allowedExtensions.exec(filePath)){
        //alert('Por favor inserte una imagen cuya extension sea JPEG o JPG.');
        $('#alertpicture').show();
        fileInput.value = '';
        return false;
    }else{
        $('#alertpicture').hide();
        return true;
    }
}

function validate(){

    if((fileValidation())&(validateEmailField(document.getElementById('emailbox').value))&(validateNameField(document.getElementById('first_name').value))&((validateSurnameField(document.getElementById('last_name').value)))&(validatePasswordField()))
    {
        postForm();
    }
    //return false;
}
function postForm() {
    document.getElementById('signup').submit();
    //return true;
}


function post(path, params, method) {
    method = method || "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("id", key);
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);

    form.submit();
}

function takedown(id)
{
    var res = confirm("¿Està seguro que desea dar de baja el libro?");
    if(res==true)
    {
        var objTakeDown = {bookId : id};
        post("takedown.php",objTakeDown,"post");
    }
}
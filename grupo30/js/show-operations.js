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

function reservate(id)
{
    var objReserve = {bookId : id};
    post("/grupo30/show-operations.php"+window.location.search,objReserve,"post");
}

function borrow(opid)
{
    var objBorrow = {opNum : opid , operation : "borrow"};
    post("/grupo30/show-operations.php?alert=true"+window.location.search.replace("?", "&"),objBorrow,"post");
}

function takeback(opid)
{
    var objTakeBack = {opNum : opid , operation : "takeback"};
    post("/grupo30/show-operations.php?alert=true"+window.location.search.replace("?", "&"),objTakeBack,"post");
}

function fadeAlert(operation){
    var btn = document.getElementById("alertbutton");
    var msg;
    switch(operation) {
        case "reserved":
            msj = "Libro reservado con éxito"; 
            break;
        case "borrowed":
            msj = "Libro prestado con éxito"; 
            break;
        case "returned":
            msj = "Libro devuelto con éxito";
            break;
        default:
            msj = "Operación inválida";
    }
    btn.innerHTML = msj;
    btn.classList.remove("-hide");
    setTimeout(function () {
        btn.classList.add("-hide");
    }, 5000);
}
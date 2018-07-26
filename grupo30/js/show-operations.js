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
    post("/grupo30/show-operations.php"+window.location.search,objBorrow,"post");
}

function takeback(opid)
{
    var objTakeBack = {opNum : opid , operation : "takeback"};
    post("/grupo30/show-operations.php"+window.location.search,objTakeBack,"post");
}
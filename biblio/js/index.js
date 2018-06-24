function post(path, param, method) {
    method = method || "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("id", "bookId");
    hiddenField.setAttribute("name", "bookId");
    hiddenField.setAttribute("value", param);

    form.appendChild(hiddenField);


    document.body.appendChild(form);
    form.submit();
}

function reservate(id)
{
    post("/index.php"+window.location.search,id,"post");
}

function borrow(id)
{
}

function takeback(id)
{
}
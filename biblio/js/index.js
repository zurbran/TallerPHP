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

function reservate(id,page,sort,order,tittle,author)
{
    window.alert("/index.php?page="+page+"&sort="+sort+"&order="+order+"&searchT="+tittle+"&searchA="+author);
    post("/index.php?page="+page+"&sort="+sort+"&order="+order+"&searchT="+tittle+"&searchA="+author,id,"post");
    $("reserve"+id).button('dispose')
}

function borrow(id)
{
}

function takeback(id)
{
}
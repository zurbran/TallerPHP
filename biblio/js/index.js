function reservate(id)
{
    var form = document.getElementById('reserve');
    var input = $('<input></input>');

    input.attr("type", "hidden");
    input.attr("bookId", id);
    input.attr("value", value);
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
}
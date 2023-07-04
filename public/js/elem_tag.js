function checkElem(){
    var count = document.getElementsByClassName("h-100 card-body").count;
    if (count == 0) {
        document.getElementsByClassName("text-center no-text fs-4")[0].style.display = "none";
    } else {
        document.getElementsByClassName("text-center no-text fs-4")[0].style.display = "block";
    }
}

function removeDummy(elem, br) {
    elem.parentNode.removeChild(elem);
    br.parentNode.removeChild(br);
}

function createForm(name, x, y, id) {
    var contener_one = document.createElement("div");
    contener_one.className = "container card"

    var contener_two = document.createElement("div");
    contener_two.className = "card-body"
    contener_one.appendChild(contener_two);

    var contener_three = document.createElement("div");
    contener_three.className = "row"
    contener_two.appendChild(contener_three);

    var br = document.createElement("br");


    var col1 = document.createElement("div");
    col1.className = "col"
    contener_three.appendChild(col1);

    var row1 = document.createElement("div");
    row1.className = "row-lg fs-4"
    row1.textContent = "Название: " + name;
    col1.appendChild(row1);

    var row2 = document.createElement("div");
    row2.className = "row-lg fs-4"
    row2.textContent = "Координаты: " + x + "," + y;
    col1.appendChild(row2);



    var col2 = document.createElement("div");
    col2.className = "col-lg"
    contener_three.appendChild(col2);

    var row3 = document.createElement("div");
    row3.className = "row-lg"
    row3.style.cssText = "display: flex; justify-content: flex-end;";
    col2.appendChild(row3);

    var img1 = document.createElement("img");
    img1.src = "{{ URL('images/edit.png') }}";
    img1.width = "25";
    img1.height = "25";
    img1.className = "mg-thumbnail fs-4";
    img1.alt = "Редактирование";
    row3.appendChild(img1);


    var row4 = document.createElement("div");
    row4.className = "row-lg"
    row4.style.cssText = "display: flex; justify-content: flex-end;";
    col2.appendChild(row4);

    var img2 = document.createElement("img");
    img2.src = "{{ URL('images/bin.png') }}";
    img2.width = "25";
    img2.height = "25";
    img2.className = "mg-thumbnail fs-4";
    img2.alt = "Удаление";
    img2.onclick = function() {
        deleteTag(id);
        removeDummy(contener_one, br);

    };
    row3.appendChild(img2);



    (document.getElementsByClassName("h-100 card-body")[0]).appendChild(contener_one);
    (document.getElementsByClassName("h-100 card-body")[0]).appendChild(br);
}
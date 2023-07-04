@extends('layouts.app')

@section('content')
    <script src="https://api-maps.yandex.ru/2.1.3/?apikey=c9bf13f6-ec19-4e16-8a69-f9a0185a25c7&lang=ru_RU"
        type="text/javascript"></script>

    <script>
        class Tag {
            name;
            longitude;
            latitude;
            idTag;
            constructor(name, longitude, latitude, idTag) {
                this.name = name;
                this.longitude = longitude;
                this.latitude = latitude;
                this.idTag = idTag;
            }
            print() {
                console.log(`Название: ${this.name}  Широта: ${this.longitude}  Долгота: ${this.latitude}`);
            }
        }
        var myArrayTag = [];
        var myMap = null;
        var test = 0;

        function init() {

            if (test == 1) {
                myMap.destroy();
            }

            var geolocation = ymaps.geolocation;
            myMap = new ymaps.Map('map_block', {
                center: [55, 34],
                zoom: 10
            }, {
                searchControlProvider: 'yandex#search'
            });

            // let placemark = new ymaps.Placemark([52.07474207957652,113.37877547730022], {
            //     balloonContentHeader:'Имя балуна',
            //     balloonContentBody:'Тело балуна',
            //     balloonContentFooter:'Подвал балуна',
            // }, {});
            // myMap.geoObjects.add(placemark);

            myMap.events.add('click', function(e) {
                var coords = e.get('coords');
                var str_array = String(coords).split(',');
                document.getElementById("flongitude").value = str_array[0];
                document.getElementById("lwidth").value = str_array[1];
                //alert();
            });

            // Сравним положение, вычисленное по ip пользователя и
            // положение, вычисленное средствами браузера.
            geolocation.get({
                provider: 'yandex',
                mapStateAutoApply: true
            }).then(function(result) {
                ymaps.geocode(result.geoObjects.position).then(function(res) {
                    //alert(res.geoObjects.get(0).properties.get('text'));
                });
                // Красным цветом пометим положение, вычисленное через ip.
                result.geoObjects.options.set('preset', 'islands#redCircleIcon');
                result.geoObjects.get(0).properties.set({
                    balloonContentBody: 'Мое местоположение'
                });
                myMap.geoObjects.add(result.geoObjects);
            });

            geolocation.get({
                provider: 'browser',
                mapStateAutoApply: true
            }).then(function(result) {
                // Синим цветом пометим положение, полученное через браузер.
                // Если браузер не поддерживает эту функциональность, метка не будет добавлена на карту.
                ymaps.geocode(result.geoObjects.position).then(function(res) {
                    //alert(res.geoObjects.get(0).properties.get('text'));
                });
                result.geoObjects.options.set('preset', 'islands#blueCircleIcon');
                myMap.geoObjects.add(result.geoObjects);
            });


            myArrayTag.forEach(element => {
                let placemark = new ymaps.Placemark([element.longitude, element.latitude], {
                    balloonContentHeader: element.name,
                    // balloonContentBody: 'Тело балуна',
                    // balloonContentFooter: 'Подвал балуна',
                }, {});
                myMap.geoObjects.add(placemark);
            });

            //setMaxHeghtTag();
            test = 1;
        }
        ymaps.ready(init);

        function removeDummy(elem, br, id) {
            elem.parentNode.removeChild(elem);
            br.parentNode.removeChild(br);
            console.log(myArrayTag);
            for (let index = 0; index < myArrayTag.length; index++) {
                // const element = myArrayTag[index];

                if (myArrayTag[index].idTag == id) {
                    myArrayTag.splice(index, 1);
                    console.log("delete");
                }
                console.log(myArrayTag);
            }
            console.log(myArrayTag);

            ymaps.ready(init);
        }

        function createForm(name, x, y, id) {

            var tag = new Tag(name, x, y, id);
            myArrayTag.push(tag);

            var contener_one = document.createElement("div");
            contener_one.className = "container card"

            contener_one.onclick = function() {
                myMap.setCenter([x, y], 17, {
                    checkZoomRange: true
                });
            };

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
            img1.onclick = function() {

                var inp = document.getElementsByClassName("form-control form-control w-100");
                inp[0].value = name;
                inp[1].value = x;
                inp[2].value = y;

                var but = document.getElementsByClassName("btn btn-primary btn-lg");
                but[0].style.display = "none";
                but[1].style.display = "block"; //Изменить
                but[2].style.display = "block"; //Удалить
                but[3].style.display = "block"; //Отменить

                but[1].onclick = function() {

                    editTag(id, row1, row2, contener_one);

                    but[0].style.display = "block";
                    but[1].style.display = "none"; //Изменить
                    but[2].style.display = "none"; //Удалить
                    but[3].style.display = "none"; //Отменить

                    inp[0].value = "";
                    inp[1].value = "";
                    inp[2].value = "";
                };

                but[2].onclick = function() {
                    deleteTag(id);
                    removeDummy(contener_one, br, id);

                    but[0].style.display = "block";
                    but[1].style.display = "none"; //Изменить
                    but[2].style.display = "none"; //Удалить
                    but[3].style.display = "none"; //Отменить

                    inp[0].value = "";
                    inp[1].value = "";
                    inp[2].value = "";
                };

                but[3].onclick = function() {

                    but[0].style.display = "block";
                    but[1].style.display = "none"; //Изменить
                    but[2].style.display = "none"; //Удалить
                    but[3].style.display = "none"; //Отменить

                    inp[0].value = "";
                    inp[1].value = "";
                    inp[2].value = "";
                };

            };
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
                removeDummy(contener_one, br, id);

            };
            row3.appendChild(img2);



            (document.getElementsByClassName("h-100 card-body")[0]).appendChild(contener_one);
            (document.getElementsByClassName("h-100 card-body")[0]).appendChild(br);

            ymaps.ready(init);
        }
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="h-100 col-md-4">
                <div class="card">

                    <div class="card-body">

                        <form class="w-100">
                            <label class="fs-4" for="fname">Название:</label><br>
                            <input class="form-control form-control w-100" type="text" id="fname" name="fname"><br>
                            <label class="fs-4" for="flongitude">Долгота:</label><br>
                            <input class="form-control form-control w-100" type="number" inputmode="decimal"
                                pattern="[0-9]*[.]?[0-9]*" max="1000" step="1" id="flongitude"
                                name="flongitude"><br>
                            <label class="fs-4" for="lwidth">Широта:</label><br>
                            <input class="form-control form-control w-100" type="number" id="lwidth" name="lwidth"
                                inputmode="decimal" pattern="[0-9]*[.]?[0-9]*" max="1000" step="1" id="flongitude"
                                name="flongitude"><br>
                        </form>

                        <div style="display: flex; justify-content:space-around; padding-left:10%; padding-right:10%;">
                            <button class="btn btn-primary btn-lg" onclick="newTag()"> Добавить </button>
                            <button style="display:none;" class="btn btn-primary btn-lg">Изменить</button>
                            <button style="display:none;" class="btn btn-primary btn-lg">Удалить</button>
                            <button style="display:none;" class="btn btn-primary btn-lg">Отменить</button>
                        </div>
                    </div>

                    <div class="text-center no-text fs-4" style="display:none;">
                        У вас нет записанных локаций<br>
                    </div>

                    <div class="h-100 card-body" style="overflow: auto;">


                        <script>
                            @foreach ($tags as $tag)

                                createForm("{{ $tag->name }}", {{ $tag->longitude }}, {{ $tag->latitude }}, {{ $tag->id }});
                            @endforeach
                        </script>

                        {{-- <div class="container card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row-lg fs-4">Название:{{ $tag->name }}</div>
                                            <div class="row-lg fs-4">Координаты:{{ $tag->longitude }},{{ $tag->latitude }}
                                            </div>
                                        </div>

                                        <div class="col-lg">

                                            <div class="row-lg"
                                                style="display: flex;
                                            justify-content: flex-end;">
                                                <img src="{{ URL('images/edit.png') }}" width="25" height="25"
                                                    class="img-thumbnail fs-4" alt="Редактирование">
                                            </div>

                                            <div class="row-lg"
                                                style="display: flex;
                                            justify-content: flex-end;">
                                                <img src="{{ URL('images/bin.png') }}" width="25" height="25"
                                                    class="img-thumbnail fs-4" onclick="deleteTag({{ $tag->id }})"
                                                    alt="Удаление">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br> --}}
                        {{-- @endforeach --}}

                    </div>

                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="map_block" style="width: 100%; height:500px">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function setMaxHeghtTag() {
            let max_height = document.getElementsByClassName("col-md-8")[0].height;
            //document.getElementsByClassName("h-100 col-md-4")[0].style.cssText = "max-height:" + max_height + ";";
            document.getElementsByClassName("h-100 col-md-4")[0].height = max_height;
        }

        function newTag() {

            var data_name = document.getElementById("fname").value;
            var data_longitude = document.getElementById("flongitude").value;
            var data_latitude = document.getElementById("lwidth").value;

            $.ajax({
                url: "/tag_new",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: data_name,
                    longitude: data_longitude,
                    latitude: data_latitude,
                },
                dataType: 'text',
                success: function(data) {
                    createForm(data_name, data_longitude, data_latitude, data)
                },
                error: function(data) {
                    alert("mistake: " + data.error);
                }
            });

            // $.ajax({
            //     type: 'get',
            //     url: "/tag_new",
            //     data: {
            //         name: 12,
            //         longitude: 12,
            //         latitude: 12,
            //     },
            //     processData: false,
            //     contentType: false,
            //     dataType: 'text',
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //     },
            //     success: function(data) {
            //         // if (data.act == "successfull") 
            //         // {
            //             alert(data);
            //         // } 
            //     },
            //     error: function(data) {
            //         alert("mistake: " + data.error);
            //     }
            // });
        }

        function editTag(id, name_f, cord_f, click) {

            var data_name = document.getElementById("fname").value;
            var data_longitude = document.getElementById("flongitude").value;
            var data_latitude = document.getElementById("lwidth").value;

            $.ajax({
                url: "/tag_edit",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    name: data_name,
                    longitude: data_longitude,
                    latitude: data_latitude,
                },
                dataType: 'JSON',
                success: function(data) {
                    name_f.textContent = "Название: " + data_name;

                    var longit = data_longitude.replace(',', '.')
                    var latit = data_latitude.replace(',', '.')
                    cord_f.textContent = "Координаты: " + longit + "," + latit;
                    //alert(data);

                    for (let index = 0; index < myArrayTag.length; index++) {
                        // const element = myArrayTag[index];

                        if (myArrayTag[index].idTag == id) {
                            myArrayTag[index].longitude=longit;
                            myArrayTag[index].latitude=latit;
                        }
                    }

                    click.onclick = function() {
                        myMap.setCenter([longit, latit], 17, {
                            checkZoomRange: true
                        });
                    };

                    ymaps.ready(init);

                },
                error: function(data) {
                    alert("mistake: " + data.error);
                }
            });

        }

        function deleteTag(id) {

            $.ajax({
                url: "/tag_delete",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                dataType: 'text',
                success: function(data) {

                    alert("координаты удалены");

                },
                error: function(data) {
                    alert("mistake: " + data.error);
                }
            });

        }
    </script>
@endsection

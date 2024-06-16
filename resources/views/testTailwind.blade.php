<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>

{{--<div class="h-screen w-screen bg-gray-400">--}}
{{--    <div class="h-screen w-screen flex flex-col justify-around">--}}
{{--        <div class="w-1/4 h-1/4 text-blue-950 bg-red-500 shadow shadow-blue-700 drop-shadow hover:bg-black hover:cursor-pointer transition-all duration-300 ease-linear hover:rounded-3xl">--}}
{{--            <div class="flex flex-col justify-center h-p">--}}
{{--                <div>--}}
{{--                    hello--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="w-1/4 h-1/4 text-blue-950 bg-red-500 text-center">--}}
{{--            hello--}}
{{--        </div>--}}

{{--        <div class="w-1/4 h-1/4 text-blue-950 bg-red-500 text-center">--}}
{{--            hello--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="h-screen">--}}
{{--    <div id="card" class="w-1/12 h-1/12 bg-blue-100" draggable="true"> hello </div>--}}
{{--    <br>--}}
{{--    <div id="drop-zone" class="w-1/4 h-1/4 bg-red-50"> drop-zone </div>--}}
{{--</div>--}}

{{--<script>--}}
{{--    const card = document.getElementById('card');--}}
{{--    const dropZone = document.getElementById('drop-zone');--}}
{{--    card.addEventListener('dragstart', function(event) {--}}
{{--        console.log(event)--}}
{{--    })--}}
{{--    dropZone.addEventListener('dragover', function(event) {--}}
{{--        event.preventDefault()--}}
{{--    })--}}
{{--    dropZone.addEventListener('drop', function(event) {--}}
{{--        dropZone.prepend(card)--}}
{{--    })--}}
{{--</script>--}}

<div id="id1" draggable="true" ondragstart="onDragStart(event)" style="border:2px solid green; cursor:pointer;width:100px;height:50px;">Dragged Div</div>


<div id="id2" style="position:absolute;left:200px;top:50px;border:2px solid red; cursor:pointer;width:200px;height:200px;" ondrop="drop_handler(event)" ondragover="dragover_handler(event)">Drop Div
</div>

<script>
    let offsetX;
    let offsetY;

    onDragStart = function(ev) {
        const rect = ev.target.getBoundingClientRect();

        offsetX = ev.clientX - rect.x;
        offsetY = ev.clientY - rect.y;
    };

    drop_handler = function(ev) {
        ev.preventDefault();

        const left = parseInt(id2.style.left);
        const top = parseInt(id2.style.top);

        id1.style.position = 'absolute';
        id1.style.left = ev.clientX - left - offsetX + 'px';
        id1.style.top = ev.clientY - top - offsetY + 'px';
        id2.appendChild(document.getElementById("id1"));
    };

    dragover_handler = function(ev) {
        ev.preventDefault();
        ev.dataTransfer.dropEffect = "move";
    };



</script>



</body>
</html>

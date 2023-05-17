
<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<!--codingflicks.com-->

<head>
    <meta charset="UTF-8">
    <title>Video Slideshow using HTML CSS and Javascript</title>
    <link rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
    }

    iframe {
        width: 50%;
        height: 50%;
        position: absolute;
        object-fit: cover;
        transition: all 150ms linear;
        z-index: 10;
    }

    .box1 {
        opacity: 1;
    }

    .box2 {
        opacity: 0;
    }

    .box3 {
        opacity: 0;
    }

    .container {
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
    }
    </style>
</head>

<body>
    <div class="container">


        <video autoplay="" class="box3" id="box3" src="6.mp4"></video>

        <iframe class="box1" id="box1" src=" https://www.youtube.com/embed/0wvrlOyGlq0" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>

        <iframe class="box2" id="box2" src="htts://www.youtube.com/embed/aRE2Zge1rUI" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>

        <iframe class="box3" id="box3" src="https://www.youtube.com/embed/ly36kn0ug4k" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>

    </div>
    <script>
    var box1 = document.getElementById('box1');
    var box2 = document.getElementById('box2');
    var box3 = document.getElementById('box3');

    box1.onended = function() {
        box2.play();
        box1.style.opacity = 0;
        box2.style.opacity = 1;
    }
    box2.onended = function() {
        box3.play();
        box2.style.opacity = 0;
        box3.style.opacity = 1;
    }
    box3.onended = function() {
        box1.play();
        box3.style.opacity = 0;
        box1.style.opacity = 1;
    }
    </script>
</body>

</html>

<!-- CSS -->
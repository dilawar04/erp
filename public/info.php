<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel='stylesheet' type='text/css' media='all' href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap'/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>

        .art-video-player .art-video{
            position: relative !important;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <p>&nbsp;</p>
                <div class="clearfix"></div>
                <div class="embed-responsive embed-responsive-16by9" style="position: relative;">
                    <div class="artplayer-app art-auto-size"></div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/artplayer/dist/artplayer.js"></script>
<!--<script src="https://unpkg.com/artplayer/dist/artplayer.js"></script>-->
<script>
    let qualities = [
        {
            html: '1080',
            url: 'https://aimomn.s3.amazonaws.com/Ahmed-Isa/720p/2020-11-20%20%28720p%29%20Mann%20o%20Salwa%20kya%20hai%20_%20Rabb%20ka%20Rizq%20kon%20sa%20hai.mp4',
        },
        {
            html: '720',
            url: 'https://aimomn.s3.amazonaws.com/Ahmed-Isa/720p/2020-11-20%20%28720p%29%20Mann%20o%20Salwa%20kya%20hai%20_%20Rabb%20ka%20Rizq%20kon%20sa%20hai.mp4',
        },
        {
            default: true,                     html: '480',
            url: 'https://aimomn.s3.amazonaws.com/Ahmed-Isa/480p/2020-11-20%20%28480p%29%20Mann%20o%20Salwa%20kya%20hai%20_%20Rabb%20ka%20Rizq%20kon%20sa%20hai.mp4',
        },
        {
            html: '360',
            url: 'https://aimomn.s3.amazonaws.com/Ahmed-Isa/360p/2020-11-20%20%28360p%29%20Mann%20o%20Salwa%20kya%20hai%20_%20Rabb%20ka%20Rizq%20kon%20sa%20hai.mp4',
        },
    ];

    var art = new Artplayer({
        container: '.artplayer-app',
        url: 'https://aimomn.s3.amazonaws.com/Ahmed-Isa/480p/2020-11-20%20%28480p%29%20Mann%20o%20Salwa%20kya%20hai%20_%20Rabb%20ka%20Rizq%20kon%20sa%20hai.mp4',
        title: 'Adipisicing asperior',
        poster: 'https://aimomn.s3.amazonaws.com/Ahmed-Isa/thumb/2020-11-20%20%28thumb%29%20Mann%20o%20Salwa%20kya%20hai%20_%20Rabb%20ka%20Rizq%20kon%20sa%20hai.jpg',

        quality: qualities,
    });
</script>

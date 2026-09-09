<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Game to Top</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 100px 20px;
            text-align: center;
        }

        h1 {
            font-size: 52px;
            margin-bottom: 15px;
        }

        p {
            font-size: 20px;
            color: #555;
        }

        .buttons {
            margin-top: 35px;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: #fff;
            background: #6d4aff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Game to Top</h1>

        <p>Nezini, ko šodien spēlēt?</p>


        <div class="buttons">
    <a class="button" href="{{ url('/random#meklet') }}">Meklēt spēles</a>
    <a class="button" href="{{ url('/random') }}">Random spēle</a>
</div>

    </div>

</body>

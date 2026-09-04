<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Random spēle - Game to Top</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 80px 20px;
            text-align: center;
        }

        h1 {
            font-size: 42px;
        }

        p {
            font-size: 20px;
            color: #555;
        }

        .filters {
            margin-top: 40px;
        }

        .filter {
            margin: 20px;
        }

        select {
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 15px 30px;
            margin-top: 30px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        a {
            display: inline-block;
            margin-top: 30px;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Random spēle</h1>

        <p>Izvēlies savus kritērijus un ļauj sistēmai izvēlēties spēli.</p>

        <div class="filters">

            <div class="filter">
                <label for="genre">Žanrs:</label>

                <select id="genre">
                    <option>Visi žanri</option>
                    <option>Action</option>
                    <option>Adventure</option>
                    <option>RPG</option>
                    <option>Strategy</option>
                </select>
            </div>

            <div class="filter">
                <label for="platform">Platforma:</label>

                <select id="platform">
                    <option>Visas platformas</option>
                    <option>PC</option>
                    <option>PlayStation</option>
                    <option>Xbox</option>
                    <option>Nintendo Switch</option>
                </select>
            </div>

            <div class="filter">
                <label for="year">Izdošanas periods:</label>

                <select id="year">
                    <option>Visi gadi</option>
                    <option>2000–2010</option>
                    <option>2010–2020</option>
                    <option>2020–2026</option>
                </select>
            </div>

        </div>

        <button>Izvēlēties random spēli</button>

        <br>

        <a href="/">← Atpakaļ uz sākumu</a>

    </div>

</body>
</html>
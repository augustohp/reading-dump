<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
        html, body {
            height: 100%;
        }
        body {
            background: linear-gradient(#7f8893, #25212b);
            background-color: black;
            background-repeat: no-repeat;
            background-size: auto;
        }
        .card {
            margin-top: 5em;
        }
        h1 {
            font-size: 2.2em;
        }
        </style>
    </head>
    <body>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

        <div class="container">
            <div class="row">
                <div class="col s12 m6 l6 offset-l3 offset-m3">
                    <?php require $template; ?>
                </div>
            </div>
        </div>
    </body>
</html>


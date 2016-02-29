<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">

                <form method='POST' action='/locate'>
                    <input name="_token" type="hidden">{!! csrf_field() !!}
                    <input type='hidden' id='lat' name='lat'>
                    <input type='hidden' id='lng' name='lng'> 
                    <input type='submit' value='Submit'>
                </form>

                <script>
                var lt = document.getElementById("lat");
                var ln = document.getElementById("lng");

                window.onload = function(){
                    getLocation();
                }

                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else { 
                        x.innerHTML = "Geolocation is not supported by this browser.";
                    }
                }

                function showPosition(position) {
                    document.getElementById("lat").value = position.coords.latitude;
                    document.getElementById("lng").value = position.coords.longitude;  
                }
                </script>
            </div>
        </div>
    </body>
</html>

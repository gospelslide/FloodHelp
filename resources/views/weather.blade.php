<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FloodHelp</title>

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">FloodRelief</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="page-scroll">
                        <a href="/locate">Help Me!</a>
                    </li>
                    <li class="page-scroll">
                        <a href="/find">Find People</a>
                    </li>
                    <li class="page-scroll">
                        <a href="/camps">Relief Camps</a>
                    </li>
                    <li class="page-scroll">
                        <a href="">Donate</a>
                    </li>
                    <li class="page-scroll">
                        <a href="/weather">Weather</a>
                    </li>
                    <li class="page-scroll">
                        <a href="/login">Agency</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- About Section -->
    <br>
    <br>
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Weather Updates</h2>
                    <hr class="star-light">
                    <?php
                        if(count($getWeather))
                            echo "<p>Weather for " . $getWeather['city'] . "</p>";
                        else
                            echo "<p>Select City</p>";
                    ?>
                    <form action="/weather" method="GET">
                    <select name="country" class="countries" id="countryId">
                    <option value="">Select Country</option>
                    </select>
                    <select name="state" class="states" id="stateId">
                    <option value="">Select State</option>
                    </select>
                    <select name="city" class="cities" id="cityId">
                    <option value="">Select City</option>
                    </select>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                    <script src="http://lab.iamrohit.in/js/location.js"></script>
                    <button type="submit" class="btn btn-success btn-sm">Get Weather</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <?php
                        if(count($getWeather))
                        {
                            echo "<h3>Current</h3>";
                            echo "<p>Current Temperature:".$getWeather[0][1]."&#8451;<br />";
                            echo "Min. Temperature:".$getWeather[0][2]."&#8451;<br />";
                            echo "Max. Temperature:".$getWeather[0][3]."&#8451;<br />";
                            echo "Humidity:".$getWeather[0][4]."%<br />";
                            echo "Weather:".$getWeather[0][0]."<br />";
                            echo "Updated At:".$getWeather[0][5]."<br /></p>";
                            echo "<hr>";
                        }
                    ?>
                </div>
                <div class="col-lg-4">
                    <?php
                        if(count($getWeather))
                        {
                            echo "<h3>Forecast</h3>";
                            $counter=0;
                            foreach($getWeather[1] as $key=>$value)
                            { 
                                if($counter<2)
                                {
                                    $counter++;
                                    continue;
                                }
                                echo "<p>Current Temperature:".$value[0]."&#8451;<br />";
                                echo "Min. Temperature:".$value[1]."&#8451;<br />";
                                echo "Max. Temperature:".$value[2]."&#8451;<br />";
                                echo "Humidity:".$value[3]."%<br />";
                                echo "Weather:".$value[4]."<br />";
                                echo "Time:".$value[5]."<br /></p>";
                                echo "<hr>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p>3481 Melrose Place<br>Beverly Hills, CA 90210</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>About Freelancer</h3>
                        <p>Freelance is a free to use, open source Bootstrap theme created by <a href="http://startbootstrap.com">Start Bootstrap</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Your Website 2014
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/freelancer.js"></script>

</body>

</html>

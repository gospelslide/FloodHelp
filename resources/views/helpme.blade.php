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
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
    function initialize() {
      var i;
      var data = <?php echo json_encode($contact['camps']); ?>;
      var userLat = <?php echo $contact['latitude']; ?>;
      var userLng = <?php echo $contact['longitude']; ?>;

      var mapProp1 = {
        center:new google.maps.LatLng(userLat,userLng),
        zoom:8,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
      var map=new google.maps.Map(document.getElementById("googleMap"), mapProp1);

      var myLatLng = {lat: userLat, lng: userLng};
       var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
        title: 'You are here'});

      for(i=0;i<data.length;i++)
      { 
       var myLatLng = {lat: data[i]['latitude'], lng: data[i]['longitude']};
       var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: data[i]['name']+'-'+data[i]['address']
      });
      }
      }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>

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
                        <a href="/donate">Donate</a>
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

    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text">
                        <span class="name">Find Immediate Help</span>
                        <hr class="star-light">
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Nearest Contacts</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 portfolio-item">
                    <div class="intro-text">
                        <h3>Hospitals</h3>
                            <?php
                                for($i=0; $i<5; $i++)
                                {
                                    if($i<count($contact['hospitals']['results']))
                                    {
                                        echo $contact['hospitals']['results'][$i]['name'];
                                        echo "<br>";
                                        echo $contact['hospitals']['results'][$i]['vicinity'];
                                        echo "<br><br>";
                                    }
                                    else
                                        break;
                                }
                            ?>
                    </div>
                    <div class="intro-text">
                        <h3>Police Stations</h3>
                            <?php
                                for($i=0; $i<5; $i++)
                                {
                                    if($i<count($contact['police']['results']))
                                    {
                                        echo $contact['police']['results'][$i]['name'];
                                        echo "<br>";
                                        echo $contact['police']['results'][$i]['vicinity'];
                                        echo "<br><br>";
                                    }
                                    else
                                        break;
                                }
                            ?>
                    </div>
                </div>
                <div class="col-sm-4 portfolio-item">

                </div>
                <div class="col-sm-4 portfolio-item">
                    <div class="intro-text">
                        <h3>Pharmacies</h3>
                            <?php
                                for($i=0; $i<5; $i++)
                                {
                                    if($i<count($contact['pharmacy']['results']))
                                    {
                                        echo $contact['pharmacy']['results'][$i]['name'];
                                        echo "<br>";
                                        echo $contact['pharmacy']['results'][$i]['vicinity'];
                                        echo "<br><br>";
                                    }
                                    else
                                        break;
                                }
                            ?>
                    </div>
                    <div class="intro-text">
                        <h3>Fire Stations</h3>
                            <?php
                                for($i=0; $i<5; $i++)
                                {
                                    if($i<count($contact['fire_station']['results']))
                                    {
                                        echo $contact['fire_station']['results'][$i]['name'];
                                        echo "<br>";
                                        echo $contact['fire_station']['results'][$i]['vicinity'];
                                        echo "<br><br>";
                                    }
                                    else 
                                        break;
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Relief Centres</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text">
                    <div id="googleMap" style="width:90vw;height:50vh;align:center"></div>       
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    @if(count($errors) > 0)
                        <div class="alert alert-success">
                        <ul>
                            <li>{!! $errors !!}</li>
                        </ul>
                    </div>
                    @endif
                    <h2>Add Information</h2>
                    <p>Provide details so your family and friends can find you.</p>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form name="sentMessage" action="/details" method="POST">
                    <input name="_token" type="hidden">{!! csrf_field() !!}
                    <input type='hidden' id='lat' name='lat' value="<?php echo $contact['latitude']; ?>">
                    <input type='hidden' id='lng' name='lng' value="<?php echo $contact['longitude']; ?>"> 
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name." name="name">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number." name="mobile">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Number Of People Stuck</label>
                                <input type="number" class="form-control" placeholder="Number Of People Stuck" id="no_of_people" name="no_of_people" name="no_of_people">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message." name="message"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                            <br>
                                <p>Location</p>
                                <p>Latitude: {!! $contact['latitude'] !!}</p>
                                <p>Longitude: {!! $contact['longitude'] !!}</p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-success btn-lg">Send</button>
                            </div>
                        </div>
                    </form>
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

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

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

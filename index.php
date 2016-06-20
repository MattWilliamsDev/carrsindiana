
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="favicon.ico">
    <title>CARRS | Collectible Auto Restoration and Repair Shop</title>
    <meta name="description" content="Collectible Auto Restoration and Repair Shop in Royal Center, Indiana.">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css"/>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bs-form-template.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body ng-app="app">

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img src="logo.png" alt="CARRS - Collectible Auto Restoration and Repair Shop" />
                </a>
            </div>
            <div class="pull-right shop-info">
                <address>
                    <strong>Collectible Auto Restoration and Repair Shop</strong><br>
                    5475 W Co Rd 250 N<br>
                    Royal Center, IN 46978<br>
                    Phone: (574) 643-6206
                </address>
            </div>
            <!-- <div id="navbar" class="collapse navbar-collapse"> -->
                <!-- <ul class="nav navbar-nav"> -->
                    <!-- <li class="active"><a href="#">Home</a></li> -->
                    <!-- <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li> -->
                <!-- </ul> -->
            <!-- </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container" ng-controller="FormController">
        <div class="row">
            <div class="col-md-12">
                <p class="lead">
                    The website is currently undergoing some maintenance, but you can still contact the shop by filling out the form below.  Once we receive your submission, we will reach out to you to see how we can meet your needs.
                </p>
            </div>
            <div class="col-md-12">
                <div id="contact-form">
                    <form ng-submit="submit()" ng-hide="submitted">
                        <div class="form-group">
                            <label for="full-name">Full Name</label>
                            <input type="text" class="form-control" id="full-name" placeholder="Full Name" ng-model="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" ng-model="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone #</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Phone #" ng-model="phone">
                        </div>
                        <div class="form-group">
                            <label for="questions-comments">Questions/Comments</label>
                            <textarea class="form-control" name="questions-comments" id="questions-comments" placeholder="Questions/Comments" ng-model="comments"></textarea>
                        </div>
                        <button type="submit" id="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
                <div id="form-submitted" ng-show="submitted">
                    <p>Your submission has been sent. Thank you!</p>
                </div>
            </div>
        </div>
    </div>

    <script src="bower_components/jquery/dist/jquery.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>

    <script>
        var app = angular.module( 'app', [] )
            .controller( 'FormController', function( $scope ) {

                $scope.name = '';
                $scope.email = '';
                $scope.phone = '';
                $scope.comments = '';
                $scope.submitted = false;

                $scope.submit = function() {
                    var data = {
                        name: $scope.name
                        , email: $scope.email
                        , phone: $scope.phone
                        , comments: $scope.comments
                    };
                    console.log( 'posting data', data );
                    $.post( 'form-submit.php', data, function( response ) {
                        $scope.$apply( function() {
                            $scope.submitted = true;
                        });
                        console.log( 'form submit response', response );
                    }, function ( e ) {
                        console.error( 'form submit error', e );
                    });
                };
            });
    </script>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>

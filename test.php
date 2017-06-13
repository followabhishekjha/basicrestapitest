<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>REST API Test</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" style="color:#ffffff;">REST API Test</a>
        </div>
      </div>
    </nav>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-6">
          <h2>Input form:</h2>
          <form>
			<div class="form-group">
				<select name="method" class="form-control">
					<option value="GET">GET</option>
					<option value="PUT">PUT</option>
					<option value="DELETE">DELETE</option>
				</select>
			</div>
			<div class="form-group">
				<textarea type="text" id="query" class="form-control">products</textarea>
			</div>
			<div class="form-group">
				<input type="submit" class="form-control btn-primary"/>
			</div>
			*POST queries will not work in this form, all others will work fine.
			<!--POST variables: 
			<input type="text" name="token" placeholder="token"/>
			<input type="text" name="name" placeholder="Product name/ User name"/>
			<input type="text" name="pass" placeholder="Password"/>-->
			<br/>
			<br/>
		</form>
		
        </div>
        <div class="col-md-6">
          <h2>Output:</h2>
          <div name="resWin" style="min-height:300px;max-height:300px;background-color:#E7E7E7;color:#000000;padding:7px;overflow-y:scroll;">
			Try me!<br/>
		</div>
       </div>
      </div>
      <hr style="background-color:#337ab7;height:2px;">
	  <div class="col-md-12">
		<h2>Documentation:</h2>
		<h3>1. Authentication:</h3>
		<p>To run operations like edit, update and delete we will need to first authenticate the user and receive a security token.</p>
		<p><strong>Request type: POST</strong></p>
		<div class="row">
			<div class="col-md-6">
			<strong>Parameter-list: name, pass</strong><br/>
			<strong>Example URL: restapi/user?name=a&amp;pass=b</strong><br/>
			</div>
			<div class="col-md-6">
			<strong>Sample response (Successfull):</strong>
			<pre>
{
	"token": "abcd"
}
			</pre><br/>
			<strong>Sample response (Missing/Extra parameters in query):</strong>
			<pre>
{
	"error": {
		"message": "Missing/extra parameters"
	}
}			</pre>
			</div>
		</div>
	  </div>

	  <div class="col-md-12">
		<h3>2. Retrieve products:</h3>
		<p>You can retrieve all products at once or retrieve just one product (as per requirement).</p>
		<p><strong>Request type: GET</strong></p>
		<div class="row">
			<div class="col-md-6">
				<strong>2.1. Example URL: product</strong><br/>
				<strong>2.2. Example URL: product?id=1</strong><br/>
			</div>
			<div class="col-md-6">
			<strong>Sample response (All products):</strong>
			<pre>
{
    "list": [
        {
            "id": 1,
            "name": "Shampoo"
        },
        {
            "id": 2,
            "name": "Soap"
        },
        {
            "id": 7,
            "name": "abcd"
        },
        {
            "id": 8,
            "name": "Milk"
        }
    ]
}
			</pre><br/>
			<strong>Sample response (One product):</strong>
			<pre>
{
    "list": [
        {
            "id": 1,
            "name": "Shampoo"
        }
    ]
}
			</pre>
			</div>
		</div>
	  </div>

	  <div class="col-md-12">
		<h3>3. Update products:</h3>
		<p>This type of query is used to update a product.</p>
		<p><strong>Request type: PUT</strong></p>
		<div class="row">
			<div class="col-md-6">
				<strong>Example URL: product?token=12345&id=1&name=someName</strong><br/>
			</div>
			<div class="col-md-6">
			<strong>Sample response (Successfull):</strong>
			<pre>
{
    "list": [
        {
            "id": 1,
            "name": "Shampoo"
        },
        {
            "id": 2,
            "name": "Soap"
        },
        {
            "id": 7,
            "name": "abcd"
        },
        {
            "id": 8,
            "name": "Milk"
        }
    ]
}
			</pre><br/>
			<strong>Sample response (One product):</strong>
			<pre>
{
    "list": [
        {
            "id": 1,
            "name": "Shampoo"
        }
    ]
}
			</pre>
			</div>
		</div>
	  </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
	<script>
	$(document).ready(function(){
		//alert("Loaded and working!");
		$('form').submit(function(event){
			event.preventDefault();
			$.ajax({
				//url: '/restapi/products',
				url: $("#query").val(),
				type: $("[name='method']").val(),
				//data:{name:'a','token':'abcd'},
				//data:{name:'a','pass':'abcd'},
				success: function(result) {
					// Do something with the result
					//$("[name='resWin']").html(JSON.stringify(result,null,4));
					$("[name='resWin']").html("<pre>"+result+"</pre>");
				}
			});
		});
	});
	</script>
	
  </body>
</html>

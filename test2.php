<html>
	<head>
		<title>
			REST API Test
		</title>
	</head>
	<body>
		<h1>REST API TEST</h1>
		<form>
			<select name="method">
				<option value="GET">GET</option>
				<option value="POST">POST</option>
				<option value="PUT">PUT</option>
				<option value="DELETE">DELETE</option>
			</select>
			<br/>
			<br/>
			<textarea type="text" id="query" rows="6" cols="100">products</textarea>
			<br/>
			<br/>
			<br/>
			<input type="submit"/>
		</form>
		<h2>Output window</h2>
		<div name="resWin" style="min-width:100%;min-height:100%;max-height:100%;background-color:#454545;color:#ffffff;padding:7px;overflow-y:scroll;">
			Try me!<br/>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
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
					//alert(result);
					//console.log(result);
					$("[name='resWin']").html("<pre>"+JSON.stringify(result,null,4)+"</pre>");
				},
				dataType:"json"
			});
		});
	});
	</script>
</html>
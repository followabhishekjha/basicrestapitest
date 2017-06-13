<?php
require_once("config.php");
require_once("db_model.php");

session_start();

$arr=array('request_uri'=>$_SERVER['REQUEST_URI'],'status'=>200,'request_method'=>$_SERVER['REQUEST_METHOD']);

$method=$_SERVER['REQUEST_METHOD'];

$uriString=explode("/",$_SERVER['REDIRECT_URL']);
$output=array();
if($_SERVER['REQUEST_METHOD']=="POST"&&strtolower($uriString[2])=="user")
{
	if(isset($uriString[3])&&strtolower($uriString[3])=="logout")
	{
		session_destroy();
		http_response_code(200);
		$output['message']="Logout successfull";
	}
	else
		if((count($_POST)==2)&&isset($_POST['name'])&&!empty($_POST['name'])&&isset($_POST['pass'])&&!empty($_POST['pass']))
		{
			$login=check_login($_POST['name'],$_POST['pass']);
			if($login===false)
			{
				//Login failed
				$error['message']="Invalid credentials";
			}
			else
			{
				//Login completed
				$_SESSION['token']=$login;
				$output['token']=$_SESSION['token'];
			}
		}
		else
		{
			http_response_code(400);
			$error['message']="Missing/extra parameters";
		}
		if(isset($error))
		{
			$output['error']=$error;
		}
}
else
	if($_SERVER['REQUEST_METHOD']=="GET"&&strtolower($uriString[2])=="products")
	{
		if(isset($_GET['token'])&&!empty($_GET['token']))
		{
			$auth=verifyUser($_GET['token']);
			if($auth===true)
			{
				if(count($_GET)==1)
				{
					//Show all products
					$output=readProduct(-1);
				}
				else
					if(count($_GET)==2&&isset($_GET['id'])&&!empty($_GET['id']))
						$output=readProduct($_GET['id']);
					else
						if(empty($_GET['id']))
						{
							$error['message']="Missing/extra parameters";
							http_response_code(400);
						}
						else
						{
							$error['message']="Malformed URL";
							http_response_code(400);
						}
				if(isset($error))
				{
					$output['error']=$error;
				}
			}
			else
			{
				http_response_code(401);
				$output['error']=$auth;
			}
		}
		else
		{
			$error['message']="Missing authentication token";
			http_response_code(400);
		}
		if(isset($error))
		{
			$output['error']=$error;
		}

	}
	else
		if($_SERVER['REQUEST_METHOD']=="POST"&&strtolower($uriString[2])=="products")
		{
			//var_dump($_POST);
			if(isset($_POST['token'])&&!empty($_POST['token']))
			{
				$auth=verifyUser($_POST['token']);
				//var_dump($auth);
				if($auth===true)
				{
					if(count($_POST)!=2)
					{
						http_response_code(400);
						$error['message']="Missing/extra parameters";
					}
					else
						if(count($_POST)==2&&isset($_POST['name'])&&!empty($_POST['name']))
							$output=createProduct($_POST['name']);
						else
						{
							$error['message']="Missing/extra parameters";
							http_response_code(400);
						}
				}
				else
				{
					http_response_code(401);
					$output['error']=$auth;
				}
			}
			else
			{
				$error['message']="Missing authentication token";
				http_response_code(400);
			}
			if(isset($error))
			{
				$output['error']=$error;
			}
		}
		else
			if($_SERVER['REQUEST_METHOD']=="PUT"&&strtolower($uriString[2])=="products")
			{
				//echo "Here";
				$_PUT=$_GET;
				//var_dump($_PUT);
				//echo"<br/>".var_dump(count($_PUT)==3).", ".var_dump(isset($_PUT['id']))." ,".var_dump(!empty($_POST['id']))." ,".var_dump(isset($_PUT['name']))." ,".var_dump(!empty($_POST['name']));
				//var_dump($_GET);
				if(isset($_PUT['token'])&&!empty($_PUT['token']))
				{
					$auth=verifyUser($_PUT['token']);
					
					if($auth===true)
					{
						if(count($_PUT)!=3)
						{
							http_response_code(400);
							$error['message']="Missing/extra parameters";
						}
						else
							if(count($_PUT)==3&&isset($_PUT['id'])&&!empty($_PUT['id'])&&isset($_PUT['name'])&&!empty($_PUT['name']))
								$output=updateProduct($_PUT['id'],$_PUT['name']);
							else
							{
								$error['message']="Missing/extra parameters";
								http_response_code(400);
							}
					}
					else
					{
						$output['error']=$auth;
						http_response_code(401);
					}
				}
				else
				{
					$error['message']="Missing authentication token";
					http_response_code(400);
				}
				if(isset($error))
				{
					$output['error']=$error;
				}
			}
			else
				if($_SERVER['REQUEST_METHOD']=="DELETE"&&strtolower($uriString[2])=="products")
				{
					$_DELETE=$_GET;
					//var_dump($_DELETE);
					//echo"<br/>".var_dump(count($_DELETE)==3).", ".var_dump(isset($_DELETE['id']))." ,".var_dump(!empty($_POST['id']))." ,".var_dump(isset($_DELETE['name']))." ,".var_dump(!empty($_POST['name']));
					if(isset($_DELETE['token'])&&!empty($_DELETE['token']))
					{
						$auth=verifyUser($_DELETE['token']);
						if($auth===true)
						{
							if(count($_DELETE)!=2)
							{
								$error['message']="Missing/extra parameters";
								http_response_code(400);
							}
							else
								if(count($_DELETE)==2&&isset($_DELETE['id'])&&!empty($_DELETE['id']))
									$output=deleteProduct($_DELETE['id']);
								else
								{
									$error['message']="Missing/extra parameters";
									http_response_code(400);
								}
						}
						else
						{
							http_response_code(401);
							$output['error']=$auth;
						}
					}
					else
					{
						$error['message']="Missing authentication token";
						http_response_code(400);
					}
					if(isset($error))
					{
						$output['error']=$error;
					}
				}
				else
					if($_SERVER['REQUEST_METHOD']=="GET"&&strtolower($uriString[2])=="search")
					{
						if(isset($_GET['token'])&&!empty($_GET['token']))
						{
							$auth=verifyUser($_GET['token']);
							if($auth===true)
							{
								if(count($_GET)==1)
									$output=getSearchProduct("");
								else
									if(count($_GET)==2&&isset($_GET['s']))
										$output=getSearchProduct($_GET['s']);
									else
									{
										$error['message']="Malformed URL";
										http_response_code(400);
									}
								if(isset($error))
								{
									$output['error']=$error;
								}
							}
							else
							{
								http_response_code(401);
								$output['error']=$auth;
							}
						}
						else
						{
							$error['message']="Missing authentication token";
							http_response_code(400);
						}
						if(isset($error))
						{
							$output['error']=$error;
						}
					}

	//header('Content-type: application/json');
	echo json_encode($output, JSON_PRETTY_PRINT);
	//var_dump($output);

function readProduct($id){
	$conn=dbConnect();
	if($id==-1)
	{
		//$output['status']="Showing all products";
		$output['list']=getProducts($conn,$id);
	}	
	else
		$output['list']=getProducts($conn,$id);
	$conn->close();
	return $output;
}

function getSearchProduct($name){
	$conn=dbConnect();
	$output['list']=searchProducts($conn,$name);
	$conn->close();
	return $output;
}

function verifyUser($token)
{
	//return true;
	//var_dump($token);
	if(isset($_SESSION['token'])&&$_SESSION['token']==$token)
		return true;
	else
		return $error['message']="Invalid security token";
}

function updateProduct($id,$name)
{
	$conn=dbConnect();
	$output['status']=editProduct($conn,$id,$name);
	$conn->close();
	return $output;
}

function createProduct($name)
{
	$conn=dbConnect();
	$output['status']=addProduct($conn,$name);
	$conn->close();
	return $output;
}

function deleteProduct($id)
{
	$conn=dbConnect();
	$output['status']=delProduct($conn,$id);
	$conn->close();
	return $output;
}

/*function check_login($name,$pass)
{
	return 'abcd';
}*/
?>
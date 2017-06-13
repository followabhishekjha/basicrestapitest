<?php
require_once("config.php");

function dbConnect(){
	$conn = new mysqli(HOST, USER, PWD, DATABASE); // Creating connection
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	return $conn;
}

function dbClose($conn){
	$conn->close();
}

function getProducts($conn,$id){
	if($id==-1)
	{
		$sql = $conn->prepare("SELECT pid, pname FROM products");
		$sql->execute();
		$sql->bind_result($pid,$pname);
		$sql=$sql->get_result();
		$productList=array();
		if ($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$productList[]=array('id'=>$row["pid"],'name'=>$row["pname"]);
			}
			//var_dump($productList);
			http_response_code(200);
			return $productList;
		} else {
			http_response_code(200);
			$output['message']="0 results";
			return $output;
		}
	}
	else
	{
		$sql = $conn->prepare("SELECT pid, pname FROM products where pid=?");
		$sql->bind_param('i',$id);
		$sql->execute();
		$sql->bind_result($pid,$pname);
		$sql=$sql->get_result();
		$productList=array();
		if ($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$productList[]=array('id'=>$row["pid"],'name'=>$row["pname"]);
			}
			http_response_code(200);
			return $productList;
		} else {
			http_response_code(200);
			$output['message']="0 results";
			return $output;
		}
	}
}

function addProduct($conn,$name){
	$sql = $conn->prepare("Insert into products(`pname`) values(?)") or die($conn->errno.", ".$conn->error);
	$sql->bind_param('s',$name);
	if($sql->execute())
	{
		http_response_code(201);
		$output['message']="Record created successfully!";
	}
	else
	{
		http_response_code(501);
		$output['message']="Failed to create product!";
	}	
	return $output;
}

function editProduct($conn,$id,$name){
	//Searching if the product exists in first place
	$sql = $conn->prepare("SELECT pid, pname FROM products where pid=?");
	$sql->bind_param('i',$id);
	$sql->execute();
	$sql->bind_result($pid,$pname);
	$sql=$sql->get_result();
	if ($sql->num_rows > 0) {
		$sql = $conn->prepare("Update products set `pname`=? where `pid`=?") or die($conn->errno.", ".$conn->error);
		$sql->bind_param('si',$name,$id);
		if($sql->execute())
		{
			http_response_code(200);
			$output['message']="Record updated successfully!";
		}
		else
		{
			http_response_code(501);
			$output['message']="Failed to update product!";
		}
	}
	else
	{
		//Not found
		http_response_code(200);
		$output['message']="No such product found!";
	}


	return $output;
}

function delProduct($conn,$id){
	$sql = $conn->prepare("SELECT pid, pname FROM products where pid=?");
	$sql->bind_param('i',$id);
	$sql->execute();
	$sql->bind_result($pid,$pname);
	$sql=$sql->get_result();
	if ($sql->num_rows > 0) {
		$sql = $conn->prepare("delete from products where `pid`=?") or die($conn->errno.", ".$conn->error);
		$sql->bind_param('i',$id);
		if($sql->execute())
		{
			$output['message']="Record deleted successfully!";
			http_response_code(200);
		}
		else
		{
			$output['message']="Failed to delete product!";
			http_response_code(501);
		}
	}
	else
	{
		$output['message']="No such product found!";
		http_response_code(200);
	}
	return $output;
}

function check_login($name,$pass){
	$conn=dbConnect();
	$sql = $conn->prepare("SELECT u_pass, u_name FROM users where u_name=? and u_pass=?");
	$pass=md5($pass);
	$sql->bind_param('ss',$name,$pass);
	$sql->execute();
	$sql->bind_result($pid,$pname);
	$sql=$sql->get_result();
	if ($sql->num_rows > 0) {
		//$output['token']=md5(time());
		//echo "Success!";
		http_response_code(200);
		return md5(time());
	}
	else
	{
		http_response_code(401);
		return false;
	}
}
//check_login(null,'admin','admin');

function searchProducts($conn,$name){
	//$conn=dbConnect();
	if(empty($name))
	{
		return getProducts($conn,-1);
	}
	else
	{
		$sql = $conn->prepare("Select * from products where Concat(pid, '', pname) like ?") or die($conn->error);
		$name="%".$name."%";
		$sql->bind_param('s',$name);
		$sql->execute();
		$sql->bind_result($pid,$pname);
		$sql=$sql->get_result();
		$productList=array();
		if ($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$productList[]=array('id'=>$row["pid"],'name'=>$row["pname"]);
			}
			http_response_code(200);
			return $productList;
			//var_dump($productList);
		} else {
			http_response_code(200);
			$output['message']="0 results";
			return $output;
			//var_dump($output);
		}

	}	
}

//searchProducts(null,"a");
?>
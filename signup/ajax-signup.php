<?php

	header('Content-type: application/json');

	require_once 'config.php'; 
	
	$response = array();

	if ($_POST) {
		
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$tel = trim($_POST['tel']);
		$curso = trim($_POST['curso']);
		$genero = trim($_POST['genero']);
		//$pass = trim($_POST['cpassword']);
		
		$full_name = strip_tags($name);
		$user_email = strip_tags($email);
		$user_tel = strip_tags($tel);
		$user_curso = strip_tags($curso);
		$user_genero = strip_tags($genero);
		
		// sha256 password hashing
		//$hashed_password = hash('sha256', $user_pass);
		
		$query = "INSERT INTO users(nome,email,tel, curso, genero) VALUES(:name, :email, :tel, :curso, :genero)";
		
		$stmt = $DBcon->prepare( $query );
		$stmt->bindParam(':name', $full_name);
		$stmt->bindParam(':email', $user_email);
		$stmt->bindParam(':tel', $user_tel);
		$stmt->bindParam(':curso', $user_curso);
		$stmt->bindParam(':genero', $user_genero);
		
		// check for successfull registration
        if ( $stmt->execute() ) {
			$response['status'] = 'success';
			$response['message'] = '<span class="glyphicon glyphicon-ok"></span> &nbsp; A sua candidatura foi recebida, entraremos em contacto via email';
        } else {
            $response['status'] = 'error'; // could not register
			$response['message'] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp;  A sua candidatura não foi processada, entre em contacto connosco';
        }	
	}
	
	echo json_encode($response);
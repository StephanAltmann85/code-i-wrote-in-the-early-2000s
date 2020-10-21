<?php
// ************************************************************************************//
// * WoltLab Burning Board 2
// ************************************************************************************//
// * Copyright (c) 2001-2004 WoltLab GmbH
// * Web           http://www.woltlab.de/
// * License       http://www.woltlab.de/products/burning_board/license_en.php
// *               http://www.woltlab.de/products/burning_board/license.php
// ************************************************************************************//
// * WoltLab Burning Board 2 is NOT free software.
// * You may not redistribute this package or any of it's files.
// ************************************************************************************//
// * $Date: 2004-10-20 13:24:57 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1453 $
// ************************************************************************************//


// For infos on the Simple Mail Transfer Protokol (SMTP) read RFC 821, 822,
// 2821. This Class implements only the needed specifications for sending a
// plain text mail. More functions may come... or may not!


//	example:
//	$mail = new smtp_socket ();
//	//             TO                   SUBJECT         MESSAGE        FROM                 ADDITIONAL HEADER
//	$mail->mail ( 'woltlab@woltlab.de', 'subject', "blah\nmore blah", 'woltlab@woltlab.de', ';Content-Transfer-Encoding: 8bit;X-Priority: 3' );
//	$mail->disconnect ();

class smtp_socket {
	var $connection = stream;
	var $error_code = '';
	var $error_msg  = '';
	var $debug = false;
	var $error_reporting = false;
	var $connected = false;
	var $smtp_server = Array (	'host' => '',					// SMTP - Server
					'port'     => '25',				// SMTP - Server - Port (Default 25)
					'use_auth' => true,				// Use SMTP Auth?
					'user'     => '',				// Login
					'pass'     => '',				// Password
					'timeout'  => 15 );				// Socket Timeout
	
	var $error = Array (		'not_connected'       => 1,		// Error - Codes the class will return.
					'cant_connect'        => 2,		// If everything is ok, you gat a
					'connection_error'    => 3,		// true as return - value.
					'auth_not_supported'  => 4,
					'unknown_username'    => 5,
					'password_incorrect'  => 6,
					'wrong_from_format'   => 7,
					'wrong_to_format'     => 8,
					'error_while_sending' => 9 );
	
	
	function smtp_socket() {
		global $smtp, $smtp_use_auth, $smtp_user, $smtp_pass;
		// Init...
		$this->smtp_server['host'] = $smtp;
		$this->smtp_server['use_auth'] = $smtp_use_auth;
		if ($this->smtp_server['use_auth']) {
			if ($smtp_user == '' || $smtp_pass == '')
			return false;
			$this->smtp_server['user'] = $smtp_user;
			$this->smtp_server['pass'] = $smtp_pass;
		}
		
		if ($this->debug) {
			$this->debug_fp = @fopen('smtp.log', 'ab');
			
			fwrite ($this->debug_fp,"--=:[ New Class created - ");
			
			if ($this->smtp_server['use_auth']) {
				fwrite($this->debug_fp, 'smtp://'.$this->smtp_server['user'].':'.$this->smtp_server['pass'].'@'.$this->smtp_server['host'].':'.$this->smtp_server['port']);
			} else {
				fwrite($this->debug_fp, 'smtp://'.$this->smtp_server['host'].':'.$this->smtp_server['port']);
			}
			
			fwrite($this->debug_fp, "]:=--\n");
		}
		
		return true;
	}
	
	function connect() {
		$connection = @fsockopen($this->smtp_server['host'],			// Connect it baby... ; )
		$this->smtp_server['port'],
		$this->error_code,
		$this->error_msg,
		$this->smtp_server['timeout']);
		
		if (empty($connection)) {
			$this->trigger_error('cant_connect');
		}
		
		$this->connected  = true;
		$this->connection = $connection;
		$this->read_socket();
		
		socket_set_timeout($this->connection, $this->smtp_server['timeout'], 0);	// Needed on localhost...
		// Have to test performance on a server!
		
		// Init Connection
		$this->write_socket("EHLO");		// Extended Hello first...
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 250) {
			$this->write_socket("HELO");	// Normal Hello if extended fails...
			$temp = $this->read_socket();
			
			$this->make_smtperror($temp);
			if ($this->error_code != 250) {
				$this->trigger_error('connection_error');
			}
		}
		
		return true;
	}
	
	function auth() {
		if (!$this->connected) {
			$this->trigger_error('not_connected');
		}
		
		// Init Authentication
		$this->write_socket("AUTH LOGIN");
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 334) {
			$this->trigger_error('auth_not_supported');
		}
		
		// Send User
		$this->write_socket(base64_encode($this->smtp_server['user']));
		$temp = $this->read_socket();
		
		$this->make_smtperror ($temp);
		if ($this->error_code != 334) {
			$this->trigger_error('unknown_username');
		}
		
		// Send Pass
		$this->write_socket(base64_encode($this->smtp_server['pass']));
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 235) {
			$this->trigger_error('password_incorrect');
		}
		
		return true;
	}
	
	function mail($email, $subject, $text, $sender = "", $other = "" ) {
		global $boardversion;
		
		if (!$this->connected)
		if (!$this->connect()) {
			$this->trigger_error('not_connected');
		}
		if ($this->smtp_server['use_auth']) {
			$temp = $this->auth ();
			if (!$temp)
			return $temp;
		}
		
		if ($this->debug)
		fwrite($this->debug_fp, "--=:[ New Mail - [$email] [$subject] [$text] [$sender] [$other] ]:=-\n");
		
		$sender = preg_replace('/from:(.*)/si', "\\1", $sender);
		if ($sender == '' || $sender == ' ') {
			global $webmastermail;
			$sender = $webmastermail;
		}
		
		// Init Mail
		$this->write_socket("MAIL FROM:$sender");
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 250) {
			$this->trigger_error('wrong_from_format');
		}
		
		// TO
		$this->write_socket("RCPT TO:<$email>");
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 250 && $this->error_code != 251) {
			$this->trigger_error('wrong_to_format');
		}
		
		// Mail Data - Init
		$this->write_socket("DATA");
		$temp = $this->read_socket();
		
		// Mail Data - Header
		$this->write_socket("TO: $email");
		$this->write_socket("SUBJECT: $subject");
		$this->write_socket("X-Mailer: wBB $boardversion");
		
		$other = explode("\n", $other);
		foreach ($other as $entry) {
			if ($entry == '') continue;
			$this->write_socket($entry);
		}
		
		$this->write_socket("");
		
		// Mail Data - Body
		$this->write_socket("$text");
		
		// Mail Data - End here
		$this->write_socket(".");
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 250) {
			$this->trigger_error('error_while_sending');
		}
	}
	
	function reset() {
		// Reset Mail - Server - Input - Que
		if (!$this->connected) {
			$this->trigger_error('not_connected');
		}
		
		$this->write_socket("RSET");
		$temp = $this->read_socket();
		
		$this->make_smtperror($temp);
		if ($this->error_code != 250) {
			$this->make_smtperror($temp);
			$this->trigger_error('error_while_sending');
		}
	}
	
	function disconnect() {
		// Disconnect
		if (!$this->connected) {
			$this->trigger_error('not_connected');
		}
		
		$this->write_socket("QUIT");
		$temp = $this->read_socket();
		
		@fclose ($this->connection);
		$this->connected = false;
		
		if ($this->debug)
		fclose($this->debug_fp);
		
		return true;
	}
	
	
	
	
	// Locale functions, for internal use only...
	function make_smtperror($data) {
		$this->error_code = intval(wbb_substr($data, 0, 3));
		$this->error_msg  = wbb_substr($data, 4);
	}
	
	function read_socket() {
		$ret = '';
		while ($read = fgets($this->connection, 515)) {
			$ret .= $read;
			if ($this->debug)
			fwrite($this->debug_fp, '< '.$read);
			if (wbb_substr($read, 3, 1) == " ")
			break;
		}
		return $ret;
	}
	
	function write_socket($data) {
		fputs($this->connection, $data."\r\n");
		if ($this->debug)
		fwrite($this->debug_fp, '> '.$data."\r\n");
	}
	
	function trigger_error($error_msg, $error_type = E_USER_WARNING) {
		if ($this->error_reporting) trigger_error("SMTP error: $error_msg", $error_type);
		return $this->error[$error_msg];
	}
}
?>
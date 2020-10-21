/**
* encrypts the login form using an challenge-and-response protocol
*/
function encryptlogin(form)
{
	var status=form.crypted.value;
	
	if(status=='true')
	{
		var authentificationcode = form.authentificationcode.value;
		var password = form.l_password.value;
		authentificationcode = SHA1(SHA1(authentificationcode)+SHA1(password));
	
		form.l_password.value='';
		form.crypted.value='true';
		form.authentificationcode.value=authentificationcode;
	}
	return true;
}




/**
* activates or deactivates form encryption
*/
function activate_loginencryption(form)
{
	var status = form.crypted.value;

	// activate
	if(status=='false' && form.authentificationcode.value!='')
	{
		form.crypted.value='true';
		form.activateencryption.checked=true;
	}
	// deactivate
	else
	{
		form.crypted.value='false';
		form.activateencryption.checked=false;
	}
}
<?php
namespace App\Services;

use DB;
use Exception;
use Log;

class LdapService
{
	//$json = array("debug"=>"", "error_code"=>"");
	
	//$message = array();
	//$message_css = "";
		
	public function __construct()
	{
		Log::info("RegmhsbaruService");
		//DB::table("mahasiswa");
		//Auth::user();
	}
	public static function random_str(
	    $length,
	    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
	    ) {
	        $str = '';
	        $max = mb_strlen($keyspace, '8bit') - 1;
	        if ($max < 1) {
	            throw new Exception('$keyspace must be at least two characters long');
	        }
	        for ($i = 0; $i < $length; ++$i) {
	            $str .= $keyspace[random_int(0, $max)];
	        }
	        return $str;
	}
	public static function make_ssha_password($password){
		mt_srand((double)microtime()*1000000);
		$salt = pack("CCCC", mt_rand(), mt_rand(), mt_rand(), mt_rand());
		$hash = "{SSHA}" . base64_encode(pack("H*", sha1($password . $salt)) . $salt);
		return $hash;
	}
	public static function ssha_password_verify($hash, $password){
		// Verify SSHA hash
		$ohash = base64_decode(substr($hash, 6));
		$osalt = substr($ohash, 20);
		$ohash = substr($ohash, 0, 20);
		$nhash = pack("H*", sha1($password . $osalt));
		if ($ohash == $nhash) {
			return True;
		} else {
			return False;
		}
	}
	function password_valid_new($pemakai,$sandi,$namapemakai,$sandipemakai)
	{
		/*if( (strtoupper($pemakai) == strtoupper($namapemakai)) and ($sandi == $sandipemakai) )
		 return TRUE;
		 return FALSE;
		 */
		###LDAP
		$result = ldap_authenticate($pemakai, $sandi) ;
	
		if ( $result == NULL)
		{
			echo "<!-- gagal -->\n";
	
			$hasil = false;
		}
		else
		{
			echo "<!-- sukses-->\n";
	
			$hasil = true;
		}
		return $hasil;
			
		###END LDAP
	
	}
	public static function ldapEscape($string, $dn = null)
	{
		$escapeDn = array('\\', '*', '(', ')', "\x00");
		$escape   = array('\\', ',', '=', '+', '<', '>', ';', '"', '#');
	
		$search = array();
		if ($dn === null) {
			$search = array_merge($search, $escapeDn, $escape);
		} elseif ($dn === false) {
			$search = array_merge($search, $escape);
		} else {
			$search = array_merge($search, $escapeDn);
		}
	
		$replace = array();
		foreach ($search as $char) {
			$replace[] = sprintf('\\%02x', ord($char));
		}
	
		return str_replace($search, $replace, $string);
	}
	function ldap_authenticate($PHP_AUTH_USER, $PHP_AUTH_PW) {
		 
		global $json;
		//die ("user: $PHP_AUTH_USER password $PHP_AUTH_PW \n");
		if ($PHP_AUTH_USER != "" && $PHP_AUTH_PW != "") {
			$ds=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT'));
			$r = ldap_search( $ds, env('LDAP_BASEDN'), 'uid=' . LdapService::ldapEscape($PHP_AUTH_USER));
			if ($r) {
				$json["debug"] .= "get_entries\n";
					
				$result = ldap_get_entries( $ds, $r);
				#print_r($result);
				$json["debug"] .= "getresult\n";
				if ( $result["count"] >0)
				{
					#print_r($result);
					if ($result[0]) {
						ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
						if (ldap_bind( $ds, $result[0]['dn'], $PHP_AUTH_PW) ) {
							$attributes = array('members');
							$grp = ldap_read($ds, $result[0]['dn'], "(memberof={groups})", $attributes);
							if ($result === FALSE) {
								error_log("<!--grp false-->\n");
							}
							else
							{
								$entries = ldap_get_entries($ds, $grp);
								error_log("<!--grp:" . print_r($entries, true). "-->\n");
							}
								
							return $result[0];
							 
						}
					}
				}
				else
				{
					$json["debug"] .="count=0";
				}
			}
		}
		return NULL;
	}
	
	function changeUserPassword($username, $newPassword, $newPasswordCnf)
	{
		$ldap=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT'));
		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!$ldap)
		{
			trigger_error("error ldap connect"	);
		}
		$adminBind= ldap_bind($ldap, env('LDAP_ADMUSER'), env("LDAP_ADMPASS"));
		if (!$adminBind)
		{
			trigger_error("error ldap adminBind");
		}
		if ($newPassword != $newPasswordCnf ) {
			$message["error_code"] = 102;
			$message["error_message"] = "Error E102 - Sandi baru dengan sandi konfirmasi tidak sama!";
			return $message;
		}
		$data = array();
		#echo "echo newPassword: $newPassword\n";
		#$encoded_newPassword = "{SHA}" . base64_encode( pack( "H*", sha1( $newPassword ) ) );
		$encoded_newPassword = $this->make_ssha_password($newPassword);
		$data["userPassword"] = "$encoded_newPassword";
	
		if($adminBind) {
			$r = ldap_search( $ldap, env('LDAP_BASEDN'), 'uid=' . $this->ldapEscape($username));
			if ($r)
			{
				$result = ldap_get_entries( $ldap, $r);
			}
			else{
				//die("ldap_search_error");
				$message["error_code"] = 105;
				$message["error_message"] = "Pencarian User gagal";
				return $message;
			}
			if (!$result[0]){
				#die("error result[0] kosong");
				$message["error_code"] = 106;
				$message["error_message"] = "User tidak ditemukan";
				return $message;
			}
			#$modify = ldap_modify($ldap, "uid=$username," . "dc=unja,dc=ac,dc=id", $data);
			#$result[0]['dn']
			$modify = ldap_modify($ldap, $result[0]['dn'], $data);
			if(!$modify) {
				$error = ldap_errno($ldap) . ": " . ldap_error($ldap);
				trigger_error($error);
					
				$message["error_code"] = 105;
				$message["error_message"] = "System Error";
				return $message;
					
			}
			else {
				$this->log_success($username);
					
				$message["error_code"] = 0;
				$message["error_message"] = "Success";
				return $message;
			}
		} else {
			$error = ldap_errno($ldap) . ": " . ldap_error($ldap);
			trigger_error($error);
			$message["error_code"] = 107;
			$message["error_message"] = "Gagal ubah Sandi";
			return $message;
		}
	}
	function changePassword($user,$oldPassword,$newPassword,$newPasswordCnf)
	{
		global $message;
		global $message_css;
		 
	
		$server = env('LDAP_HOST');
		$dn = env('LDAP_BASEDN') ; #"cn=users,ou=groups,dc=unja,dc=ac,dc=id";
		 
		//error_reporting(0);
		#error_log("step1\n");
		ldap_connect($server);
		$con = ldap_connect($server);
		ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
	
		// bind anon and find user by uid
		$user_search = ldap_search($con,$dn,"(|(uid=$user)(mail=$user))");
		$user_search = ldap_search( $con, $dn, 'uid=' . $this->ldapEscape($user));
		$user_get = ldap_get_entries($con, $user_search);
		$user_entry = ldap_first_entry($con, $user_search);
	
		$ldapconn = $con;
		$entry = $user_entry;
		error_log("step2\n");
		$user_dn = ldap_get_dn($con, $user_entry);
		$user_id = $user_get[0]["uid"][0];
		$user_givenName = $user_get[0]["givenname"][0];
		$user_search_arry = array( "*", "ou", "uid", "mail", "passwordRetryCount", "passwordhistory" );
		$user_search_filter = "(|(uid=$user_id)(mail=$user))";
		$user_search_opt = ldap_search($con,$user_dn,$user_search_filter,$user_search_arry);
		$user_get_opt = ldap_get_entries($con, $user_search_opt);
		#print_r($user_get_opt);
		error_log("step3\n");
		#$passwordRetryCount = $user_get_opt[0]["passwordRetryCount"][0];
		#$passwordhistory = $user_get_opt[0]["passwordhistory"][0];
	
		error_log("step4\n");
		//$message[] = "Username: " . $user_id;
		//$message[] = "DN: " . $user_dn;
		//$message[] = "Current Pass: " . $oldPassword;
		//$message[] = "New Pass: " . $newPassword;
	
		/* Start the testing */
		error_log("step5\n");
		#if ( $passwordRetryCount == 3 ) {
		#	$message["error_code"] = 101;
		#	$message["error_message"] = "Error E101 - Your Account is Locked Out!!!";
		#	return $message;
		#}
		error_log("step6\n");
		Log::info("user_dn: $user_dn, oldPassword: $oldPassword");
		if (@ldap_bind($con, $user_dn, $oldPassword) === false) {
			$message["error_code"] = 101;
			$message["error_message"] = "Error E101 - Sandi yang lama salah.";
			return $message;
		}
		error_log("step7\n");
		if ($newPassword != $newPasswordCnf ) {
			$message["error_code"] = 102;
			$message["error_message"] = "Error E102 - Sandi baru dengan sandi konfirmasi tidak sama!";
			return $message;
		}
		#$encoded_newPassword = "{SHA}" . base64_encode( pack( "H*", sha1( $newPassword ) ) );
		#echo "user_dn=$user_dn  user_entry $user_entry \n";
		$encoded_newPassword = $this->make_ssha_password($newPassword);
		#$history_arr = ldap_get_values($con,$user_dn,"passwordhistory");
		#error_log("step8\n");
		#if ( $history_arr ) {
		#	$message["error_code"] = 102;
		#	$message["error_message"] = "Error E102 - Your new password matches one of the last 10 passwords that you used, you MUST come up with a new password.";
		#	return $message;
		#}
		/*if (strlen($newPassword) < 8 ) {
		 $message["error_code"] = 103;
		 $message["error_message"] = "Error E103 - Your new password is too short.<br/>Your password must be at least 8 characters long.";
	
		 return $message;
		 }*/
		/*if (!preg_match("/[0-9]/",$newPassword)) {
		 $message["error_code"] = 104;
		 $message["error_message"] = "Error E104 - Your new password must contain at least one number.";
		 return $message;
		 }*/
		error_log("step9\n");
		if (!preg_match("/[a-zA-Z]/",$newPassword)) {
			$message["error_code"] = 105;
			$message["error_message"]  = "Error E105 - Your new password must contain at least one letter.";
			return $message;
		}
		/*if (!preg_match("/[A-Z]/",$newPassword)) {
		 $message["error_code"] = 106;
		 $message["error_message"]  = "Error E106 - Your new password must contain at least one uppercase letter.";
		 return $message;
		 }*/
		/*if (!preg_match("/[a-z]/",$newPassword)) {
		 $message["error_code"] = 107;
		 $message["error_message"]  = "Error E107 - Your new password must contain at least one lowercase letter.";
		 return $message;
		 }*/
		error_log("step11\n");
		if (!$user_get) {
			$message["error_code"] = 103;
			$message["error_message"]  = "Error E200 - Unable to connect to server, you may not change your password at this time, sorry.";
			return $message;
		}
		 
		$auth_entry = ldap_first_entry($con, $user_search);
		Log::info(json_encode($auth_entry));
		
		#$mail_addresses = ldap_get_values($con, $auth_entry, "mail");
		$given_names = ldap_get_values($con, $auth_entry, "givenName");
		Log::info($given_names);
		#$last_names = ldap_get_values($con, $auth_entry, "sn");
		#$password_history = ldap_get_values($con, $auth_entry, "passwordhistory");
		#$mail_address = $mail_addresses[0];
		$first_name = $given_names[0];
		$last_name = "" ; #$last_names[0];
		error_log("step12\n");
		/* And Finally, Change the password */
		$entry = array();
		$entry["userPassword"] = "$encoded_newPassword";
		error_log($user_dn."\n");
		if (ldap_modify($con,$user_dn,$entry) === false)
		{
			error_log("step13\n");
			$error = ldap_error($con);
			$errno = ldap_errno($con);
			$message["error_message"] = "E201 - Your password cannot be change, please contact the administrator.";
			$message["error_code"] = $errno;
			return $message;
		} else {
			error_log("step14\n");
			$message_css = "yes";
			/*mail($mail_address,"Password change notice","Dear $first_name,
			 Your password on http://support.example.com for account $user_id was just changed. If you did not make this change, please contact support@example.com.
			 If you were the one who changed your password, you may disregard this message.
	
			 Thanks
			 -Matt"); */
			$this->log_success($user);
			error_log("step15\n");
			$message["error_code"]=0;
			$message["error_message"] = "Password $user_id nama: $first_name berhasil diubah.<br/>";
		}
		error_log("step16\n");
		return $message;
	}
	
	function addUser($username, $password, $firstname, $lastname)
	{
		$ldap=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT'));
		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!$ldap)
		{
			trigger_error("error ldap connect"	);
		}
		$adminBind= ldap_bind($ldap, "cn=admin,dc=unja,dc=ac,dc=id", env("LDAP_ADMPASS"));
		if (!$adminBind)
		{
			trigger_error("error ldap adminBind");
		}
	
		$info["cn"] = $firstname;
		$info["givenName"] = $firstname;
		$info["sn"] = $lastname;
		$info["objectClass"] = "inetOrgPerson";
		$r = ldap_add($ldap,"uid=$username,".env("LDAP_BASEDN"),$info);
		if ($r)
		{
			$result["error_code"]=0;
			$result["error_message"] = "Success";
		}
		else
		{
			$result["error_code"]=20;
			$result["error_message"] = "Gagal menambah user LDAP";
		}
		error_log(print_r($result, true));
		return $result;
	}
	public static $yangboleh      = array("safril10", "20151071", "dadang02", "rusman09", "jamil04", "rosmiati08", "aprianto01", "lptik", "tris");
	public static $yangbolehadmin = array("mauladi25", "indrasu", "tris", "lptik", "safril10", "20151071");
	function is_auth_sso ()
	{
		global $yangboleh;
		global $yangbolehadmin;
		$status = $_SESSION["status"];
		$pemakai = $_SESSION["pemakai"];
	
		if (in_array($status, $yangboleh) or in_array($pemakai, $yangboleh)
				or in_array($status, $yangbolehadmin) or in_array($pemakai, $yangbolehadmin))
		{
			return true;
		}
		else
		{
			return false;
		}
	
	}
	function is_auth_sso_admin ()
	{
		global $yangbolehadmin;
		$status = $_SESSION["status"];
		$pemakai = $_SESSION["pemakai"];
	
		if (in_array($status, $yangbolehadmin) or in_array($pemakai, $yangbolehadmin))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getNextLdapUid()
	{
		$pdb = DB::connection()->getPdo();
		$st = $pdb->prepare($sql = "select * from dbunja.siakadconfig where option_name = 'last_ldap_uid'");
		$hasil = $st->execute();
		error_log($sql);
		error_log(print_r($st->errorInfo(), true));
		if ($hasil===false)
			error_log("gagal ");
			$row = $st -> fetch();
			error_log(print_r($row, true));
			if ($row)
			{
				$value = intval($row["option_value"]);
				$value++;
				$st = $pdb->prepare("update dbunja.siakadconfig set option_value = ? where siakadconfig_id = ?");
				$hasil = $st->execute($data = array ($value, $row["siakadconfig_id"] ));
				error_log($sql);
				error_log(print_r($data, true));
				error_log(print_r($st->errorInfo(), true));
				return $value;
			}
			else
				return false;
	}
	function getMaxuid() {
		
		global $json;
		$uidarray= array();
		//die ("user: $PHP_AUTH_USER password $PHP_AUTH_PW \n");
		 
		$ds=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT'));
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_bind( $ds, env('LDAP_ADMUSER'), env('LDAP_ADMPASS'));
	
		$read = ldap_search( $ds, env('LDAP_BASEDN'), "uid=*", array("uidnumber"));
		if ($read)
		{
			$info = ldap_get_entries($ds, $read);
			#print_r($info);
			error_log( $info["count"]." entries returned\n");
			for ($i = 0; $i<$info["count"]; $i++) {
				for ($ii=0; $ii<$info[$i]["count"]; $ii++){
					$data = $info[$i][$ii];
					for ($iii=0; $iii<$info[$i][$data]["count"]; $iii++) {
						#echo $data.": ".$info[$i][$data][$iii]."\n";
						$uidarray[] = $info[$i][$data][$iii];
	
					}
				}
			}
			 
			arsort($uidarray, SORT_NUMERIC );
			$key_of_max = key($uidarray);
			#print_r($uidarray);
			error_log ("hasil maxuid: " . $uidarray[$key_of_max]."\n");
			return $uidarray[$key_of_max];
		}
		else
		{
			return false;
		}
	}
	
	function addUser2($username, $password, $firstname, $lastname)
	{
		$ldap=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT'));
		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!$ldap)	{
			trigger_error("error ldap connect"	);
		}
		$adminBind= ldap_bind($ldap, env("LDAP_ADMUSER"), env("LDAP_ADMPASS"));
		if (!$adminBind)
		{
			trigger_error("error ldap adminBind");
		}
		$uidnumber=$this->getNextLdapUid();
		if ($uidnumber !== false){
			//$uidnumber++;
		}
		else{
			$result["error_code"]=20;
			$result["error_message"] = "Gagal menambah user LDAP, UID max error";
			return $result;
		}
		$info["cn"] = $firstname;
		$info["gidNumber"] = 502;
		$info["givenName"] = $firstname;
		$info["homedirectory"] = "/home/$username";
		$info["loginshell"] = "/bin/bash";
	
		$info["objectClass"][0] = "inetOrgPerson";
		$info["objectClass"][1] = "posixAccount";
		$info["objectClass"][2] = "top";
		#$info["objectClass"][3] = "sambaSamAccount";
		
		$info["sn"] = $firstname;
		$info["uid"] = "$username";
		$info["uidnumber"] = "$uidnumber";
		
		#samba
		/*$info["sambaLMPassword"] = "878D8014606CDA29677A44EFA1353FC7";
		$info["sambaPrimaryGroupSID"] = "S-1-5-21-2447931902-1787058256-3961074038-513";
		$info["sambaNTPassword"] = "552902031BEDE9EFAAD3B435B51404EE";
		$info["sambaPwdLastSet"] = "1010179124";
		$info["sambaLogonTime"] = "0";
		$info["sambaKickoffTime"] = "2147483647";
		$info["sambaAcctFlags"] = "[UX         ]";
		$info["sambaLogoffTime"] = "2147483647";
		$info["sambaSID"] = "S-1-5-21-2447931902-1787058256-3961074038-5006";
		$info["sambaPwdCanChange"] = "0";
		$info["sambaPwdMustChange"] = "2147483647";*/
		#end samba
		$encoded_newPassword = $this->make_ssha_password($password);
		$info["userPassword"] = "$encoded_newPassword";
		error_log(print_r($info, true));
		$r = ldap_add($ldap,"uid=$username,".env("LDAP_BASEDN"),$info);
		if ($r)
		{
			$result["error_code"]=0;
			$result["error_message"] = "Success";
		}
		else
		{
			$result["error_code"]=20;
			$result["error_message"] = "Gagal menambah user LDAP";
		}
		#print_r($result);
		return $result;
	}
	
    function searchUser($username)
	{
	   	#dd(env('LDAP_HOST'));
		
        $ds=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT', 389));
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        $json=array();
        $json["debug"] ="";
        $r = ldap_search( $ds, env('LDAP_BASEDN'), 'uid=' . $this->ldapEscape($username));
        if (!$r)
	       return false;
        $json["debug"] .= "get_entries\n";
        $result = ldap_get_entries( $ds, $r);
		#print_r($result);
        $json["debug"] .= "getresult\n";
        if ($result["count"] == 0)
            return false;
			 #print_r($result);
        if (!$result[0])
		    return false;
					#print_r($result);
	    $result["error_code"]=0;
	    $result["error_message"] = "Success";
		$result["hasil"] = $result;
	    return $result["hasil"];
		 
	}
	function searchUserAsAdmin($username)
	{
	    #dd(env('LDAP_HOST'));
	    
	    $ds=ldap_connect(env('LDAP_HOST'),env('LDAP_PORT'));
	    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	    if (!$ds)
	    {
	        trigger_error("error ldap connect"	);
	    }
	    $adminBind= ldap_bind($ds, env('LDAP_ADMUSER'), env("LDAP_ADMPASS"));
	    if (!$adminBind)
	    {
	        trigger_error("error ldap adminBind");
	    }
	    $json=array();
	    $json["debug"] ="";
	    $r = ldap_search( $ds, env('LDAP_BASEDN'), 'uid=' . $this->ldapEscape($username));
	    if (!$r)
	        return false;
	        $json["debug"] .= "get_entries\n";
	        $result = ldap_get_entries( $ds, $r);
	        #print_r($result);
	        $json["debug"] .= "getresult\n";
	        if ($result["count"] == 0)
	            return false;
	            #print_r($result);
	            if (!$result[0])
	                return false;
	                #print_r($result);
	                $result["error_code"]=0;
	                $result["error_message"] = "Success";
	                $result["hasil"] = $result;
	                return $result["hasil"];
	                
	}
	public function hasSambaAttribute($attr)
	{
		Log::info("hasSambaAttribute: " . print_r($attr, true));
		foreach ($attr["objectclass"] as $item)
		{
			if ($item == "sambaSamAccount"){
				Log::info("punya attribute samba" );
				return true;
			}
		}
	}
	
	public function modifyUser($username,$attr )
	{
		$enable=1;
		$ldapServer = env("LDAP_HOST");
		$ldapBase = env("LDAP_BASEDN"); //'DC=foo,DC=bar';
		$ds = ldap_connect(env('LDAP_HOST'));
		if (!$ds) {
			return false;
		}
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		$ldapBind = ldap_bind($ds,env("LDAP_ADMUSER"),env("LDAP_ADMPASS"));
		if (!$ldapBind) { 
			return false;
		}
		//$sr = ldap_search($ds, $ldapBase, "(samaccountname=$username)");
		$sr = ldap_search( $ds, env('LDAP_BASEDN'), 'uid=' . $this->ldapEscape($username));
		
		$ent= ldap_get_entries($ds,$sr);
		$dn=$ent[0]["dn"];
		
		$status=0;
		$status = ldap_modify ($ds, $dn , [
				"givenName" =>	$attr["givenname"],
				"sn" =>	$attr["sn"],
				"cn" =>	$attr["cn"]
		] );
		/*if ($this->hasSambaAttribute($ent[0]))	{
			 
			$status = ldap_modify ($ds, $dn , [
				"sambaNTPassword" => $pass = $this->makeSambaNtPassword($attr["password"]),
				"sambaPwdLastSet" => time(),
				"givenName" =>	$attr["givenname"],
				"sn" =>	$attr["sn"],
				"cn" =>	$attr["cn"]
			] );
			Log::info("hasSambaAttribute: ldap_modify: $status - {$attr['password']} - $pass");
		}
		else {	
			ldap_mod_add($ds, $dn, ["objectClass"=>"sambaSamAccount"]);
			dd("kesini");
			#samba
			$info["sambaLMPassword"] = "878D8014606CDA29677A44EFA1353FC7";
			$info["sambaPrimaryGroupSID"] = "S-1-5-21-2447931902-1787058256-3961074038-513";
			$info["sambaNTPassword"] = $this->makeSambaNtPassword($attr["password"]);
			$info["sambaPwdLastSet"] = time();
			$info["sambaLogonTime"] = "0";
			$info["sambaKickoffTime"] = "2147483647";
			$info["sambaAcctFlags"] = "[UX         ]";
			$info["sambaLogoffTime"] = "2147483647";
			$info["sambaSID"] = "S-1-5-21-2447931902-1787058256-3961074038-5006";
			$info["sambaPwdCanChange"] = "0";
			$info["sambaPwdMustChange"] = "2147483647";
			 
			
			$status = ldap_mod_add($ds, $dn , $info );
		}*/
		// Deactivate   #######dari contoh saja
		#$ac = $ent[0]["useraccountcontrol"][0];
		#$disable=($ac |  2); // set all bits plus bit 1 (=dec2)
		#$enable =($ac & ~2); // set all bits minus bit 1 (=dec2)
		#$userdata=array();
		#if ($enable==1) {
		#	$new=$enable; 
		#}
		#else {
		#	$new=$disable; //enable or disable?
		#}
		#$userdata["useraccountcontrol"][0]=$new;
		#ldap_modify($ds, $dn, $userdata); //change state
		// ######dari contoh saja 
		
		ldap_close($ds);
		return $status; //return current status (1=enabled, 0=disabled)
		
	}
	function update_expire_date($pemakai, $status)
	{
		global $pdb;
		$new_expire_date = date("Y-m-d H:i:s" , time() + 86400 * 60);
		$bukansandi = md5($pemakai . uniqid(mt_rand(), true) );
		if (strcasecmp($status, "mahasiswa") == 0)
		{
			$st = $pdb->prepare($sql = "update mahasiswa set password_expire_date = ?, sandi=? where no_mhs = ?");
			$data = array($new_expire_date, $bukansandi, $pemakai);
			error_log($sql);
			error_log(print_r($data, true));
			$st->execute($data);
			return;
		}
		if (strcasecmp($status, "dosen") == 0)
		{
			$st = $pdb->prepare($sql = "update dosen set password_expire_date = ?,  sandi = ? where nidn = ?");
			$data = array($new_expire_date, $bukansandi, $pemakai);
			error_log($sql);
			error_log(print_r($data, true));
			$st->execute($data);
			return;
		}
		if (strcasecmp($status, "pegawai") == 0)
		{
			$st = $pdb->prepare($sql = "update dik set password_expire_date = ?, sandi=? where nip_baru = ?");
			$data = array($new_expire_date, $bukansandi, $pemakai);
			error_log($sql);
			error_log(print_r($data, true));
			$st->execute($data);
			return;
		}
	
		$stc = $pdb->prepare($sql = "select count(*) jml from pemakai where nama = ?");
		$data = array($pemakai);
		$stc->execute($data);
		$row = $stc->fetch();
		if ( $row["jml"] > 0)
		{
			$st = $pdb->prepare($sql = "update pemakai set password_expire_date = ?, password=? where nama = ?");
			$data = array($new_expire_date, $bukansandi, $pemakai);
			error_log($sql);
			error_log(print_r($data, true));
			$st->execute($data);
		}
	}
	
	function makeSambaNtPassword($password){
		//$password="12345678";
		return strtoupper(bin2hex(mhash(MHASH_MD4, iconv("UTF-8","UTF-16LE",$password))));
	}
	
	function changeSambaNtPassword()
	{
		global $message;
		global $message_css;
		 
	
		$server = env('LDAP_HOST');
		$dn = env('LDAP_BASEDN') ; #"cn=users,ou=groups,dc=unja,dc=ac,dc=id";
	
		//error_reporting(0);
		#error_log("step1\n");
		ldap_connect($server);
		$con = ldap_connect($server);
		ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
	
		// bind anon and find user by uid
		$user_search = ldap_search( $con, $dn, 'uid=' . LdapService::ldapEscape($user));
		$user_get = ldap_get_entries($con, $user_search);
		$user_entry = ldap_first_entry($con, $user_search);
	
		$ldapconn = $con;
		$entry = $user_entry;
		error_log("step2\n");
		$user_dn = ldap_get_dn($con, $user_entry);
		$user_id = $user_get[0]["uid"][0];
		$user_givenName = $user_get[0]["givenname"][0];
		$user_search_arry = array( "*", "ou", "uid", "mail", "passwordRetryCount", "passwordhistory" );
		$user_search_filter = "(|(uid=$user_id)(mail=$user))";
		$user_search_opt = ldap_search($con,$user_dn,$user_search_filter,$user_search_arry);
		$user_get_opt = ldap_get_entries($con, $user_search_opt);
		#print_r($user_get_opt);
		error_log("step3\n");
		$passwordRetryCount = $user_get_opt[0]["passwordRetryCount"][0];
		$passwordhistory = $user_get_opt[0]["passwordhistory"][0];
	
		error_log("step4\n");
	
		/* Start the testing */
		error_log("step5\n");
		if ( $passwordRetryCount == 3 ) {
			$message["error_code"] = 101;
			$message["error_message"] = "Error E101 - Your Account is Locked Out!!!";
			return $message;
		}
		error_log("step6\n");
		if (ldap_bind($con, $user_dn, $oldPassword) === false) {
			$message["error_code"] = 101;
			$message["error_message"] = "Error E101 - Sandi yang lama salah.";
			return $message;
		}
		error_log("step7\n");
		if ($newPassword != $newPasswordCnf ) {
			$message["error_code"] = 102;
			$message["error_message"] = "Error E102 - Sandi baru dengan sandi konfirmasi tidak sama!";
			return $message;
		}
		$encoded_newPassword = makeSambaNtPassword($newPassword);
		$history_arr = ldap_get_values($con,$user_dn,"passwordhistory");
		error_log("step8\n");
		if ( $history_arr ) {
			$message["error_code"] = 102;
			$message["error_message"] = "Error E102 - Your new password matches one of the last 10 passwords that you used, you MUST come up with a new password.";
			return $message;
		}
		/*if (strlen($newPassword) < 8 ) {
		 $message["error_code"] = 103;
		 $message["error_message"] = "Error E103 - Your new password is too short.<br/>Your password must be at least 8 characters long.";
	
		 return $message;
		 }*/
		/*if (!preg_match("/[0-9]/",$newPassword)) {
		 $message["error_code"] = 104;
		 $message["error_message"] = "Error E104 - Your new password must contain at least one number.";
		 return $message;
		 }*/
		error_log("step9\n");
		if (!preg_match("/[a-zA-Z]/",$newPassword)) {
			$message["error_code"] = 105;
			$message["error_message"]  = "Error E105 - Your new password must contain at least one letter.";
			return $message;
		}
		/*if (!preg_match("/[A-Z]/",$newPassword)) {
		 $message["error_code"] = 106;
		 $message["error_message"]  = "Error E106 - Your new password must contain at least one uppercase letter.";
		 return $message;
		 }*/
		/*if (!preg_match("/[a-z]/",$newPassword)) {
		 $message["error_code"] = 107;
		 $message["error_message"]  = "Error E107 - Your new password must contain at least one lowercase letter.";
		 return $message;
		 }*/
		error_log("step11\n");
		if (!$user_get) {
			$message["error_code"] = 103;
			$message["error_message"]  = "Error E200 - Unable to connect to server, you may not change your password at this time, sorry.";
			return $message;
		}
	
		$auth_entry = ldap_first_entry($con, $user_search);
		$mail_addresses = ldap_get_values($con, $auth_entry, "mail");
		$given_names = ldap_get_values($con, $auth_entry, "givenName");
		$last_names = ldap_get_values($con, $auth_entry, "sn");
		$password_history = ldap_get_values($con, $auth_entry, "passwordhistory");
		$mail_address = $mail_addresses[0];
		$first_name = $given_names[0];
		$last_name = $last_names[0];
		error_log("step12\n");
		/* And Finally, Change the password */
		$entry = array();
		$entry["userPassword"] = "$encoded_newPassword";
		error_log($user_dn."\n");
		if (ldap_modify($con,$user_dn,$entry) === false)
		{
			error_log("step13\n");
			$error = ldap_error($con);
			$errno = ldap_errno($con);
			$message["error_message"] = "E201 - Your password cannot be change, please contact the administrator.";
			$message["error_code"] = $errno;
			return $message;
		} else {
			error_log("step14\n");
			$message_css = "yes";
			/*mail($mail_address,"Password change notice","Dear $first_name,
			 Your password on http://support.example.com for account $user_id was just changed. If you did not make this change, please contact support@example.com.
			 If you were the one who changed your password, you may disregard this message.
	
			 Thanks
			 -Matt"); */
			$this->log_success($user);
			error_log("step15\n");
			$message["error_code"]=0;
			$message["error_message"] = "Password $user_id nama: $first_name $last_name  berhasil diubah.<br/>";
		}
		error_log("step16\n");
		return $message;
	}
	
	
	
	function ldap_authenticate2($user, $password) {
			
		if(empty($user) || empty($password)) return false;
	
		// Active Directory server
		$ldap_host = env('LDAP_HOST');
	
		// Active Directory DN
		$ldap_dn = env('LDAP_BASEDN');#"ou=users,DC=unja,DC=ac,DC=id";
	
		// Active Directory user group
		$ldap_user_group = "WebUsers";
	
		// Active Directory manager group
		$ldap_manager_group = "WebManagers";
	
		// Domain, for purposes of constructing $user
		$ldap_usr_dom = '';
	
		// connect to active directory
		$ldap = ldap_connect($ldap_host);
		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	
		// verify user and password
		if($bind = @ldap_bind($ldap, $user.$ldap_usr_dom, $password)) {
			// valid
			// check presence in groups
			$filter = "(sAMAccountName=".$user.")";
			$attr = array("memberof");
			$result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
			$entries = ldap_get_entries($ldap, $result);
			ldap_unbind($ldap);
	
			// check groups
			foreach($entries[0]['memberof'] as $grps) {
				// is manager, break loop
				if(strpos($grps, $ldap_manager_group)) { $access = 2; break; }
	
				// is user
				if(strpos($grps, $ldap_user_group)) $access = 1;
			}
	
			if($access != 0) {
				// establish session variables
				$_SESSION['user'] = $user;
				$_SESSION['access'] = $access;
				return true;
			} else {
				// user has no rights
				return false;
			}
	
		} else {
			// invalid name or password
			return false;
		}
	}
	
	function encrypt_password($plaintext)
	{
		$key = pack('H*', file_get_contents("/etc/kunci.txt"));
		#error_log("key:$key\n");
	
		# show key size use either 16, 24 or 32 byte keys for AES-128, 192
		# and 256 respectively
		$key_size =  strlen($key);
		#error_log("Key size: " . $key_size . "\n");
	
	
	
		# create a random IV to use with CBC encoding
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	
		# creates a cipher text compatible with AES (Rijndael block size = 128)
		# to keep the text confidential
		# only suitable for encoded input that never ends with value 00h
		# (because of default zero padding)
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
		$plaintext, MCRYPT_MODE_CBC, $iv);
	
		# prepend the IV for it to be available for decryption
		$ciphertext = $iv . $ciphertext;
	
		# encode the resulting cipher text so it can be represented by a string
		$ciphertext_base64 = base64_encode($ciphertext);
	
		#error_log($ciphertext_base64 . "\n");
		return $ciphertext_base64 ;
	
	}
	function decrypt_password($ciphertext_base64)
	{
		$ciphertext_dec = base64_decode($ciphertext_base64);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	
		# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);
	
		# retrieves the cipher text (everything except the $iv_size in the front)
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);
		$key = pack('H*', file_get_contents("/etc/kunci.txt"));
	
		# may remove 00h valued characters from end of plain text
		$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
		$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	
		#error_log($plaintext_dec . "\n");
		return $plaintext_dec;
	}
	public static function is_cli()
	{
	    if( defined('STDIN') )
	    {
	        return true;
	    }
	    
	    if( empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0)
	    {
	        return true;
	    }
	    
	    return false;
	}
	
	public static function getOS() {
		$user_agent     =  self::is_cli() ?  "" : $_SERVER['HTTP_USER_AGENT'];
		$os_platform    =   "Unknown OS Platform";
	
		$os_array       =   array(
				'/windows nt 10/i'     =>  'Windows 10',
				'/windows nt 6.3/i'     =>  'Windows 8.1',
				'/windows nt 6.2/i'     =>  'Windows 8',
				'/windows nt 6.1/i'     =>  'Windows 7',
				'/windows nt 6.0/i'     =>  'Windows Vista',
				'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
				'/windows nt 5.1/i'     =>  'Windows XP',
				'/windows xp/i'         =>  'Windows XP',
				'/windows nt 5.0/i'     =>  'Windows 2000',
				'/windows me/i'         =>  'Windows ME',
				'/win98/i'              =>  'Windows 98',
				'/win95/i'              =>  'Windows 95',
				'/win16/i'              =>  'Windows 3.11',
				'/macintosh|mac os x/i' =>  'Mac OS X',
				'/mac_powerpc/i'        =>  'Mac OS 9',
				'/linux/i'              =>  'Linux',
				'/ubuntu/i'             =>  'Ubuntu',
				'/iphone/i'             =>  'iPhone',
				'/ipod/i'               =>  'iPod',
				'/ipad/i'               =>  'iPad',
				'/android/i'            =>  'Android',
				'/blackberry/i'         =>  'BlackBerry',
				'/webos/i'              =>  'Mobile'
		);
	
		foreach ($os_array as $regex => $value) {
	
			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}
	
		}
	
		return $os_platform;
	
	}
	
	public static function getBrowser() {
		$user_agent     =   self::is_cli() ?  "cli" : $_SERVER['HTTP_USER_AGENT'];
		$browser        =   "Unknown Browser";
		$browser_array  =   array(
				'/msie/i'       =>  'Internet Explorer',
				'/firefox/i'    =>  'Firefox',
				'/safari/i'     =>  'Safari',
				'/chrome/i'     =>  'Chrome',
				'/edge/i'       =>  'Edge',
				'/opera/i'      =>  'Opera',
				'/netscape/i'   =>  'Netscape',
				'/maxthon/i'    =>  'Maxthon',
				'/konqueror/i'  =>  'Konqueror',
				'/mobile/i'     =>  'Handheld Browser'
		);
		foreach ($browser_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$browser    =   $value;
			}
		}
		return $browser;
	
	}
	function log_success($username)
	{
		error_log("log_success step1\n");
		$st = DB::table("siakad.log")->insert ([
			"tanggal" =>date("Y-m-d H:i:s"),  
			"tipe" =>"UBAH_SANDI",
			"user" => 'admin', 
		    "ip" => self::is_cli() ?  "cli" :$_SERVER["REMOTE_ADDR"],  
		    "method" => self::is_cli() ?  "cli" : $_SERVER["REQUEST_METHOD"],
		    "url" => self::is_cli() ?  "cli" :$_SERVER["REQUEST_URI"], 
			"browser" => LdapService::getBrowser(), 
			"os" => LdapService::getOS(),
			"keterangan" => "SUCCESS" 
		]);
		
	}
	
	public function make_samba_nt_password($password){
		return strtoupper(bin2hex(mhash(MHASH_MD4, iconv("UTF-8","UTF-16LE",$password))));
		
		
		
	}
	function changePasswordHotspot($user,$newPassword,$newPasswordCnf)
	{
		global $message;
		global $message_css;
		
		$server = env('LDAP_HOST');
		$dn = env('LDAP_BASEDN') ; #"cn=users,ou=groups,dc=unja,dc=ac,dc=id";
		
		#error_log("step1\n");
		
		$ldap = ldap_connect($server);
		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		// admin bind 
		$adminBind= ldap_bind($ldap, env('LDAP_ADMUSER'), env("LDAP_ADMPASS"));
		if (!$adminBind)
		{
			trigger_error("error ldap adminBind");
		}
		
		$user_search = ldap_search( $ldap, $dn, 'uid=' . $this->ldapEscape($user));
		$user_get = ldap_get_entries($ldap, $user_search);
		$user_entry = ldap_first_entry($ldap, $user_search);
		
		$entry = $user_entry;
		error_log("step2\n");
		$user_dn = ldap_get_dn($ldap, $user_entry);
		$user_id = $user_get[0]["uid"][0];
		#$user_givenName = $user_get[0]["givenname"][0];
		$user_search_arry = array( "*", "ou", "uid", "mail", "passwordRetryCount", "passwordhistory" );
		$user_search_filter = "(|(uid=$user_id)(mail=$user))";
		$user_search_opt = ldap_search($ldap,$user_dn,$user_search_filter,$user_search_arry);
		$user_get_opt = ldap_get_entries($ldap, $user_search_opt);
		Log::info($user_get_opt);
		error_log("step3\n");

		Log::info("user_dn: $user_dn, newPassword: $newPassword");
		/*if (@ldap_bind($con, $user_dn, $oldPassword) === false) {
			$message["error_code"] = 101;
			$message["error_message"] = "Error E101 - Sandi yang lama salah.";
			return $message;
		}*/
		error_log("step7\n");
		if ($newPassword != $newPasswordCnf ) {
			$message["error_code"] = 102;
			$message["error_message"] = "Error E102 - Sandi baru dengan sandi konfirmasi tidak sama!";
			return $message;
		}
		
		error_log("step9\n");
		if (!preg_match("/[a-zA-Z]/",$newPassword)) {
			$message["error_code"] = 105;
			$message["error_message"]  = "Error E105 - Your new password must contain at least one letter. $newPassword";
			return $message;
		}
		
		error_log("step11\n");
		if (!$user_get) {
			$message["error_code"] = 103;
			$message["error_message"]  = "Error E200 - Unable to connect to server, you may not change your password at this time, sorry.";
			return $message;
		}
		
		$auth_entry = ldap_first_entry($ldap, $user_search);
		Log::info($auth_entry);
		
		$given_names = ldap_get_values($ldap, $auth_entry, "givenName");
		Log::info($given_names);
		error_log("step12\n");
		/* And Finally, Change the password */
		$info = array();
		$info["objectClass"][0] = "inetOrgPerson";
		$info["objectClass"][1] = "posixAccount";
		$info["objectClass"][2] = "top";
		$info["objectClass"][3] = "sambaSamAccount";
		
		#samba
		 $info["sambaLMPassword"] = "878D8014606CDA29677A44EFA1353FC7";
		 $info["sambaPrimaryGroupSID"] = "S-1-5-21-2447931902-1787058256-3961074038-513";
		 $info["sambaNTPassword"] = $this->makeSambaNtPassword($newPassword);
		 $info["sambaPwdLastSet"] = time();
		 $info["sambaLogonTime"] = "0";
		 $info["sambaKickoffTime"] = "2147483647";
		 $info["sambaAcctFlags"] = "[UX         ]";
		 $info["sambaLogoffTime"] = "2147483647";
		 $info["sambaSID"] = "S-1-5-21-2447931902-1787058256-3961074038-5006";
		 $info["sambaPwdCanChange"] = "0";
		 $info["sambaPwdMustChange"] = time() + (24*60*90);
		#end samba

		Log::info("user_dn");
		Log::info($user_dn);
		if (ldap_modify($ldap,$user_dn,$info) === false)
		{
			error_log("step13\n");
			$error = ldap_error($ldap);
			$errno = ldap_errno($ldap);
			$message["error_message"] = "E201 - Your password cannot be change, please contact the administrator.";
			$message["error_code"] = $errno;
			return $message;
		} else {
			error_log("step14\n");
			$message_css = "yes";
			/*mail($mail_address,"Password change notice","Dear $first_name,
			 Your password on http://support.example.com for account $user_id was just changed. If you did not make this change, please contact support@example.com.
			 If you were the one who changed your password, you may disregard this message.
			 
			 Thanks
			 -Matt"); */
			$this->log_success($user);
			error_log("step15\n");
			$message["error_code"]=0;
			$message["error_message"] = "Password $user_id nama: first_name berhasil diubah.<br/>";
		}
		error_log("step16\n");
		return $message;
	}
}
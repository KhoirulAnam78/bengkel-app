<?php

namespace App\Actions\Fortify;

use Exception;
use App\Models\User;

class AuthenticateUser {
    public function authenticate($request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $ldapbind=null;
        $ldapconn = ldap_connect('sso.unja.ac.id');
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        
        try{
            $ldapbind = @ldap_bind($ldapconn, "uid=" . $request->username . ",ou=users,dc=unja,dc=ac,dc=id", $request->password);
            if ($ldapbind) {
                $user = User::where("username",$request->username)->first();
                // if ($user == null) {
                //     $user = User::create([
                //         "username"=>$request->username,
                //         "status"=>1
                //         // "password"=>bcrypt($request->username)
                //     ]);
                // }
                return $user;
            }else{
                if (env("APP_ENV") == "development") {
                    $user = User::where("username",$request->username)->first();
                    // if ($user == null) {
                    //     $user = User::create([
                    //         "username"=>$request->username,
                    //         "status"=>1
                    //     ]);
                    // }
                    return $user;
                }
            }       
        }catch (Exception $e){
            return null;
        }
    }
}
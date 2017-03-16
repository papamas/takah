<?php

include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\GrantedRole;
use openkm\bean\GrantedUser;
/**
 * TestAuth
 *
 * @author sochoa
 */
class TestAuth {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_DOC_PATH = "/okm:root/PROVINSI GORONTALO/IJAZAH_196312241990032005.pdf";
    const TEST_DOC_UUID = 'd6eab74f-7d6f-4281-bd06-a98f34bac0fd';    

    private $ws;

    public function __construct() {
	
	    //var_dump($this->ws);
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
        //var_dump($this->ws);
        
	}
    
    public function test() {
        //getGrantedRoles
        echo '<h2>getGrantedRoles</h2>';
        $grantedRoles = $this->ws->getGrantedRoles(self::TEST_DOC_UUID);
        foreach ($grantedRoles as $grantedRole) {
            echo '<div style="margin-left:30px">';
            echo '<h3>GrantedRole</h3>';
            echo '<p><strong>Role:</strong>' .$grantedRole->getRole() . '</p>';
            echo '<p><strong>Permissions:</strong>' .$grantedRole->getPermissions() . '</p>';
            echo '</div>';
        }

        //getGrantedUsers
        echo '<h2>getGrantedUsers</h2>';
        $grantedUsers = $this->ws->getGrantedUsers(self::TEST_DOC_UUID);
        foreach ($grantedUsers as $grantedUser) {
            echo '<div style="margin-left:30px">';
            echo '<h3>GrantedUser</h3>';
            echo '<p><strong>User:</strong>' .$grantedUser->getUser() . '</p>';
            echo '<p><strong>Permissions:</strong>' . $grantedUser->getPermissions() . '</p>';
            echo '</div>';
        }

        //getRoles
        echo '<h2>getRoles</h2>';
        $roles = $this->ws->getRoles();
        foreach ($roles as $role) {
            echo '<div style="margin-left:30px">';
            echo '<p>' . $role . '</p>';
            echo '</div>';
        }

        //getUsers
        echo '<h2>getUsers</h2>';
        $users = $this->ws->getUsers();
        foreach ($users as $user) {
            echo '<div style="margin-left:30px">';
            echo '<p>' . $user . '</p>';
            echo '</div>';
        }

        //getUsersByRole
        echo '<h2>getUsersByRole</h2>';
        $users = $this->ws->getUsersByRole('ROLE_ADMIN');
        foreach ($users as $user) {
            echo '<div style="margin-left:30px">';
            echo '<p>' . $user . '</p>';
            echo '</div>';
        }
        
        //getRolesByUser
        echo '<h2>getRolesByUser</h2>';
        $roles = $this->ws->getRolesByUser('okmAdmin');
        foreach ($roles as $role) {
            echo '<div style="margin-left:30px">';
            echo '<p>' . $role . '</p>';
            echo '</div>';
        }
        
        //getMail
        echo '<h2>getMail</h2>';
        echo '<p>' . $this->ws->getMail('okmAdmin') , '</p>';

        //getName
        echo '<h2>getName</h2>';
        echo '<p>' . $this->ws->getName('okmAdmin') . '</p>';
    }

}

$openkm = new OpenKM();
$testAuth = new TestAuth();
$testAuth->test();
?>
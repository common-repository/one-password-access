<?php
//On vérifie que la désinstallation provient bien de WordPress
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
  exit ();
}


//On supprime l'option créer a l'activation du plugin
delete_option( 'ab_opa_password' );

?>

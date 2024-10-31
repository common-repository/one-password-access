<?php
/*
  Plugin Name: One Password Access
  Plugin URI: http://cnsx.net
  Description: Your web site is only accessible if your visitor have the good password. By default it is : motdepasse_defaut
  Version: 1.0
  Author: Arnaud Banvillet pour CNSX
  Author URI: http://cnsx.net
  License: GPL2
*/

/*
  Copyright 2012  Arnaud Banvillet  (email : arnaud@cnsx.fr )

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//A l'activation du plugin on créer un option contenant notre mot de passe
register_activation_hook( __FILE__ , 'ab_opa_activate' );

//Au cas ou on est besoin de le traduire
load_plugin_textdomain( 'one_password_access_languages' , false , dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// Si je suis dans l'interface d'administration on ajoute le menu pour gérer le mot de passe
if ( is_admin() ) {
   require_once 'admin/ab_opa_admin.php';
} else{
  //Si on recoit un mot de passe du formulaire on le stoke dans un cookie
  //On change le template quand le mot de passe est mauvais pour faire apparaitre le formulaire de login
  add_action( 'template_redirect', 'ab_opa_set_pswd_template' );
}

/**
 * Permet d'appliquer le template contenant notre page de login
 */
function ab_opa_set_pswd_template( ) {
  if ( $_COOKIE['ab_opa_password'] != get_option('ab_opa_password') ){
    //On reagard si on a recut un mot de passe par le formulaire, on l'encode et on le compare a ce qu'on a en base de donné
    if ( isset ( $_POST['ab_opa_pswd'] ) AND $ab_lm_mdp_post = md5($_POST['ab_opa_pswd'].AUTH_SALT) AND $ab_lm_mdp_post == get_option('ab_opa_password')) {
        setcookie('ab_opa_password', $ab_lm_mdp_post, time() + 60*60);
    } else {
    include( plugin_dir_path( __FILE__ ) .'login_page.php' );
    exit;
    }
  }
}


/**
 * Fonction appellé a l'activation du plugin
 * Elle Ajoute une option dans la base de donnée: l'option de mot de passe
 */
function ab_opa_activate( ) {
  //On déclare notre option. On enregistre aisni notre mot de passe dans la base de donnée des options de wordpress
    add_option('ab_opa_password', md5( 'motdepasse_defaut' . AUTH_SALT ), '', 'no');
}

/*
 * register with hook 'wp_enqueue_scripts' which can be used for front end CSS and JavaScript
 */
add_action('wp_enqueue_scripts', 'ab_opa_add_login_page_css');

/*
 * Enqueue style-file, if it exists.
 */
function ab_opa_add_login_page_css() {
  wp_register_style('ab_opa_login_page_style', plugins_url('/style/ab_opa_login_page.css', __FILE__) );
  wp_enqueue_style( 'ab_opa_login_page_style');
}

?>

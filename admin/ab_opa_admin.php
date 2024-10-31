<?php

// On appelle la fonction qui ajoute le menu
add_action( 'admin_menu' , 'ab_opa_admin_menu' );

//Avant de mettre a jour le mot de passe dans la base de donnée, on lui applique un peti m5
add_filter( 'pre_update_option_ab_opa_password' , 'ab_opa_md5_mdp' );

/*
 * Fonction qui intervien avant l'enregistrement du mot de passe et qui l'encode utilisant md5
 */
function ab_opa_md5_mdp ( $newvalue , $oldvalue ) {
  return md5( $newvalue . AUTH_SALT );
}

/*
 * Fonction qui ajoute un sous menu au menu d'options de wordpress
 */
function ab_opa_admin_menu( ) {
  //On ajoute un sousmenu dans les réglages. Pour y accéder il faut avoir la capacité de 'manage_options'
  add_submenu_page('options-general.php', 'One Password Access', 'One Password Access', 'manage_options', 'ab_opa_option_menu', 'ab_opa_print_options');
}

/*
 * Fonction qui créer la page d'option que l'on a jouté au sous menu option
 */
function ab_opa_print_options( ) {
    // Code HTML de la page d'options.
    ?>
    <div class="wrap">
      <!-- Ajout de l'icone d'option -->
      <?php screen_icon( 'options-general' ); ?>
      <h2>One Password Access</h2>
      <p><?php _e('Choose the password you want your users to use to access your site', 'one_password_access_languages')?></p>
      <form method="post" action="options.php">
        <!-- Ajoute 2 champs cachés pour savoir comment rediriger l'utilisateur -->
        <?php wp_nonce_field('update-options'); ?>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="ab_opa_password" />
        <table class="form-table">
          <tr>
            <th><?php _e('Password :', 'one_password_access_languages')?></th>
            <td>
              <input type="text" name="ab_opa_password" id="ab_opa_password" />
            </td>
          </tr>
        </table>
        <p>
          <input type="submit" value="<?php _e('Save Changes', 'one_password_access_languages'); ?>" id="submit" class="button-primary"/>
        </p>
      </form>
    </div><?php
}
?>

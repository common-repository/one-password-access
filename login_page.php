<?php
/*
Template Name: Login page
*/
get_header(); ?>



<div id="ab-opa-login-page" <?php if ( isset($_POST['ab_opa_pswd']) ) echo 'class="wrong"'?> >
  <?php
  //Si on arrive sur cette page aprés avoir envoyer notre formulaire, cela signifi que l'on a le mauvais mot de passe
  if ( isset($_POST['ab_opa_pswd']) ){
    ?>
    <p class="wrong">
      <?php _e('Wrong password','one_password_access_languages'); ?>
    </p>
    <?php
  }
  ?>
  <form method="post">
    <p>
      <label for="ab_opa_pswd"><?php _e('Password', 'one_password_access_languages'); ?></label><br />
      <input type="text" name="ab_opa_pswd" id="ab_opa_pswd"/>
    </p>
    <p>
      <input type="submit" value="<?php _e('Log in', 'one_password_access_languages') ?>" />
    </p>
  </form>
</div>




<?php

get_footer();

?>

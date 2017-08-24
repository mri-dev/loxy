<?php
class Setup_General_Settings {
  function Setup_General_Settings( ) {
      add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
  }
  function register_fields() {
      register_setting( 'general', 'phone', 'esc_attr' );
      add_settings_field('phone', '<label for="phone">'.__('Kapcsolat telefonszám' , 'phone' ).'</label>' , array(&$this, 'phone_cb') , 'general' );

      register_setting( 'general', 'address', 'esc_attr' );
      add_settings_field('address', '<label for="address">'.__('Cím' , 'address' ).'</label>' , array(&$this, 'address_cb') , 'general' );
  }
  function phone_cb() {
      $value = get_option( 'phone', '' );
      echo '<input class="regular-text" type="text" id="phone" name="phone" value="' . $value . '" />';
  }
  function address_cb() {
      $value = get_option( 'address', '' );
      echo '<input class="regular-text" type="text" id="address" name="address" value="' . $value . '" />';
  }
}

?>

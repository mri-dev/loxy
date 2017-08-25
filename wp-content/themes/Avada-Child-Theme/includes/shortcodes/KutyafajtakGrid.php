<?php

class KutyafajtakGridSC
{
    const SCTAG = 'kutyafajtak-grid';

    public function __construct()
    {
        add_action( 'init', array( &$this, 'register_shortcode' ) );
    }

    public function register_shortcode() {
        add_shortcode( self::SCTAG, array( &$this, 'do_shortcode' ) );
    }

    public function do_shortcode( $attr, $content = null )
    {
        $output = '<div class="'.self::SCTAG.'-holder">';

    	  /* Set up the default arguments. */
        $defaults = apply_filters(
            self::SCTAG.'_defaults',
            array(
              'col' => 3
            )
        );
        /* Parse the arguments. */
        $attr = shortcode_atts( $defaults, $attr );

        $data = new WP_Query(array(
          'post_type' => 'kutyafajtak',
          'orderby' => 'menu_order',
          'order' => 'ASC',
          'posts_per_page' =>999
        ));

        $output .= (new ShortcodeTemplates('Kutyafajtak'))->load_template(array(
          'data' => $data
        ));

        $output .= '</div>';

        /* Return the output of the tooltip. */
        return apply_filters( self::SCTAG, $output );
    }

}

new KutyafajtakGridSC();

?>

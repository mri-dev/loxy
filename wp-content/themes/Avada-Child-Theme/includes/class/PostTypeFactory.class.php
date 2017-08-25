<?php

class PostTypeFactory
{
	public $post_name_tag 		= null;
	public $post_name_singular 	= null;
	public $post_name_plural 	= null;
	public $textdomain 			= null;
	public $post_icon 			= 'warning';
	public $setted_labels 		= array();
	public $setted_tax_labels 	= array();
	public $taxonomies 			= array();
	public $metabox_cb 			= null;

	public function __construct( $name_tag )
	{
		$this->post_name_tag = $name_tag;
	}

	public function set_name( $singular, $plural )
	{
		$this->post_name_singular 	= $singular;
		$this->post_name_plural 	= $plural;
	}

	public function set_textdomain( $name )
	{
		$this->textdomain = $name;
	}

	public function set_labels( $labels = array() )
	{
		$this->setted_labels = $labels;
	}

	public function set_tax_labels( $labels = array() )
	{
		$this->setted_tax_labels = $labels;
	}

	public function set_icon($name)
	{
		$this->post_icon = $name;
	}

	public function set_metabox_cb($function)
	{
		$this->metabox_cb = $function;
	}

	public function create()
	{
		$this->register_type();
	}

	public function add_taxonomy( $tax_tag, $tax )
	{
		$this->taxonomies[$tax_tag] = $tax;
	}

	private function get_specify_label( $set, $label, $default )
	{
		if (array_key_exists($label, $set)) {
			return $set[$label];
		}

		return $default;
	}

	private function register_type()
	{
		if (!$this->post_name_singular) return false;
		if (!$this->post_name_plural) return false;
		if (!$this->textdomain) return false;

		$labels = array(
			'name'               => sprintf( __( '%s', $this->textdomain ), $this->post_name_plural ),
	        'singular_name'      => sprintf( __( '%s', $this->textdomain ), $this->post_name_singular),
	        'menu_name'          => sprintf( __( '%s', $this->textdomain ), $this->post_name_plural ),
	        'all_items'          => sprintf( __( '%s', $this->textdomain ), $this->post_name_plural ),
	        'add_new'            => sprintf( __( $this->get_specify_label($this->setted_labels, 'add_new', 'Add New'), $this->textdomain), $this->post_name_singular ),
	        'add_new_item'       => sprintf( __( $this->get_specify_label($this->setted_labels, 'add_new_item', 'Add New %s'), $this->textdomain), $this->post_name_singular ),
	        'edit_item'          => sprintf( __( $this->get_specify_label($this->setted_labels, 'edit_item', 'Edit %s'), $this->textdomain ), $this->post_name_singular ),
	        'new_item'           => sprintf( __( $this->get_specify_label($this->setted_labels, 'new_item', 'New %s'), $this->textdomain ), $this->post_name_singular ),
	        'view_item'          => sprintf( __( $this->get_specify_label($this->setted_labels, 'view_item', 'View %s'), $this->textdomain ), $this->post_name_singular ),
	        'search_items'       => sprintf( __( $this->get_specify_label($this->setted_labels, 'search_items', 'Search %s'), $this->textdomain ), $this->post_name_plural ),
	        'not_found'          => sprintf( __( $this->get_specify_label($this->setted_labels, 'not_found', 'No %s found'), $this->textdomain ), $this->post_name_plural ),
	        'not_found_in_trash' => sprintf( __( $this->get_specify_label($this->setted_labels, 'not_found_in_trash', 'No %s found in Trash'), $this->textdomain ), $this->post_name_plural ),
	        'parent_item_colon'  => sprintf( __( $this->get_specify_label($this->setted_labels, 'parent_item_colon', 'Parent %s:'), $this->textdomain ), $this->post_name_singular )
		);

		$arg = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'capability_type' => 'page',
			'menu_icon' => 'dashicons-'.$this->post_icon,
			'has_archive' => true,
			'hierarchical' => false,
			'rewrite' => array( 'slug' => $this->post_name_tag )
		);

		if ($this->metabox_cb && function_exists($this->metabox_cb)) {
			$arg['register_meta_box_cb'] = $this->metabox_cb;
		}

		register_post_type(
				$this->post_name_tag,
		    $arg
		);

		flush_rewrite_rules();

		$this->register_taxonomies();
	}

	private function register_taxonomies( )
	{
		if( !$this->taxonomies ) return false;

		foreach ($this->taxonomies as $tax_key => $tax)
		{

			$lab_def = array(
				'name' 				=> sprintf( __( '%s %s', $this->textdomain ), $this->post_name_singular, $tax['name'][1] ),
				'singular_name' 	=> sprintf( __( $this->get_specify_label($tax['labels'], 'singular_name', 	$this->post_name_singular.' Category'), $this->textdomain), $tax['name'][0] ),
				'search_items' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'search_items', 	'Search '.$this->post_name_singular.' Categories'), $this->textdomain), $tax['name'][1] ),
				'all_items' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'all_items', 		'All '.$this->post_name_singular.' Categories'), $this->textdomain), $tax['name'][1] ),
				'parent_item' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'parent_item', 	'Parent '.$this->post_name_singular.' Category'), $this->textdomain), $tax['name'][0] ),
				'parent_item_colon' => sprintf( __( $this->get_specify_label($tax['labels'], 'parent_item_colon', 'Parent '.$this->post_name_singular.' Category:'), $this->textdomain), $tax['name'][0] ),
				'edit_item' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'edit_item', 		'Edit '.$this->post_name_singular.' Category'), $this->textdomain), $tax['name'][0] ),
				'update_item' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'update_item', 	'Update '.$this->post_name_singular.' Category'), $this->textdomain), $tax['name'][0] ),
				'add_new_item' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'add_new_item', 	'Add New '.$this->post_name_singular.' Category'), $this->textdomain), $tax['name'][0] ),
				'new_item_name' 	=> sprintf( __( $this->get_specify_label($tax['labels'], 'new_item_name', 	'New '.$this->post_name_singular.' Category Name'), $this->textdomain), $tax['name'][0] ),
				'menu_name' 		=> sprintf( __( $this->get_specify_label($tax['labels'], 'menu_name', 		''.$this->post_name_singular.' Categories'), $this->textdomain), $tax['name'][1] ),
			);

			$labels = $lab_def;

			register_taxonomy(
				$tax_key,
				$this->post_name_tag,
				array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => true,
				// This array of options controls the labels displayed in the WordPress Admin UI
				'labels' => $labels,
				// Control the slugs used for this taxonomy
				'rewrite' => array(
					'slug' => $tax['rewrite'], // This controls the base slug that will display before each term
					'with_front' => false, // Don't display the category base before "/locations/"
					'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
				),
			));

		}
	}
}

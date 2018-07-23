<?php

function make_fields($section,$fields){

	//TEXT AREA CONTROL
		if ( !class_exists('WP_Customize_Textarea_Control') ){

			class WP_Customize_Textarea_Control extends WP_Customize_Control {
			
			public $type = 'textarea';

				// Render the content
				public function render_content() {
					?>
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo $this->description; ?></span>
						<?php endif; ?>
						<textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
							<?php echo esc_textarea( $this->value() ); ?>
						</textarea>
					</label>
					<?php
				}

			}//class end

		}//if class doesn't exist end

	global $wp_customize;
	$section_lbl = str_replace(array('-','_'), ' ', $section);
	$section_lbl = ucwords($section_lbl);

	$wp_customize->add_section( $section , array(
	    'title'      => __( $section_lbl, 'mytheme' ),
	    'priority'   => 30,
		) );

	foreach ($fields as $label => $type) {

			$label = str_replace(array('-','_'), ' ', $label);
			$label = ucwords($label);

			$setting = str_replace(array(' ','-'), '_', $label);
			$setting = strtolower($setting);

		  	$wp_customize->add_setting( $setting , array(
			    'default'     => '',
			    'transport'   => 'refresh',
			) );

			$info = array(
				'label'      => __( $label, 'mytheme' ),
				'section'    => $section,
				'settings'   => $setting,
			);

			if($type == 'Control'){

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting, $info ) );

			}elseif($type == 'Color_Control'){

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, $info ) );

			}elseif($type == 'Upload_Control'){

				$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $setting, $info ) );

			}elseif($type == 'Image_Control'){

				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, $info ) );

			}elseif($type == ''){

				$wp_customize->add_control( new WP_Customize_Background_Image_Control( $wp_customize, $setting, $info ) );

			}elseif($type == 'Header_Image_Control'){

				$wp_customize->add_control( new WP_Customize_Header_Image_Control( $wp_customize, $setting, $info ) );

			}elseif($type == 'Text_Area_Control'){

				$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, $setting, $info ) );

			}//end if

	}//foreach end


};

	function contact(){
		/*
			TYPES OF CONTROLS
				Control 		text
				Color_Control 	color
				Upload_Control  file upload
				Image_Control 	image upload or picker
		*/

		make_fields(
		//name of section
			'contact',
		//array of fields
			array(
				//name of field => type_of_control from list above
				'street_address' => 'Control',
				'city' => 'Control',
				'state' => 'Control',
				'zip' => 'Control',
				'phone' => 'Control',
				'fax' => 'Control',
				'free_phone' => 'Control',
				'email' => 'Control',
				)
		);//make_fields end

	}//address_fields end

	function mission(){
		make_fields(
			'mission',
			array(
				'mission' => 'Control',
			)
		);
	}

	function copyright(){
		make_fields(
			'copyright',
			array(
				'copyright' => 'Control',
			)
		);
	}

	function personify(){
		make_fields(
			'personify',
			array(
				'personify_login_url' => 'Control',
				//'personify_meetings_url' => 'Control',
				'number_of_homepage_meetings' => 'Control',
			)
		);
	}

	function post_footer(){
		make_fields(
			'post_footer',
			array(
				'post_footer' => 'Control',
			)
		);
	}

	function social(){
		make_fields(
			'social',
			array(
				'twitter' => 'Control',
				'facebook' => 'Control',
				'youtube' => 'Control',
			)
		);
	}

	function the_404_page(){
		make_fields(
			'the_404_page',
			array(
				'the_404_page_headline' => 'Control',
				'the_404_page_body' => 'Text_Area_Control',

			)
		);
	}


//Add any functions names here
	$sections = array(
		'contact',
		'copyright',
		'mission',
		'social',
		'personify',
		'post_footer',
		'the_404_page',
		);




	foreach ($sections as $section) {

		add_action( 'customize_register', $section );

	}

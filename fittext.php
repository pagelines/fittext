<?php
/*
Plugin Name: FitText Section Example
Author: PageLines
Author URI: http://www.pagelines.com
Version: 1.0.1
Description: A simple section that creates text that sizes to fit the container, and is responsive which means it scales with different size browsers.
Class Name: FitTextSection
PageLines: true
Section: true
*/


/**
 * IMPORTANT
 * This tells wordpress to not load the class as DMS will do it later when the main sections API is available.
 * If you want to include PHP earlier like a normal plugin just add it above here.
 */
if( ! class_exists( 'PageLinesSection' ) )
	return;

/**
 * Start of section class.
 */
class FitTextSection extends PageLinesSection {

	/**
	 * Enqueue the javascript file.
	 */
	function section_scripts(){				
		wp_enqueue_script('fittext', $this->base_url . '/jquery.fittext.js', array( 'jquery' ), PL_CORE_VERSION, true );
	}

	/**
	 * Print section javascript into page HEAD area.
	 */
	function section_head(){
		
		$prefix = $this->prefix();		
		$throttle = ( $this->opt('fittext-throttle') ) ? $this->opt( 'fittext-throttle' ) : .7;		
		?>		
<script type="text/javascript">
/*<![CDATA[*/ 
jQuery(document).ready(function(){ 
	<?php printf("jQuery('%s .fittext').fitText(%s);", $prefix, $throttle); ?>
});
/*]]>*/
</script>
		<?php 		
		echo load_custom_font( $this->opt( 'fittext-font' ), $prefix . ' .fittext' );	
	}

	/**
	 * Register section options.
	 */
	function section_opts() {
		
		$opts = array(

			array(
				'title'		=> 'FitText Options',
				'type'		=> 'multi',
				'opts'		=> array(

			array(
				'key'	=> 'fittext-text',
				'type'	=> 'text',
				'label'	=> 'FitText Text',
				'default'	=> 'Hello World!'
				),
				
			array(
				'key'	=> 'fittext-font',
				'type'	=> 'fonts',
				'label'	=> 'Choose Font'
				),

			array(
				'key'	=> 'fittext-throttle',
				'type'	=> 'select_same',
				'label'	=> 'Throttle Factor (Between 0 and 1)',
				'default'	=> 0.7,
				'opts'	=> $this->throttle_opts()
					
					)
				)
			)
		);
	return $opts;
	}	

	/**
	 * Actual section template.
	 */
	function section_template(){

		$args = array(); 
		$args['default'] = 'Hello World!';
		
		?> 
		<div class="fittext-container">
			<h2 class="fittext" data-sync="fittext-text">
				<span><?php echo $this->opt('fittext-text', $args); ?></span>
			</h2>
		</div>
		<?php	
	}

	/**
	 * Return an array of numbers, 0.1,0.2 etc
	 */
	function throttle_opts() {		
		return range( 0.1, 1.0, 0.1 );		
	}
}

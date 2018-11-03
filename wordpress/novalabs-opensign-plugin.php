<?php
/**
 * Plugin Name:   Novalabs Opensign
 * Description:   Adds an open close indicator for Nova Labs.
 * Version:       1.1.3
 * Author:        John Hoskins
 * 
 * Format text is a test of adding formatting changes as without reuploading
 */

class novalabs_Opensign extends WP_Widget {


  // Set up the widget name and description.
  public function __construct() {
    $widget_options = array( 
		'classname' => 'opensign', 
		'description' => 'This Widget give the door status', 
	);
    parent::__construct( 'opensign', 'Novalabs Opensign Widget', $widget_options );
  }


 
  public function widget( $args, $instance ) {
	  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
	  $format_text = apply_filters( 'widget_format_text', $instance[ 'format_text' ] );
	  
	  $url= "https://event.nova-labs.org/events/novalabs_space/latest";

	  //  Initiate curl
	  $ch = curl_init();
	  // Disable SSL verification
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  // Will return the response, if false it print the response
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  // Set the url
	  curl_setopt($ch, CURLOPT_URL,$url);
	  // Execute
	  $result=curl_exec($ch);
	  // Closing
	  curl_close($ch);

	  $json = json_decode($result,true);
	  
	  //add logic here
	  if (($json != null) && isset($json["value"])){
		  $dt = new DateTime();
		  $dt->setTimestamp($json['epochMillis']/1000);
		  $dt->setTimeZone(new DateTimeZone('America/New_York'));
		  
		  $status_text = strtoupper($json["value"]);
		  
		  $date_text = $dt->format("M j G:i");
		  
		  if ($status_text =='OPEN')
			  $status_color = 'green';
		  elseif ($status_text =='ASSOCIATE'){
			  $status_text =='ASSOCIATES ONLY';
		      $status_color = '#FFA500';
		  }
		  elseif ($status_text =='CLOSED')
			  $status_color = 'red';
		  else
			  $status_color = 'orange';
		  
	  }else{
		  $status_text = 'ERROR';
		  $date_text = '';
		  $status_color = 'red';
		  
	  }

      $button = "<a class=\"button  button_size_2 button_js\" style=\"background-color: " . $status_color . "\">";
      $button = $button . "<span class=\"button_label\" " . $format_text . ">";
      $button = $button . $status_text . "<br>" . $date_text . "</span>";
	  $button = $button  . "</a>";

	  echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 	  
	  echo $button;
	  echo $args['after_widget'];
  }


  
  // Create the admin area widget settings form.
  public function form( $instance ) {
	  
	  
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
	$format_text = ! empty( $instance['format_text'] ) ? $instance['format_text'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	  <label for="<?php echo $this->get_field_id( 'format_text' ); ?>">Extra format text:</label>
	  <input type="text" id="<?php echo $this->get_field_id( 'format_text' ); ?>" name="<?php echo $this->get_field_name( 'format_text' ); ?>" value="<?php echo esc_attr( $format_text ); ?>" />
    </p><?php
  }


  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
	$instance[ 'format_text' ] = strip_tags( $new_instance[ 'format_text' ] );
    return $instance;
  }

}

// Register the widget.
function register_novalabs_Opensign_widget() { 
  register_widget( 'novalabs_Opensign' );
}

add_action( 'widgets_init', 'register_novalabs_Opensign_widget' );

?>
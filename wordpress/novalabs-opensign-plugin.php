<?php
/**
 * Plugin Name:   Novalabs Opensign
 * Description:   Adds an open close indicator for Nova Labs.
 * Version:       1.0
 * Author:        John Hoskins
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
		  elseif ($status_text =='CLOSED')
			  $status_color = 'red';
		  else
			  $status_color = 'orange';
		  
	  }else{
		  $status_text = 'ERROR';
		  $date_text = '';
		  $status_color = 'red';
		  
	  }

      $button ="<button type=\"button\" class=\"btn\" style=\"background-color: " . $status_color . "\">";
      $button = $button . $status_text . "<br>" . $date_text . "</button>";

	  echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 	  
	  echo $button;
	  echo $args['after_widget'];
  }


  
  // Create the admin area widget settings form.
  public function form( $instance ) {
	  
	  
    $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p><?php
  }


  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    return $instance;
  }

}

// Register the widget.
function register_novalabs_Opensign_widget() { 
  register_widget( 'novalabs_Opensign' );
}

add_action( 'widgets_init', 'register_novalabs_Opensign_widget' );

?>
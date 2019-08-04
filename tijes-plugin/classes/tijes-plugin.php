<?php
  use PhpAmqpLib\Connection\AMQPStreamConnection;
  use PhpAmqpLib\Message\AMQPMessage;

  class TijesPlugin {
    private static $activated = false;

    public static function init() {

      if(!self::$activated) {
        self::plug_hooks();
      }

    }

    public static function plug_hooks() {
      self::$activated = true;

      add_action( 'wp_ajax_ibl_analytics_event', array('TijesPlugin', 'ibl_analytics_event_handler'));
      add_action( 'wp_ajax_nopriv_ibl_analytics_event', array('TijesPlugin', 'ibl_analytics_event_handler') );

      self::setup_tije_script();
      add_shortcode('tije_script', array('TijesPlugin', 'tije_script_handler'));
    }
    
    public static function tije_script_handler() {
      ob_start();
      include TIJES_PLUGIN__PLUGIN_DIR . "inc/partials/event_trigger.html.php";
      return ob_get_clean();
    }

    public static function setup_tije_script() {
      $user_obj = wp_get_current_user();

      if(0 ==  $user_obj->ID) {
        $current_user = null;
      } else {
        $current_user = $user_obj->data;
      }

      wp_register_script( 'tije_script_handle', plugins_url( 'inc/js/tijeScript.js', dirname(__FILE__) ), array('jquery'));

      $translation_array = array(
          'ajaxurl' => admin_url( 'admin-ajax.php'),
          'wp_nonce' => wp_create_nonce( 'wp_ajax_ibl_analytics_event' ),
          "me" => $current_user
      );

      wp_localize_script( 'tije_script_handle', 'ajax_object', $translation_array );

      wp_enqueue_script( 'tije_script_handle' );
    }

    public static function ibl_analytics_event_handler() {
      check_ajax_referer( 'wp_ajax_ibl_analytics_event', 'security', true );

      $connection = new AMQPStreamConnection(getenv('RABBITMQ_HOST'), 5672, getenv('RABBITMQ_USER'), getenv('RABBITMQ_PASSWORD'));
      $channel = $connection->channel();

      $channel->queue_declare('ibl_analytics_event', false, false, false, false);

      $msg = new AMQPMessage('"'.$_POST['payload'].'"');
      $channel->basic_publish($msg, '', 'ibl_analytics_event');

      echo " [x] Sent ".$_POST['payload']."\n";

      $channel->close();
      $connection->close();

      wp_die();
    }

    public static function plugin_activation() {
      // exit;
    }

    public static function plugin_deactivation() {
      // exit;
    }
  }
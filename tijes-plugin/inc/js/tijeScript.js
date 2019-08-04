jQuery(document).ready(function($) {
  function iblAnalyticsEvent() {
    if(ajax_object.me) {
      $.post(ajax_object.ajaxurl, {
        action: "ibl_analytics_event",
        payload: JSON.stringify(ajax_object.me),
        security: ajax_object.wp_nonce
      }, function(response) {
        console.log(response);
      })
    } else {
      console.log("You must be logged in to send event")
    }
  }

  window.iblAnalyticsEvent = iblAnalyticsEvent;
})
<?php
/**
 * @package TimeCraft
 * @version 1.0
 */
/*
Plugin Name: TimeCraft
Plugin URI: http://github24.com/brainhub24/Wordpress-TimeCraft/
Description: Get real-time updates in your WordPress dashboard. It automatically updates the time every second, including seconds and additional information.
Author: Brainhub24
Version: 1.0
Author URI: http://brainhub24.com
*/

/**
 * Enqueues jQuery for AJAX functionality.
 *
 * @return void
 */
function timecraft_enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'timecraft_enqueue_jquery');

/**
 * Displays the current date and time in a professional format.
 *
 * @return void
 */
function __timecraft__() {
    $lang = '';
    // Check the user's locale and apply the appropriate language attribute if not English.
    if ('en_' !== substr(get_user_locale(), 0, 3)) {
        $lang = ' lang="en"';
    }

    // Output the HTML structure for the time display.
    echo '<div id="__timecraft__">';
    echo '<span class="screen-reader-text">' . __('TimeCraft:', 'timecraft') . '</span>';
    echo '<span dir="ltr" class="tc-content"></span>';
    echo '</div>';
    ?>
    <script type="text/javascript">
        /**
         * Updates the displayed time every second.
         *
         * @return void
         */
        function TimeCraft() {
            var now = new Date();
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var day = days[now.getDay()];
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // 0 should be 12
            var month = now.toLocaleString('default', { month: 'long' });
            var date = now.getDate();
            var year = now.getFullYear();

            // Display the updated time in the HTML element with the class "tc-content".
            jQuery('.tc-content').text(
                day + ', ' + month + ' ' + date + ', ' + year + ' ' + hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds + ' ' + ampm
            );
        }

        // Update the time every second using the TimeCraft function.
        setInterval(TimeCraft, 1000);
        TimeCraft(); // Initial call to display the time immediately.
    </script>
    <?php
}

// This action will display the date and time when the admin_notices action is called.
add_action('admin_notices', '__timecraft__');

/**
 * Adds CSS to style the date and time display.
 *
 * @return void
 */
function __timecraft___css() {
    // Add CSS styles to format the time display.
    echo "
    <style type='text/css'>
    #__timecraft__ {
        float: right;
        padding: 10px;
        font-size: 16px;
        color: #333;
    }
    .rtl #__timecraft__ {
        float: left;
    }
    .block-editor-page #__timecraft__ {
        display: none;
    }
    @media screen and (max-width: 782px) {
        #__timecraft__,
        .rtl #__timecraft__ {
            float: none;
            padding-left: 0;
            padding-right: 0;
        }
    }
    </style>
    ";
}

// Add the CSS when admin_head action is called.
add_action('admin_head', '__timecraft___css');

<?php 

/**
 * @file
 * SimpleGA4 plugin main file.
 */

class SimpleGA4Plugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'install', 
        'uninstall', 
        'config_form', 
        'config',     
        'public_head'
    );

    public function hookInstall()
    {
        set_option('simple_ga4_tracking_id', '');
    }

    public function hookUninstall()
    {
        delete_option('simple_ga4_tracking_id');
    }

    public function hookConfigForm()
    {
        $trackingId = get_option('simple_ga4_tracking_id');
        echo "<div class='field'>";
        echo "<label for='simple_ga4_tracking_id'>Google Analytics Tracking ID</label>";
        echo "<input type='text' name='simple_ga4_tracking_id' id='simple_ga4_tracking_id' value='$trackingId'>";
        echo "</div>";
    }

    public function hookConfig()
    {
        $trackingId = $_POST['simple_ga4_tracking_id'];
        set_option('simple_ga4_tracking_id', $trackingId);
    }

    public function hookPublicHead()
    {
        $trackingId = get_option('simple_ga4_tracking_id');
        if ($trackingId) {
            echo <<<EOT
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$trackingId}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{$trackingId}');
</script>
EOT;
        }
    }
}

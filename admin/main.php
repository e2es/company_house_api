<?php

$key = get_option('e2es_ch_settings');

add_action('admin_menu', 'e2es_ch_setup_menu');

function e2es_ch_setup_menu()
{
    add_submenu_page('options-general.php','Company House','Company House','manage_options','e2es_ch',function() {
        require_once (plugin_dir_path(__FILE__) . 'view/settings/index.php');
        e2es_scripts();
    });

}

function e2es_codemirror_enqueue_scripts($hook) {
    $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
    wp_localize_script('jquery', 'cm_settings', $cm_settings);

    wp_enqueue_script('wp-theme-plugin-editor');
    wp_enqueue_style('wp-codemirror');
}

function e2es_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-js', plugins_url('/assets/js/custom.js', __FILE__));
    wp_enqueue_style('custom-css', plugins_url('/assets/css/custom.css', __FILE__));
    wp_localize_script( 'ajax-script', 'e2es_ch_ajax',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	


        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        wp_localize_script('jquery', 'cm_settings', $cm_settings);

        wp_enqueue_script('wp-theme-plugin-editor');
        wp_enqueue_style('wp-codemirror');
	
    add_action('wp_enqueue_scripts', 'e2es_codemirror_enqueue_scripts');
}


add_action( 'wp_enqueue_scripts', 'e2es_scripts' );


add_action('admin_init', 'e2es_ch_settings_init');
function e2es_ch_settings_init()
{
    register_setting('chPlugin', 'e2es_ch_settings');

    add_settings_section(
        'e2es_ch_plugin_section',
        'Company House Management',
        null,
        'e2es_ch'
    );
}




add_action('wp_footer', 'e2es_ch_admin_ajax_js');
function e2es_ch_admin_ajax_js()
{ ?>
    <script type="text/javascript">
        function e2es_ch_query({q}) {
            const body = new FormData();
            body.append('action', 'e2es_ch_query');
            body.append('q', q);

            return fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body,
            }).then((response) => response.text());
        }
    </script>
    <?php
}

add_action('wp_ajax_e2es_ch_query', 'e2es_ch_query');
add_action('wp_ajax_nopriv_e2es_ch_query', 'e2es_ch_query');
function e2es_ch_query()
{
    $options = get_option('e2es_ch_settings');


    $url = 'https://api.company-information.service.gov.uk/search/companies';
	$compName = $_POST['q'];
	$fnStr = fn (string $x) => trim(str_replace(['LTD', 'LTD.', 'LIMITED', 'LIMITED.', 'LLP', 'LLP.'], '', mb_strtoupper($x)));
	$compNameSearch = $fnStr($compName);

    $q = http_build_query([
        'q' => $compNameSearch,
		'restrictions' => 'active-companies legally-equivalent-company-name'
    ]);

    $auth = base64_encode($options['e2es_ch_key']);

    try {
        $req = wp_remote_get("{$url}?{$q}", ['headers' => [
            'accept'=>'application/json',
            'Authorization' => 'Basic '.$auth]]);

        $body = json_decode($req['body'], true, 512, JSON_THROW_ON_ERROR);
		
		var_dump($body['total_results']);
		
		if($body['total_results'] > 0) {
			echo '<div class="alert-danger" style="padding: 10px;
    color: #d11522;
    background: #f2c2c5;
    border-left: 5px solid #d11522;">'.sprintf($options['e2es_ch_unavailable'],$compName).'</div>';
		} else {
			echo '<div class="alert-info" style="padding: 10px;
    background: #dae8f2;
    border-left: 5px #005c9f solid;">'.sprintf($options['e2es_ch_available'],$compName).'</div>';
		}

		//$numMatches = array_reduce($body['items'] ?? [], fn (int $count, array $item) => $fnStr($item['company_name']) === $compNameSearch ? ($count + 1) : $count, 0);

        
    } catch(Throwable $ex) {
        echo '<div class="alert-danger" style="padding: 10px;
    color: #d11522;
    background: #f2c2c5;
    border-left: 5px solid #d11522;">Something went wrong, please try again.</div>';
    }
    wp_die();
}    

function chk_ch(){
    $options = get_option('e2es_ch_settings');
    if(!$options['e2es_ch_key']) {
        if(current_user_can('administrator')) {
            return <<<HTML
This plugin does not have an API Key. This message is only visible to admins.
HTML;

        }
        return false;
    }
    return <<<HTML
		<form action="" class="e2es_ch_holder e2es-ch-form" method="post">
		<div class="display_ch" style="margin-bottom: 1rem"></div>
		<input type="text" class="e2es_ch_q" name="e2es_ch_q"/>
		<button type="submit">Test it</button>
		</div>
		HTML;
}

add_shortcode('e2es_ch', 'chk_ch');

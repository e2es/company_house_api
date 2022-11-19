<?php

	$tabList =[
		[
            'tabName' => 'general',
            'displayName' => 'General Settings'
        ]
	];
$options = get_option('e2es_ch_settings');
?>
<div class="wrap">
    <h2>Company House API Management</h2>
    <div class="e2es-content-wrapper">
        <div class="e2es-content-main">
		<?php settings_errors(); ?>
		<?php $active_tab = array_search($_GET['tab'], array_column($tabList, 'tabName')) !== false ? $_GET['tab'] : 'general';
?>
		<h2 class="nav-tab-wrapper">
            <?php foreach($tabList as $tl) { ?>
                <a href="?page=e2es_ch&tab=<?=$tl['tabName']?>" class="nav-tab <?=$active_tab == $tl['tabName'] ? 'nav-tab-active' : ''?>"><?=$tl['displayName']?></a>
            <?php } ?>
	</h2>

<?php
   include(plugin_dir_path(__FILE__) . sprintf('%s.php',$active_tab));

?>
    </div>
    <div class="e2es-content-side">

    </div>
</div>


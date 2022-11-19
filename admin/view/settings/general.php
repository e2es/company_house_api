<form action='options.php' method='post'>
    <h2>Company House API</h2>

            <?php
            $key = get_option('e2es_ch_settings');
            settings_fields('chPlugin');
            do_settings_sections('chPlugin');
            ?>

<div class="wrap">
    <table class="form-table" role="presentation">
        <tbody>
        <tr>
            <th scope="row">Company House Key</th>
            <td><input type="text" value="<?= $key['e2es_ch_key'] ?>" name="e2es_ch_settings[e2es_ch_key]"/></td>
        </tr>

						<tr>
			<th scope="row">Company Available</th>
				
            <td>
				<textarea name="e2es_ch_settings[e2es_ch_available]" id="e2es-ch-available" class="widefat nice-editor" rows="8"  <?=(! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : '' ?>><?= $key['e2es_ch_available'] ?></textarea>
            Utilise <code>%s</code> and it will be replaced with the company name they entered.
				</td>
			</tr>
			
									<tr>
			<th scope="row">Company Unavailable</th>
				
            <td>
				<textarea name="e2es_ch_settings[e2es_ch_unavailable]" id="e2es-ch-unavailable" class="widefat nice-editor" rows="8"  <?=(! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : '' ?>><?= $key['e2es_ch_unavailable'] ?></textarea>
            Utilise <code>%s</code> and it will be replaced with the company name they entered.
				</td>
			</tr>
			
                
        </tbody>
    </table>
    <?php submit_button(); ?>
	    <script>
        jQuery(document).ready(function($) {
            wp.codeEditor.initialize($('#e2es-ch-available'), cm_settings);
            wp.codeEditor.initialize($('#e2es-ch-unavailable'), cm_settings);
        })
    </script>
	</div>
</form>
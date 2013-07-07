<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new stag_shortcodes( $popup );

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="stag-popup">

	<div id="stag-shortcode-wrap">

		<div id="stag-sc-form-wrap">

			<div id="stag-sc-form-head">

				<?php echo $shortcode->popup_title; ?>

			</div>
			<!-- /#stag-sc-form-head -->

			<form method="post" id="stag-sc-form">

				<table id="stag-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button button-primary button-large stag-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#stag-sc-form-table -->

			</form>
			<!-- /#stag-sc-form -->

		</div>
		<!-- /#stag-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#stag-shortcode-wrap -->

</div>
<!-- /#stag-popup -->

</body>
</html>
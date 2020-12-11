<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url() ); ?>" _lpchecked="1">
	<fieldset>
		<input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>">
		<input type="submit" value="<?php esc_attr_e( 'Search', 'schema-lite' ); ?>" />
	</fieldset>
</form>

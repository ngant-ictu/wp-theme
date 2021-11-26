<?php if( !swg_options( 'disable_search' ) ) : ?>
<div class="top-form top-search">
	<div class="icon-search"><i class="fa fa-search" aria-hidden="true"></i></div>
	<div class="topsearch-entry">
		<?php get_template_part('templates/searchform'); ?>
	</div>
</div>
<?php endif; ?>
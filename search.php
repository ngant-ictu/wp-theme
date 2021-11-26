<?php get_header(); ?>

<?php kontruk_breadcrumb_title(); ?>
<div class="container">
	<?php
		$kontruk_post_type = isset( $_GET['search_posttype'] ) ? $_GET['search_posttype'] : '';
		if( ( $kontruk_post_type != '' ) &&  locate_template( 'templates/search-' . $kontruk_post_type . '.php' ) ){
			get_template_part( 'templates/search', $kontruk_post_type );
		}else{ 
			if( have_posts() ){
		?>
			<div class="blog-content content-search">
		<?php 
			while (have_posts()) : the_post(); 
			global $post;
			$post_format = get_post_format();
		?>
			<div id="post-<?php the_ID();?>" <?php post_class( 'theme-clearfix' ); ?>>
				<div class="entry clearfix">
					<?php if (get_the_post_thumbnail()){?>
					<div class="entry-thumb pull-left">
						<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">			
							<?php the_post_thumbnail("thumbnail")?>
						</a>
					</div>
					<?php }?>
					<div class="entry-content">
						<div class="entry-meta">
							<span class="entry-date"><a href="<?php echo get_permalink($post->ID)?>"><?php echo get_the_date( '', $post->ID );?></a></span>
							<span class="entry-author">
								<?php esc_html_e('by', 'kontruk'); ?> <?php the_author_posts_link(); ?>
							</span>
							<span class="entry-comment">
								<a href="<?php comments_link(); ?>"><?php echo sprintf( _n( '%d Comment', '%d Comments', $post-> comment_count , 'kontruk' ), number_format_i18n( $post-> comment_count ) ); ?></a>
							</span>
							<?php if(has_tag()) :?>
								<?php the_tags( '<span class="entry-meta-link entry-meta-tag">', ', ', '</span>' ); ?>
							<?php endif;?>
						</div>
						<div class="title-blog">
							<h3>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
							</h3>
						</div>
						<div class="entry-description">
							<?php 														
								if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
									echo wp_trim_words($post->post_content, 30, '...');
								} else {
									echo wp_trim_words($post->post_content, 25, '...');
								}		
							?>
						</div>
						<div class="bl_read_more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Continue Reading','kontruk')?></a></div>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kontruk' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
					</div>
				</div>
			</div>			
		<?php endwhile; ?>
		<?php get_template_part('templates/pagination'); ?>
		</div>
	<?php
		}else{
				get_template_part('templates/no-results');
			}
		}
	?>
</div>
<?php get_footer(); ?>
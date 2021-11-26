<?php get_header(); ?>
<?php 
	$kontruk_sidebar_template =( swg_options('sidebar_blog') ) ? swg_options('sidebar_blog') : 'right';
	$kontruk_blog_styles = ( swg_options('blog_layout') ) ? swg_options('blog_layout') : 'list';
?>

<?php kontruk_breadcrumb_title(); ?>
<div class="container">
	<div class="row sidebar-row">
	
		<!-- Left Sidebar -->
		<?php $sidebar_template 		= ( swg_options('sidebar_blog') ) ? swg_options('sidebar_blog') : ''; ?>
		<?php if ( is_active_sidebar('left-blog') ):
			$kontruk_left_span_class = ( swg_options('sidebar_left_expand') ) ? 'col-lg-'.swg_options('sidebar_left_expand') : 'col-lg-3';
			$kontruk_left_span_class .= ( swg_options('sidebar_left_expand_md') ) ? ' col-md-'.swg_options('sidebar_left_expand_md') : ' col-md-3';
			$kontruk_left_span_class .= ( swg_options('sidebar_left_expand_sm') ) ? ' col-sm-'.swg_options('sidebar_left_expand_sm') : ' col-sm-4';
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($kontruk_left_span_class); ?> <?php echo esc_attr( ( $sidebar_template == 'right' ||  $sidebar_template == 'full' ) ? 'hidden' : '' ) ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>
		<?php endif; ?>
	
			<div class="single main <?php kontruk_content_blog(); ?>" >
			<?php while (have_posts()) : the_post();  ?>
			<?php $related_post_column = swg_options('sidebar_blog'); ?>
			<div <?php post_class(); ?>>
				<?php $pfm = get_post_format(); ?>
				<div class="entry-wrap">
					<div class="entry-top">
						<div class="entry-cate">
							<?php 
							$categories = get_the_category();
							$separator = '.';
							$output = '';
							if ( ! empty( $categories ) ) {
							    foreach( $categories as $category ) {
							        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( '%s', 'kontruk' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
							    }
							    echo trim( $output, $separator );
							}
							?>
						</div>
						<h1 class="entry-title clearfix"><?php the_title(); ?></h1>
						<div class="entry-meta clearfix">
							<span class="entry-date"><?php echo get_avatar( $post->post_author , 40 ); ?><a href="<?php echo get_permalink($post->ID)?>"><?php echo get_the_date( '', $post->ID );?></a></span>
							<span class="entry-author"><?php the_author_posts_link(); ?></span>
							<span class="entry-comment"><a href="<?php comments_link(); ?>"><?php echo sprintf( _n( '%d comment', '%d comments', $post-> comment_count , 'kontruk' ), number_format_i18n( $post-> comment_count ) ); ?></a></span>
						</div>
					</div>
					<?php if( $pfm == '' || $pfm == 'image' ){?>
						<?php if( has_post_thumbnail() ){ ?>
							<div class="entry-thumb single-thumb">
								<?php the_post_thumbnail('full'); ?>
							</div>
						<?php }?>
					<?php } ?>
					<div class="entry-content clearfix">
						<div class="entry-summary single-content ">
							<?php the_content(); ?>				
							<div class="clear"></div>
							<!-- link page -->
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kontruk' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>	
						</div>						
						<div class="clear"></div>
						<?php if(get_the_tag_list()) { ?>	
							<div class="single-content-bottom clearfix">
								<div class="entry-tag single-tag pull-left">
									<?php echo get_the_tag_list('',' ','');  ?>
								</div>							
								<?php kontruk_get_social() ?>
								<!-- Social -->
							</div>
						<?php } ?>
					</div>
				</div>				
				<div class="clearfix"></div> 
				<?php if( get_the_author_meta( 'description',  $post->post_author ) != '' ): ?>
				<div id="authorDetails" class="clearfix">
					<div class="authorDetail">
						<div class="avatar">
							<?php echo get_avatar( $post->post_author , 100 ); ?>
						</div>
						<div class="infomation">
							<h4 class="name-author"><?php echo get_the_author_meta( 'user_nicename', $post->post_author )?></h4>
							<p><?php the_author_meta( 'description',  $post->post_author ) ;?></p>
						</div>
					</div>
				</div> 
				<?php endif; ?>
				<div class="clearfix"></div>
				<?php
				    if ( is_singular( 'post' ) ) {
				        the_post_navigation(
				            array(
				                'next_text' => '<span class="next-post">' . esc_html__( 'Next post', 'kontruk' ) . '</span> ' .
				                    '<span class="post-title">%title</span>',
				                'prev_text' => '<span class="previous-post">' . esc_html__( 'Previous post', 'kontruk' ) . '</span> ' .
				                    '<span class="post-title">%title</span>',
				            )
				        );
				    }
				?>
				<div class="clearfix"></div>
				<!-- Comment Form -->
				<?php comments_template('/templates/comments.php'); ?>
				<!-- Relate Post -->				
			</div>
			<?php endwhile; ?>
		</div>
		
		<!-- Right Sidebar -->
		<?php if ( is_active_sidebar('right-blog') ):
			$kontruk_right_span_class = ( swg_options('sidebar_right_expand') ) ? 'col-lg-'.swg_options('sidebar_right_expand') : 'col-lg-3';
			$kontruk_right_span_class .= ( swg_options('sidebar_right_expand_md') ) ? ' col-md-'.swg_options('sidebar_right_expand_md') : ' col-md-3';
			$kontruk_right_span_class .= ( swg_options('sidebar_right_expand_sm') ) ? ' col-sm-'.swg_options('sidebar_right_expand_sm') : ' col-sm-4';
		?>
		<aside id="right" class="sidebar <?php echo esc_attr($kontruk_right_span_class); ?> <?php echo esc_attr( ( $sidebar_template == 'left' ||  $sidebar_template == 'full' ) ? 'hidden' : '' ) ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>	
</div>
<?php get_footer(); ?>
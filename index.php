<?php get_header(); ?>
		<div id="content">
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-above" class="navigation">
					<div class="nav-previous"><span class="meta-nav">&larr;</span> Older posts</div>
					<div class="nav-next">Newer posts <span class="meta-nav">&rarr;</span></div>
				</div><!-- #nav-above -->
			<?php endif; ?>

			<?php /* If there are no posts to display, such as an empty archive page */ ?>
			<?php if ( ! have_posts() ) : ?>
				<div id="post-0" class="post error404 not-found">
					<h1 class="entry-title">Not Found</h1>
					<div class="entry-content">
						<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
			<?php endif; ?>
			
			<?php while ( have_posts() ) : the_post(); ?>

			<?php /* How to display posts of the Gallery format. The old way using gallery category is removed. */ ?>

				<?php if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) ) : ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

							<div class="entry-meta">
								<?php
									printf( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>',
										get_permalink(),
										get_the_date( 'c' ),
										get_the_date(),
										get_author_posts_url( get_the_author_meta( 'ID' ) ),
										sprintf( 'View all posts by %s', get_the_author() ),
										get_the_author()
									);
								?>
							</div><!-- .entry-meta -->
						</header>

						<div class="entry-content">
							<?php if ( post_password_required() ) : ?>
								<?php the_content(); ?>
							<?php else : ?>
								<?php
									$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
									if ( $images ) :
										$total_images = count( $images );
										$image = array_shift( $images );
										$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
								?>
										<div class="gallery-thumb">
											<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
										</div><!-- .gallery-thumb -->
										<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images ),
												'href="' . get_permalink() . '" title="' . sprintf( esc_attr( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
												number_format_i18n( $total_images )
											); ?></em></p>
								<?php endif; ?>
								<?php the_excerpt(); ?>
							<?php endif; ?>
						</div><!-- .entry-content -->

						<footer class="entry-utility">
						<?php if ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) : ?>
							<a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="View Galleries">More Galleries</a>
							<span class="meta-sep">|</span>
						<?php endif; ?>
							<span class="comments-link"><?php comments_popup_link( 'Leave a comment', '1 Comment', '% Comments' ); ?></span>
							<?php edit_post_link( 'Edit', '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-utility -->
					</article><!-- #post-## -->

			<?php /* How to display posts of the Aside format. The old way asides category is removed. */ ?>

				<?php elseif ( ( function_exists( 'get_post_format' ) && 'aside' == get_post_format( $post->ID ) ) ) : ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					<?php else : ?>
						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
						</div><!-- .entry-content -->
					<?php endif; ?>

						<footer class="entry-utility">
							<?php
								printf( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>',
									get_permalink(),
									get_the_date( 'c' ),
									get_the_date(),
									get_author_posts_url( get_the_author_meta( 'ID' ) ),
									sprintf( 'View all posts by %s', get_the_author() ),
									get_the_author()
								);
							?>
							<span class="meta-sep">|</span>
							<span class="comments-link"><?php comments_popup_link( 'Leave a comment', '1 Comment', '% Comments' ); ?></span>
							<?php edit_post_link( 'Edit', '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-utility -->
					</article><!-- #post-## -->

			<?php /* How to display all other posts. */ ?>

				<?php else : ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

							<div class="entry-meta">
								<?php
									printf( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>',
										get_permalink(),
										get_the_date( 'c' ),
										get_the_date(),
										get_author_posts_url( get_the_author_meta( 'ID' ) ),
										sprintf( 'View all posts by %s', get_the_author() ),
										get_the_author()
									);
								?>
							</div><!-- .entry-meta -->
						</header>

				<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
				<?php else : ?>
						<div class="entry-content">
							<?php the_content( 'Continue reading <span class="meta-nav">&rarr;</span>' ); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
						</div><!-- .entry-content -->
				<?php endif; ?>

						<footer class="entry-utility">
							<?php if ( count( get_the_category() ) ) : ?>
								<span class="cat-links">
									<?php printf( '<span class="%1$s">Posted in</span> %2$s', 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
								</span>
								<span class="meta-sep">|</span>
							<?php endif; ?>
							<?php
								$tags_list = get_the_tag_list( '', ', ' );
								if ( $tags_list ):
							?>
								<span class="tag-links">
									<?php printf( '<span class="%1$s">Tagged</span> %2$s', 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
								</span>
								<span class="meta-sep">|</span>
							<?php endif; ?>
							<span class="comments-link"><?php comments_popup_link( 'Leave a comment', '1 Comment', '% Comments' ); ?></span>
							<?php edit_post_link( 'Edit', '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-utility -->
					</article><!-- #post-## -->

					<?php comments_template( '', true ); ?>

				<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

			<?php endwhile; // End the loop. Whew. ?>

			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><span class="meta-nav">&larr;</span> Older posts</div>
					<div class="nav-next">Newer posts <span class="meta-nav">&rarr;</span></div>
				</div><!-- #nav-below -->
			<?php endif; ?>
			
		</div><!-- #content -->
		<?php get_sidebar(); ?>
<?php get_footer() ?>
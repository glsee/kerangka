<!-- header starts here -->
<!doctype html>
<?php
$lang = get_bloginfo('language');
$charset = strtolower(get_bloginfo('charset'));
?>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $lang; ?>"> <!--<![endif]-->
<head>
<meta charset="<?php echo $charset; ?>">

<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
	Remove this if you use the .htaccess -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title><?php
	/*
	* Print the <title> tag based on what is being viewed.
	*/
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( 'Page %s', max( $paged, $page ) );

?></title>

<!-- Mobile viewport optimized: j.mp/bplateviewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon/favicon.ico">
<link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon/apple-touch-icon-precomposed.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon/apple-touch-icon-72x72-precomposed.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon/apple-touch-icon-114x114-precomposed.png" />

<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

<!-- CSS: implied media="all" -->
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

<!-- More ideas for your <head> here: h5bp.com/docs/#head-Tips -->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="container">
	<header>
		<hgroup>
			<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
		<nav id="access" role="navigation">
			<h1 class="section-heading visuallyhidden">Main menu</h1>
			<div class="skip-link visuallyhidden"><a href="#content" title="Skip to content">Skip to content</a></div>
			
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-{menu slug}-container menu') ); ?>
		</nav><!-- #access -->
	</header>
	
	<div id="main" role="main">
<!-- header ends here -->
	
<!-- index starts here -->
		<div id="content">
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-above" class="navigation">
					<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older posts' ); ?></div>
					<div class="nav-next"><?php previous_posts_link( 'Newer posts <span class="meta-nav">&rarr;</span>' ); ?></div>
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
					<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older posts' ); ?></div>
					<div class="nav-next"><?php previous_posts_link( 'Newer posts <span class="meta-nav">&rarr;</span>' ); ?></div>
				</div><!-- #nav-below -->
			<?php endif; ?>
			
		</div><!-- #content -->
<!-- index ends here -->
		
<!-- sidebar starts here -->
		<aside>
			<div class="widget-area" role="complementary">
				<ul class="xoxo">
				

				<?php
					/* When we call the dynamic_sidebar() function, it'll spit out
					 * the widgets for that widget area. If it instead returns false,
					 * then the sidebar simply doesn't exist, so we'll hard-code in
					 * some default sidebar stuff just in case.
					 */
					if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

						<li id="search" class="widget-container widget_search">
							<?php get_search_form(); ?>
						</li>

						<li id="archives" class="widget-container">
							<h3 class="widget-title">Archives</h3>
							<ul>
								<?php wp_get_archives( 'type=monthly' ); ?>
							</ul>
						</li>

						<li id="meta" class="widget-container">
							<h3 class="widget-title">Meta</h3>
							<ul>
								<?php wp_register(); ?>
								<li><?php wp_loginout(); ?></li>
								<?php wp_meta(); ?>
							</ul>
						</li>

				<?php endif; // end primary widget area ?>
				
				</ul>
			</div><!-- .widget-area -->
		</aside><!-- aside -->
<!-- sidebar ends here -->
		
<!-- footer starts here -->
	</div><!-- #main -->
	
	<footer>
	<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container_class' => 'menu-{menu slug}-container menu', 'depth' => 1 ) ); ?>
	</footer>
</div> <!--! end of .container -->

<?php wp_footer(); ?>
</body>
</html>
<!-- footer ends here -->
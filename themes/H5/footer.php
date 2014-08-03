		<div class="footer">
			<p>
				&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a> 
				&bull; <a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)', 'h5'); ?></a> 
				&bull; <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)', 'h5'); ?></a> 
			</p>
		</div>
		
		<?php wp_footer(); ?>

	</body>
</html>
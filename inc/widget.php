<?php
/**
 * 小工具：文章
 */
class Vmeng_widget_posts_list extends WP_Widget{

	//默认设置
	public $default_instance = array();

	//初始化
	function __construct(){
		parent::__construct(
			'posts_list',
			 __( 'Vmeng 文章', 'Vmeng' ),
			array( 'description' => __( '根据设置可以显示不同的文章', 'Vmeng' ) )
		);
		$this->default_instance = array(
			'title'         => __( 'Vmeng 文章', 'Vmeng' ),
			'orderby'       => 'date',
			'descending'    => true,
			'number'        => 3,
			'thumbnail'     => true,
			'date_limit'    => 'unlimited',
			'exclude_posts' => array(),
			'exclude_tax'   => array()
		);
	}

	//小工具内容
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
			$query_args = array(
				'ignore_sticky_posts' => true,
				'orderby'             => $instance['orderby'],
				'order'               => $instance['descending'] ? 'DESC' : 'ASC',
				'posts_per_page'      => $instance['number'],
				'post__not_in'        => $instance['exclude_posts']
			);
			if( $instance['date_limit'] != 'unlimited' ) $query_args['date_query'] = array( 'after' => $instance['date_limit'] );
			if( !empty( $instance['exclude_tax'] ) ){
				$query_args['tax_query'] = array( 'relation' => 'AND' );
				foreach( $instance['exclude_tax'] as $tax => $term ) $query_args['tax_query'][] = array(
					'taxonomy' => $tax,
					'field'    => 'id',
					'terms'    => $term,
					'operator' => 'NOT IN'
				);
			}
			Vmeng_sidebar_posts_list( $query_args );
		echo $args['after_widget'];
	}

	//保存设置选项
	function update( $new_instance, $old_instance ){
		$instance = array();
		
		//标题
		$instance['title'] = strip_tags( $new_instance['title'] );

		//文章排序
		$all_orderby = array( 'date', 'comment_count', 'views', 'rand' );
		$instance['orderby'] = in_array( $new_instance['orderby'], $all_orderby ) ? $new_instance['orderby'] : 'date';

		//倒序排列
		$instance['descending'] = !empty( $new_instance['descending'] );

		//文章数量
		$instance['number'] = absint( $new_instance['number'] );
		if( $instance['number'] === 0 ) $instance['number'] = 1;

		//显示缩略图
		$instance['thumbnail'] = !empty( $new_instance['thumbnail'] );

		//日期限制
		$all_date_limit = array(
			'unlimited',
			'1 day ago',
			'3 day ago',
			'1 week ago',
			'1 month ago',
			'3 month ago',
			'6 month ago',
			'1 year ago',
			'2 year ago',
			'3 year ago'
		);
		$instance['date_limit'] = in_array( $new_instance['date_limit'], $all_date_limit ) ? $new_instance['date_limit'] : 'unlimited';

		//排除文章
		$instance['exclude_posts'] = array_map( 'absint', (array) $new_instance['exclude_posts'] );
		if( !empty( $instance['exclude_posts'] ) ) $instance['exclude_posts'] = get_posts( array(
			'post__in'               => $instance['exclude_posts'],
			'nopaging'               => true,
			'post_type'              => 'post',
			'post_status'            => array( 'publish', 'future' ),
			'fields'                 => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		) );

		//排除分类法
		$instance['exclude_tax'] = (array) $new_instance['exclude_tax'];
		foreach( $instance['exclude_tax'] as $tax_name => $tax ){
			if( !taxonomy_exists( $tax_name ) || !is_array( $tax ) || empty( $tax ) ){
				unset( $instance['exclude_tax'][$tax_name] );
				continue;
			}
			$instance['exclude_tax'][$tax_name] = (array) $instance['exclude_tax'][$tax_name];
			foreach( $instance['exclude_tax'][$tax_name] as $key => $term_id ){
				$instance['exclude_tax'][$tax_name][$key] = absint( $term_id );
				if( !term_exists( $instance['exclude_tax'][$tax_name][$key], $tax_name ) ) unset( $instance['exclude_tax'][$tax_name][$key] );
			}
			if( empty( $instance['exclude_tax'][$tax_name] ) ) unset( $instance['exclude_tax'][$tax_name] );
		}

		return $instance;
	}

	//设置表单
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );

		$orderby = array(
			'date'          => __( '发布时间', 'Vmeng' ),
			'comment_count' => __( '评论数量', 'Vmeng' ),
			'views'         => __( '浏览次数', 'Vmeng' ),
			'rand'          => __( '随机排列', 'Vmeng' )
		);

		$date_limit = array(
			'unlimited'   => __( '无限制', 'Vmeng' ),
			'1 day ago'   => __( '一天之内', 'Vmeng' ),
			'3 day ago'   => __( '三天之内', 'Vmeng' ),
			'1 week ago'  => __( '一周之内', 'Vmeng' ),
			'1 month ago' => __( '一个月之内', 'Vmeng' ),
			'3 month ago' => __( '三个月之内', 'Vmeng' ),
			'6 month ago' => __( '半年之内', 'Vmeng' ),
			'1 year ago'  => __( '一年之内', 'Vmeng' ),
			'2 year ago'  => __( '两年之内', 'Vmeng' ),
			'3 year ago'  => __( '三年之内', 'Vmeng' )
		);
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( '标题：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( '文章排序：', 'Vmeng' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<?php foreach( $orderby as $orderby_name => $orderby_title ): ?>
					<option value="<?php echo $orderby_name; ?>"<?php selected( $instance['orderby'], $orderby_name ); ?>><?php echo $orderby_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'descending' ) ); ?>"><?php _e( '倒序排列：', 'Vmeng' ); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'descending' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'descending' ) ); ?>" value="1"<?php checked( $instance['descending'] ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( '文章数量：', 'Vmeng' ); ?></label>
			<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'date_limit' ) ); ?>"><?php _e( '日期限制：', 'Vmeng' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'date_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_limit' ) ); ?>">
				<?php foreach( $date_limit as $date_code => $date_title ): ?>
					<option value="<?php echo $date_code; ?>"<?php selected( $instance['date_limit'], $date_code ); ?>><?php echo $date_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_posts' ) ); ?>"><?php _e( '排除文章：', 'Vmeng' ); ?></label>
			<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'exclude_posts' ) ); ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'exclude_posts' ) ); ?>[]">
				<?php foreach( get_posts( 'nopaging=1&post_status=publish,future' ) as $post ): ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>"<?php if( in_array( $post->ID, $instance['exclude_posts'] ) ) echo ' selected="selected"'; ?>><?php echo get_the_title( $post ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
		foreach( get_taxonomies( array( 'show_tagcloud' => true ), false ) as $tax_name => $tax ):
			if ( empty( $tax->labels->name ) || !in_array( 'post', $tax->object_type ) ) continue;
			$trems = get_terms( $tax_name, 'hide_empty=0' );
			if( is_wp_error( $trems ) ) continue;
			if( empty( $instance['exclude_tax'][$tax_name] ) ) $instance['exclude_tax'][$tax_name] = array();
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_tax' ) ) . "[$tax_name]"; ?>"><?php printf( __( '排除%s：', 'Vmeng' ), $tax->labels->name ); ?></label>
				<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'exclude_tax' ) ) . "[$tax_name]"; ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'exclude_tax' ) . "[$tax_name]" ); ?>[]">
					<?php foreach( $trems as $trem ): ?>
						<option value="<?php echo esc_attr( $trem->term_id ); ?>"<?php if( in_array( $trem->term_id, $instance['exclude_tax'][$tax_name] ) ) echo ' selected="selected"'; ?>><?php echo $trem->name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
		<?php endforeach; ?>
<?php
	}

}
register_widget( 'Vmeng_widget_posts_list' );

/**
 * 小工具：标签云
 */
class Vmeng_widget_tag_cloud extends WP_Widget{

	//默认设置
	public $default_instance = array();

	//初始化
	function __construct(){
		parent::__construct(
			'tag_cloud',
			 __( 'Vmeng 标签云', 'Vmeng' ),
			array( 'description' => __( '显示任意分类法的条款', 'Vmeng' ) )
		);
		$this->default_instance = array(
			'title'      => __( '标签云', 'Vmeng' ),
			'number'     => 45,
			'taxonomy'   => 'post_tag',
			'orderby'    => 'name',
			'order'      => 'DESC'
		);
	}

	//小工具内容
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
			ob_start();
				wp_tag_cloud( array(
					'taxonomy' => $this->_get_current_taxonomy( $instance ),
					'number'   => $instance['number'],
					'unit'     => 'px',
					'smallest' => 12,
					'largest'  => 12,
					'orderby'  => $instance['orderby'],
					'order'    => $instance['order']
				) );
			$tag_cloud_code = ob_get_clean();
			echo empty( $tag_cloud_code ) ? '<p>' . __( '什么标签都没有，赶紧去创建吧！' ) . '</p>' : '<div class="list-box">' . $tag_cloud_code . '</div>';
		echo $args['after_widget'];
	}

	//保存设置选项
	function update( $new_instance, $old_instance ){
		$instance = array();
		
		//标题
		$instance['title'] = strip_tags( $new_instance['title'] );

		//标签数量
		$instance['number'] = absint( $new_instance['number'] );

		//分类法
		$instance['taxonomy'] = $this->_get_current_taxonomy( $new_instance );

		//标签排序
		$all_orderby = array( 'name', 'count' );
		$instance['orderby'] = in_array( $new_instance['orderby'], $all_orderby ) ? $new_instance['orderby'] : 'name';

		//排序规则
		$all_order = array( 'ASC', 'DESC', 'RAND' );
		$instance['order'] = in_array( $new_instance['order'], $all_order ) ? $new_instance['order'] : 'DESC';

		return $instance;
	}

	//设置表单
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );

		$taxonomy = $this->_get_current_taxonomy( $instance );

		$orderby = array(
			'name'   => __( '标签名称', 'Vmeng' ),
			'count'  => __( '文章数量', 'Vmeng' )
		);

		$order = array(
			'ASC'   => __( '正序排列', 'Vmeng' ),
			'DESC'  => __( '倒序排列', 'Vmeng' ),
			'RAND'  => __( '随机排列', 'Vmeng' )
		);
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( '标题：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p title="<?php esc_attr_e( '设置为 0 则全部显示', 'Vmeng' ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( '标签数量：', 'Vmeng' ); ?></label>
			<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php _e( '分类法：', 'Vmeng' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
				<?php
				foreach( get_taxonomies( array( 'show_tagcloud' => true ), false ) as $tax ):
					if ( empty( $tax->labels->name ) ) continue;
				?>
					<option value="<?php echo esc_attr( $tax->name ); ?>"<?php selected( $taxonomy, $tax->name ); ?>><?php echo $tax->labels->name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( '标签排序：', 'Vmeng' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<?php foreach( $orderby as $orderby_name => $orderby_title ): ?>
					<option value="<?php echo $orderby_name; ?>"<?php selected( $instance['orderby'], $orderby_name ); ?>><?php echo $orderby_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( '排序规则：', 'Vmeng' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<?php foreach( $order as $order_name => $order_title ): ?>
					<option value="<?php echo $order_name; ?>"<?php selected( $instance['order'], $order_name ); ?>><?php echo $order_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
<?php
	}

	//获取当前分类法
	function _get_current_taxonomy( $instance ){
		$taxonomy = stripslashes( $instance['taxonomy'] );
		return !empty( $taxonomy ) && taxonomy_exists( $taxonomy ) ? $taxonomy : 'post_tag';
	}

}
register_widget( 'Vmeng_widget_tag_cloud' );

/**
 * 小工具：评论
 */
class Vmeng_widget_recent_comments extends WP_Widget{

	//默认设置
	public $default_instance = array();

	//初始化
	function __construct(){
		parent::__construct(
			'recent_comments',
			__( 'Vmeng 评论', 'Vmeng' ),
			array( 'description' => __( '根据设置可以显示不同的评论', 'Vmeng' ) )
		);
		$this->default_instance = array(
			'title'                 => __( '评论', 'Vmeng' ),
			'number'                => 5,
			'exclude_users'         => array(),
			'exclude_administrator' => false,
			'exclude_posts'         => array(),
			'descending'            => true,
			'date_limit'            => 'unlimited'
		);
	}

	//小工具内容
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
			$exclude_users = $instance['exclude_users'];
			if( $instance['exclude_administrator'] ){
				$administrator_ids = array_map( 'absint', get_users( 'fields=ids&role=administrator' ) );
				$exclude_users = array_unique( array_merge( $instance['exclude_users'], $administrator_ids ) );
			}
			$date_query = $instance['date_limit'] == 'unlimited' ? null : array( 'after' => $instance['date_limit'] );
			$comments = get_comments( array(
				'number'         => $instance['number'],
				'author__not_in' => $exclude_users,
				'post__not_in'   => $instance['exclude_posts'],
				'order'          => $instance['descending'] ? 'DESC' : 'ASC',
				'date_query'     => $date_query,
				'status'         => 'approve',
				'type'           => 'comment'
			) );
			if( empty( $comments ) ):
?>
				<div class="empty-recent-comments">
					<p><?php _e( '什么评论都没有，赶紧去发表你的意见吧！' ); ?></p>
				</div>
<?php
			else:
				$show_avatars = get_option( 'show_avatars' ) ? ' show-avatars' : '';
				echo '<ul class="sidebar-comments-list' . $show_avatars . '">';
					foreach( $comments as $comment ):
						$a_title = sprintf( __( '发表在《%s》', 'Vmeng' ), get_the_title( $comment->comment_post_ID ) );
?>
						<li>
							<a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>" title="<?php echo esc_attr( $a_title ); ?>">
								<?php echo get_avatar( $comment, 36 ); ?>
								<div class="right-box">
									<span class="author"><?php echo get_comment_author( $comment ); ?></span>
									<p class="comment-text"><?php echo htmlspecialchars( get_comment_text( $comment ) ); ?></p>
								</div>
							</a>
						</li>
<?php
					endforeach;
				echo '</ul>';
			endif;
		echo $args['after_widget'];
	}

	//保存设置选项
	function update( $new_instance, $old_instance ){
		$instance = array();
		
		//标题
		$instance['title'] = strip_tags( $new_instance['title'] );

		//评论数量
		$instance['number'] = absint( $new_instance['number'] );
		if( $instance['number'] === 0 ) $instance['number'] = 1;

		//排除用户
		$instance['exclude_users'] = array_map( 'absint', (array) $new_instance['exclude_users'] );
		if( !empty( $instance['exclude_users'] ) ){
			$instance['exclude_users'] = get_users( array(
				'include' => $instance['exclude_users'],
				'fields' => 'ids'
			) );
			$instance['exclude_users'] = array_map( 'absint', $instance['exclude_users'] );
		}

		//排除所有管理员
		$instance['exclude_administrator'] = !empty( $new_instance['exclude_administrator'] );

		//排除文章
		$instance['exclude_posts'] = array_map( 'absint', (array) $new_instance['exclude_posts'] );
		if( !empty( $instance['exclude_posts'] ) ) $instance['exclude_posts'] = get_posts( array(
			'post__in'               => $instance['exclude_posts'],
			'nopaging'               => true,
			'post_type'              => 'post',
			'post_status'            => array( 'publish', 'future' ),
			'fields'                 => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		) );

		//倒序排列
		$instance['descending'] = !empty( $new_instance['descending'] );

		//日期限制
		$all_date_limit = array(
			'unlimited',
			'1 day ago',
			'3 day ago',
			'1 week ago',
			'1 month ago',
			'3 month ago',
			'6 month ago',
			'1 year ago',
			'2 year ago',
			'3 year ago'
		);
		$instance['date_limit'] = in_array( $new_instance['date_limit'], $all_date_limit ) ? $new_instance['date_limit'] : 'unlimited';

		return $instance;
	}

	//设置表单
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );

		$users = get_users( array(
			'orderby' => 'registered',
			'fields'  => array( 'ID', 'display_name' )
		) );

		$date_limit = array(
			'unlimited'   => __( '无限制', 'Vmeng' ),
			'1 day ago'   => __( '一天之内', 'Vmeng' ),
			'3 day ago'   => __( '三天之内', 'Vmeng' ),
			'1 week ago'  => __( '一周之内', 'Vmeng' ),
			'1 month ago' => __( '一个月之内', 'Vmeng' ),
			'3 month ago' => __( '三个月之内', 'Vmeng' ),
			'6 month ago' => __( '半年之内', 'Vmeng' ),
			'1 year ago'  => __( '一年之内', 'Vmeng' ),
			'2 year ago'  => __( '两年之内', 'Vmeng' ),
			'3 year ago'  => __( '三年之内', 'Vmeng' )
		);
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( '标题：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( '评论数量：', 'Vmeng' ); ?></label>
			<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_users' ) ); ?>"><?php _e( '排除用户：', 'Vmeng' ); ?></label>
			<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'exclude_users' ) ); ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'exclude_users' ) ); ?>[]">
				<?php foreach( $users as $user ): ?>
					<option value="<?php echo esc_attr( $user->ID ); ?>"<?php if( in_array( $user->ID, $instance['exclude_users'] ) ) echo ' selected="selected"'; ?>><?php echo $user->display_name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_administrator' ) ); ?>"><?php _e( '排除所有管理员：', 'Vmeng' ); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'exclude_administrator' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_administrator' ) ); ?>" value="1"<?php checked( $instance['exclude_administrator'] ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_posts' ) ); ?>"><?php _e( '排除文章：', 'Vmeng' ); ?></label>
			<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'exclude_posts' ) ); ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'exclude_posts' ) ); ?>[]">
				<?php foreach( get_posts( 'nopaging=1&post_status=publish,future' ) as $post ): ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>"<?php if( in_array( $post->ID, $instance['exclude_posts'] ) ) echo ' selected="selected"'; ?>><?php echo get_the_title( $post ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'descending' ) ); ?>"><?php _e( '倒序排列：', 'Vmeng' ); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'descending' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'descending' ) ); ?>" value="1"<?php checked( $instance['descending'] ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'date_limit' ) ); ?>"><?php _e( '日期限制：', 'Vmeng' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'date_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_limit' ) ); ?>">
				<?php foreach( $date_limit as $date_code => $date_title ): ?>
					<option value="<?php echo $date_code; ?>"<?php selected( $instance['date_limit'], $date_code ); ?>><?php echo $date_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
<?php
	}

}
register_widget( 'Vmeng_widget_recent_comments' );

/**
 * 小工具：博主信息
 */
class Vmeng_widget_bloger_info extends WP_Widget{

	//默认设置
	public $default_instance = array();

	//初始化
	function __construct(){
		parent::__construct(
			'bloger_info',
			__( 'Vmeng 博主信息', 'Vmeng' ),
			array( 'description' => __( '博主的社交信息', 'Vmeng' ) )
		);
		$current_user = wp_get_current_user();
		//([1-9][0-9]{4,11})@[qq|vip\.qq]+\.com
		$preg_qq = preg_match('/([1-9][0-9]{4,11})@[qq|vip\.qq]+.com/',$current_user->user_email,$qq);
		if (!$preg_qq)
		$qq = array('','');
		$this->default_instance = array(
			'name'                  => $current_user->display_name,
			'avatar'                => get_avatar_url( $current_user->ID, 64 ),
			'qq'                    => __($qq[1],''),
			'email_url'             => 'mailto:'.$current_user->user_email,
			'github_url'            => '',
			'weibo_url'             => '',
			'rss_url'               =>  get_bloginfo_rss('rss2_url'),
			'description'           =>  get_the_author_meta('user_description')
		);
	}

	//小工具内容
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		echo $args['before_widget'];
    ?>
	<div class="blogger-profile"> 
    <div class="blogger-title"> 
     <span class="blogger-avatar"> 
   <img src="<?php echo $instance['avatar']; ?>" alt="站长头像" /> 
       <h4><?php echo $instance['name']; ?></h4></span> 
    </div> 
    <div class="blogger-card"> 
		<div class='bloger-description'>
		   <?php echo $instance['description']; ?>
	    </div>
    </div> 
    <div class="blogger-footer"> 
     <ul class="blogger-footer-link">
      <li><a href="http://wpa.qq.com/msgrd?V=3&uin=<?php echo $instance['qq']; ?>&Site=QQ&Menu=yes" title="QQ"><i class="fa fa-qq"></i></a></li>
      <li><a href="<?php echo $instance['email_url']; ?>" title="Email"><i class="fa fa-envelope"></i></a></li>
      <li><a href="<?php echo $instance['github_url']; ?>" title="GitHub"><i class="fa fa-github-alt"></i></a></li>
      <li><a href="<?php echo $instance['weibo_url']; ?>" title="新浪微博"><i class="fa fa-weibo"></i></a></li>
      <li><a href="<?php echo $instance['rss_url']; ?>" title="RSS"><i class="fa fa-rss"></i></a></li>
     </ul> 
    </div>  
  </div>
	<?php	
	echo $args['after_widget'];
	}

    function update($new_instance,$old_instance){   
        $instance = array();

			//NAME
			$instance['name'] = strip_tags( $new_instance['name'] );

			//头像
		    $instance['avatar'] = strip_tags( $new_instance['avatar'] );

			//QQ
			$instance['qq'] = strip_tags( $new_instance['qq'] );

			//Email
			$instance['email_url'] = strip_tags( $new_instance['email_url'] );

			//GitHub
			$instance['github_url'] = strip_tags( $new_instance['github_url'] );

			//Weibo
			$instance['weibo_url'] = strip_tags( $new_instance['weibo_url'] );

			//RSS
			$instance['rss_url'] = strip_tags( $new_instance['rss_url'] );

			//描述
			$instance['description'] = strip_tags( $new_instance['description'] );

			
        return $instance;   
	}  

	//设置表单
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );
?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( '名称：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" value="<?php echo esc_attr( $instance['name'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php _e( '头像(链接)：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" value="<?php echo esc_attr( $instance['avatar'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'qq' ) ); ?>"><?php _e( 'QQ：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'qq' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'qq' ) ); ?>" value="<?php echo esc_attr( $instance['qq'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email_url' ) ); ?>"><?php _e( '邮箱(链接)：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email_url' ) ); ?>" value="<?php echo esc_attr( $instance['email_url'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'github_url' ) ); ?>"><?php _e( 'GitHub(链接)：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'github_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'github_url' ) ); ?>" value="<?php echo esc_attr( $instance['github_url'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'weibo_url' ) ); ?>"><?php _e( '新浪微博(链接)：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'weibo_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'weibo_url' ) ); ?>" value="<?php echo esc_attr( $instance['weibo_url'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rss_url' ) ); ?>"><?php _e( 'RSS(链接)：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'rss_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss_url' ) ); ?>" value="<?php echo esc_attr( $instance['rss_url'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rss_url' ) ); ?>"><?php _e( '描述：', 'Vmeng' ); ?></label>
			<textarea type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" value="<?php echo esc_attr( $instance['description'] ); ?>" /></textarea>
		</p>
<?php }
}
register_widget( 'Vmeng_widget_bloger_info' );

/**
 * 小工具：增强文本
 */
class Vmeng_widget_php_text extends WP_Widget {

	//默认设置
	public $default_instance = array();

    //初始化
	function __construct() {
		parent::__construct(
			'php_text',
			__( 'Vmeng 增强文本', 'Vmeng' ),
		     array('description' => __( '支持PHP、JavaScript、短代码等' , 'Vmeng' ) )
		);
	   $this->default_instance = array(
		    'title'                 => __( '增强文本', 'Vmeng' ),
		    'text'                  => ''
	    );
    }
	
	//小工具内容
	function widget( $args, $instance ) {
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];

        $text = apply_filters('widget_enhanced_text', $instance['text'], $instance);

        // 通过PHP解析文本
        ob_start();
        eval('?>' . $text);
        $text = ob_get_contents();
        ob_end_clean();

        // 通过do_shortcode运行文本
		$text = do_shortcode($text);
		echo $text;
		echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();

			//标题
			$instance['title'] = strip_tags( $new_instance['title'] );

			//内容
			$instance['text'] = $new_instance['text'];
			
	    return $instance;
    }

	//设置表单
    function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->default_instance );
?>

        <style>
            .monospace {
                font-family: Consolas, Lucida Console, monospace;
            }
            .etw-credits {
                font-size: 6.9em;
                background: #F7F7F7;
                border: 1px solid #EBEBEB;
                padding: 4px 6px;
            }
        </style>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('标题：','Vmeng'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php _e('内容：','Vmeng'); ?></label>
            <textarea class="widefat monospace" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_attr(format_to_edit($instance['text'])); ?></textarea>
        </p>
<?php }
}
register_widget( 'Vmeng_widget_php_text' );

/**
 * 小工具：广告
 */
class Vmeng_widget_banner extends WP_Widget{

	//默认设置
	public $default_instance = array();

	//初始化
	function __construct(){
		parent::__construct(
			'banner',
			 __( 'Vmeng 广告', 'Vmeng' ),
			array( 'description' => __( '自定义广告代码', 'Vmeng' ) )
		);
		$this->default_instance = array(
			'title' => __( '广告', 'Vmeng' ),
			'code'  => ''
		);
	}

	//小工具内容
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
			echo $instance['code'];
		echo $args['after_widget'];
	}

	//保存设置选项
	function update( $new_instance, $old_instance ){
		$instance = array();
		
		//标题
		$instance['title'] = strip_tags( $new_instance['title'] );

		//广告代码
		$instance['code'] = force_balance_tags( $new_instance['code'] );
		$instance['code'] = do_shortcode( $instance['code'] );

		return $instance;
	}

	//设置表单
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( '标题：', 'Vmeng' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>"><?php _e( '广告代码：', 'Vmeng' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'code' ) ); ?>" rows="10"><?php echo esc_attr( $instance['code'] ); ?></textarea>
		</p>
		<?php if( !empty( $instance['code'] ) ): ?>
			<p><?php _e( '广告预览：', 'Vmeng' ); ?></p>
			<div style="margin: 13px 0; overflow: hidden;">
				<?php echo $instance['code']; ?>
				<div class="clear: both;"></div>
			</div>
		<?php endif; ?>
<?php
	}

}
register_widget( 'Vmeng_widget_banner' );

(function() {
	tinymce.create('tinymce.plugins.MyButtons', {
		init : function(ed, url) {
			
			ed.addButton( 'url', {
				title : '链接按钮',
				icon: 'newtab',
				onclick : function() {
					ed.selection.setContent('[url href=' + ed.selection.getContent() + '链接地址]按钮名称[/url]');
				}
			});
			
			ed.addButton( 'addCollapse', {
				title : '文字折叠',
				icon: 'pluscircle',
				onclick : function() {
					ed.selection.setContent('[collapse title="说明文字"]' + ed.selection.getContent() + '[/collapse]');
				}
			});
			
			ed.addButton( 'reply', {
				title : '回复可见',
				icon: 'bubble',
				onclick : function() {
					ed.selection.setContent('[reply]隐藏的内容' + ed.selection.getContent() + '[/reply]');
				}
			});
			
			ed.addButton( 'login', {
				title : '登录可见',
				icon: 'user',
				onclick : function() {
					ed.selection.setContent('[login]隐藏的内容' + ed.selection.getContent() + '[/login]');
				}
			});

			ed.addButton( 'password', {
				title : '密码保护',
				icon: 'lock',
				onclick : function() {
					ed.selection.setContent('[password key=密码]' + ed.selection.getContent() + '加密的内容[/password]');
				}
			});
			
			ed.addButton( 'addPost', {
				title : '文章链接',
				icon: 'wp_page',
				onclick : function() {
					ed.selection.setContent('[post id=文章ID]' + ed.selection.getContent() + '[/post]');
				}
			});
			
			ed.addButton( 'comments', {
				title : '引用评论',
				icon: 'bubble',
				onclick : function() {
					ed.selection.setContent('[comments id=评论ID]' + ed.selection.getContent() + '[/comments]');
				}
			});
			
		},
		createControl : function(n, cm) {
			return null;
		},
	});

	tinymce.PluginManager.add( 'vmeng_button_script', tinymce.plugins.MyButtons );
})();
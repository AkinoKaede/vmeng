<?php 
// 分类添加字段
function add_category_field(){
	echo '<div class="form-field">
            <label for="cat-title">分类标题</label>
            <input name="cat-title" id="cat-title" type="text" value="" size="40">
            <p>用于SEO自定义标题</p>
          </div>';

	echo '<div class="form-field">
			<label for="cat-words">分类关键字</label>
            <input name="cat-words" id="cat-words" type="text" value="" size="40">
            <p>用于SEO自定义关键字</p>
          </div>';
}
add_action('category_add_form_fields','add_category_field',10,2);
  
// 分类编辑字段
function edit_category_field($tag){
    echo '<tr class="form-field">
            <th scope="row"><label for="cat-title">分类标题</label></th>
            <td>
                <input name="cat-title" id="cat-title" type="text" value="';
                echo get_option('cat-title-'.$tag->term_id).'" size="40"/><br>
                <span class="cat-title">用于'.$tag->name.'分类SEO自定义标题</span>
            </td>
        </tr>';

    echo '<tr class="form-field">
            <th scope="row"><label for="cat-words">分类关键字</label></th>
            <td>
                <input name="cat-words" id="cat-words" type="text" value="';
                echo get_option('cat-words-'.$tag->term_id).'" size="40"/><br>
                <span class="cat-words">用于'.$tag->name.'分类SEO自定义关键字</span>
            </td>
        </tr>';
}
add_action('category_edit_form_fields','edit_category_field',10,2);

// 保存数据
function taxonomy_metadate($term_id){
    if(isset($_POST['cat-title']) && isset($_POST['cat-words'])){
        //判断权限--可改
        if(!current_user_can('manage_categories')){
            return $term_id;
        }
        // 标题
        $title_key = 'cat-title-'.$term_id; // key
        $title_value = $_POST['cat-title']; // value

        // 关键字
        $words_key = 'cat-words-'.$term_id;
        $words_value = $_POST['cat-words'];

        // 更新选项值
        update_option( $title_key, $title_value );
        update_option( $words_key, $words_value );
    }
}

add_action('created_category','taxonomy_metadate',10,1);
add_action('edited_category','taxonomy_metadate',10,1);


// 标签添加字段
function add_tags_field(){
	echo '<div class="form-field">
            <label for="tag-title">标签标题</label>
            <input name="tag-title" id="tag-title" type="text" value="" size="40">
            <p>用于SEO自定义标题</p>
          </div>';

	echo '<div class="form-field">
			<label for="tag-words">标签关键字</label>
            <input name="tag-words" id="tag-words" type="text" value="" size="40">
            <p>用于SEO自定义关键字</p>
          </div>';
}
add_action('post_tag_add_form_fields','add_tags_field',10,2);
  
// 标签编辑字段
function edit_tags_field($tag){
    echo '<tr class="form-field">
            <th scope="row"><label for="tag-title">标签标题</label></th>
            <td>
                <input name="tag-title" id="tag-title" type="text" value="';
                echo get_option('tag-title-'.$tag->term_id).'" size="40"/><br>
                <span class="tag-title">用于'.$tag->name.'标签SEO自定义标题</span>
            </td>
        </tr>';

    echo '<tr class="form-field">
            <th scope="row"><label for="tag-words">标签关键字</label></th>
            <td>
                <input name="tag-words" id="tag-words" type="text" value="';
                echo get_option('tag-words-'.$tag->term_id).'" size="40"/><br>
                <span class="tag-words">用于'.$tag->name.'标签SEO自定义关键字</span>
            </td>
        </tr>';
}
add_action('post_tag_edit_form_fields','edit_tags_field',10,2);

// 保存数据  
function tags_metadate($term_id){
    if(isset($_POST['tag-title']) && isset($_POST['tag-words'])){
        //判断权限--可改
        if(!current_user_can('manage_categories')){
            return $term_id;
        }
        // 标题
        $title_key = 'tag-title-'.$term_id; // key
        $title_value = $_POST['tag-title']; // value

        // 关键字
        $words_key = 'tag-words-'.$term_id;
        $words_value = $_POST['tag-words'];

        // 更新选项值
        update_option( $title_key, $title_value );
        update_option( $words_key, $words_value );
    }
}

add_action('created_post_tag','tags_metadate',10,1);
add_action('edited_post_tag','tags_metadate',10,1);
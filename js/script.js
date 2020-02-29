$(document).ready(function() {
	//初始窗体尺寸，监控窗体变化事件
	$(window).resize();
});
$(window).resize(function() {
	var bodyHeight = $(document.body).height();
	var winHeight = $(window).height();
	if (bodyHeight <= winHeight) {
		$('.vm-footer').addClass('vm-fixed');
	} else {
		$('.vm-footer').removeClass('vm-fixed');
	}
});	
//一言Hitokoto
function get_hitokoto() {
    var a = Poi.hitokoto_type;
    var f = "";
    if (a == "") {} else {
        f = "?c=" + a
    }
    $.ajax({
        type: "GET",
        url: "https://v1.hitokoto.cn" + f,
        dataType: "json",
        timeout: 1000,
        success: function(g) {
            switch (g.type) {
            case "a":
                hitype = "动画";
                break;
            case "b":
                hitype = "漫画";
                break;
            case "c":
                hitype = "游戏";
                break;
            case "d":
                hitype = "小说";
                break;
            case "e":
                hitype = "原创";
                break;
            case "f":
                hitype = "网络";
                break;
            case "g":
                hitype = "其他";
                break;
            default:
                hitype = "未知"
            }
            $("#hitokoto_p").html(g.hitokoto + " —— " + g.from + "(" + hitype + ")")
        },
        error: function() {
            $("#hitokoto_p").html("连接超时 | 一言好像又抽风了~ (゜-゜)つロ ")
        }
    })
}
$("#refresh").click(function() {
    setTimeout("get_hitokoto()", 700);
    $("#hitokoto_p").html("玩命加载中…")
});
get_hitokoto();
function setCookie(name, value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + ";path=/"
};
  Vmeng = {
    // 返回顶部
    GT: function(){
        var offset = 100,
        offset_opacity = 1200,
        scroll_top_duration = 700,
        $back_to_top = $('.cd-top');
        $(window).scroll(function(){
            ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
            if( $(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('cd-fade-out');
            }
        });
        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
    },
    IL:function() {
        $("img.lazyload").lazyload({
	        effect: "fadeIn",
	        threshold: 100,
	        failure_limit: 70
        });
    },
    RS:function() {
       if( $('.rslides').length>0){
           $(".rslides").responsiveSlides({
                auto: true,             // Boolean: 设置是否自动播放, true or false
                speed: 500,            // Integer: 动画持续时间，单位毫秒
                timeout: 4000,          // Integer: 图片之间切换的时间，单位毫秒
                pager: true,           // Boolean: 是否显示页码, true or false
                nav: true,             // Boolean: 是否显示左右导航箭头（即上翻下翻）, true or false
                random: false,          // Boolean: 随机幻灯片顺序, true or false
                pause: true,           // Boolean: 鼠标悬停到幻灯上则暂停, true or false
                pauseControls: true,    // Boolean: 悬停在控制板上则暂停, true or false
                prevText: "<i class=\"fa fa-angle-left\"></i>",   // String: 往前翻按钮的显示文本
                nextText: "<i class=\"fa fa-angle-right\"></i>"       // String: 往后翻按钮的显示文本
            });
        }
    },
    OwO:function() {
    if( $('.OwO-textarea').length>0){
      var OwO_demo = new OwO({
        logo: 'OωO表情',
        container: document.getElementsByClassName('OwO')[0],
        target: document.getElementsByClassName('OwO-textarea')[0],
        api: Poi.template_directory_uri+'/lib/OwO/OwO.min.json',
        position: 'down',
        width: '100%',
        maxHeight: '250px'
         });
    }
},
    TS:function() {
        if( $('#sidebar').length>0){
    jQuery(document).ready(function() {
        jQuery('#sidebar').theiaStickySidebar({
          // Settings
          additionalMarginTop: 30
        });
      });
    }
},
    SI:function() {
        var href=$("#searchsubmit").attr("href");
        $("#searchsubmit").attr("href",""); //清空默认地址
        $('.vm-input-search').bind('input propertychange', function () {
          var searchkey=$("input[name=s]").val();//获取输入框内容
        $("#searchsubmit").attr("href",href+encodeURI(searchkey)); //将拼接好的地址重新添加
        });
        $.extend({
        getKey: function() {
          var theEvent = window.event || arguments.callee.caller.arguments[0];
                var code = theEvent.keyCode;
                if(code == 13){    
        $('#searchsubmit').get(0).click();
                }
        },
        })
},
    SH:function() {
        $(".vm-nav-search").click(function() {
            $ (this).toggleClass ("off-search");
            $(".searchbar").fadeToggle(300);
            if ($(".off-search").length > 0 ) {
                $(".vm-nav-search").html('<i class="fa fa-times"></i>');
            }else{
                $(".vm-nav-search").html('<i class="fa fa-search"></i>');
            }
        });
},  NA:function() {
        $(document).ready(function(){
            $(".navbar").affix({
                offset: {
                    top: 15
                 }
            });
        });
}
}
 $(function() {
    Vmeng.GT(); // 返回顶部
    Vmeng.IL(); // Lazyload
    Vmeng.RS(); // responsiveSlides
    Vmeng.OwO(); //OwO
    Vmeng.TS(); //theiaStickySidebar
    Vmeng.SI(); //Search instantclick
    Vmeng.SH(); //Search
    Vmeng.NA(); //Nav affix
    });


jQuery(document).ready(
	function(jQuery){
	jQuery('.collapseButton').click(function(){
		jQuery(this).parent().parent().find('.xContent').slideToggle('slow');
		if (jQuery(this).parent().parent().find('.xicon').hasClass('active')) {
			jQuery(this).parent().parent().find('.xicon').removeClass('active');
		} else {
			jQuery(this).parent().parent().find('.xicon').addClass('active');
		}
	});
	jQuery('.icoButton').click(function(){
		jQuery(this).parent().parent().parent().find('.xContent').slideToggle('slow');
		if (jQuery(this).parent().parent().parent().find('.xicon').hasClass('active')) {
			jQuery(this).parent().parent().parent().find('.xicon').removeClass('active');
		} else {
			jQuery(this).parent().parent().parent().find('.xicon').addClass('active');
		}
	});
});
jQuery(document).ready(function($){
 //===================================存档页面 jQ伸缩
     (function(){
         $('#al_expand_collapse,#archives span.al_mon').css({cursor:"s-resize"});
         $('#archives span.al_mon').each(function(){
             var num=$(this).next().children('li').size();
             var text=$(this).text();
             $(this).html(text+'<em> ( '+num+' 篇文章 )</em>');
         });
         var $al_post_list=$('#archives ul.al_post_list'),
             $al_post_list_f=$('#archives ul.al_post_list:first');
         $al_post_list.hide(1,function(){
             $al_post_list_f.show();
         });
         $('#archives span.al_mon').click(function(){
             $(this).next().slideToggle(400);
             return false;
         });
         $('#al_expand_collapse').toggle(function(){
             $al_post_list.show();
         },function(){
             $al_post_list.hide();
         });
     })();
 });
 
 /*scroll*/
var issingle;//全局变量，防止在主页时无用功automenu

var animation = false;
var $document = $(document);
var $windowHeight = $(window).height();

var scroll = function () {

    if(issingle && $('[data-autoMenu]').length>0){
        if(!$('.autoMenu').find('span').hasClass('dont')){
            var item = $('.vm-blog-content');
            var itemOffsetTop = item.offset().top;
            var winScrollTop = $(window).scrollTop();
            var itemOuterHeight = item.outerHeight(true);
            if(!(winScrollTop > itemOffsetTop+itemOuterHeight-1290) /*&& !(winScrollTop < itemOffsetTop-$windowHeight)*/) {
                //$('.autoMenu').fadeIn();
                $('.autoMenu').find('span').removeClass('icon-plus-sign').addClass('icon-minus-sign');
                $('.autoMenu').find('ul').fadeIn();
            } else {
                //$('.autoMenu').fadeOut();
                $('.autoMenu').find('span').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                $('.autoMenu').find('ul').fadeOut();
            }
        }
    }
}    
var raf = window.requestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    window.msRequestAnimationFrame ||
    window.oRequestAnimationFrame;
var $window = $(window);
var lastScrollTop = $window.scrollTop();

if (raf) {
    loop();
}

function loop() {
    var scrollTop = $window.scrollTop();
    if (lastScrollTop === scrollTop) {
        raf(loop);
        return;
    } else {
        lastScrollTop = scrollTop;

        // 如果进行了垂直滚动，执行scroll方法
        scroll();
        raf(loop);
    }
}

/* 
 * blogMenu plugin 1.0   2017-09-01 by cary
 * 说明：自动根据标签（h3,h4）生成博客目录
 */
(function ($) {

    var Menu = (function () {
        /**
         * 插件实例化部分，初始化时调用的代码可以放这里
         * @param element 传入jq对象的选择器，如 $("#J_plugin").plugin() ,其中 $("#J_plugin") 即是 element
         * @param options 插件的一些参数神马的
         * @constructor
         */
        var Plugin = function(element, options) {
            //将dom jquery对象赋值给插件，方便后续调用
            this.$element = $(element);

            //将插件的默认参数及用户定义的参数合并到一个新的obj里
            this.settings = $.extend({}, $.fn.autoMenu.defaults, typeof options === 'object' && options)
            //如果将参数设置在dom的自定义属性里，也可以这样写
            //this.settings = $.extend({}, $.fn.plugin.defaults, this.$element.data(), options);

            this.init();
        }


        /**
         * 将插件所有函数放在prototype的大对象里
         * 插件的公共方法，相当于接口函数，用于给外部调用
         * @type {{}}
         */
        Plugin.prototype = {
            init: function () {
                var opts = this.settings;

                //console.log(opts)
                this.$element.html(this.createHtml());
                this.setActive();
                this.bindEvent();
                
            },
            createHtml: function(){
                var that = this;
                var opts = that.settings;
                var width = typeof opts.width === 'number' && opts.width;
                var height = typeof opts.height === 'number' && opts.height;
                var padding = typeof opts.padding === 'number' && opts.padding;
                that.$element.width(width+padding*2);
                var html = '<ul style="height: '+ height +'px;padding:' + padding + 'px">';
                var num = 0;
                $("*").each(function(){
                    var _this = $(this);
                    if(_this.get(0).tagName == opts.levelOne.toUpperCase() && _this.closest('.vm-blog-content').length > 0 ){
                        _this.attr('id',num);
                        var nodetext = that.handleTxt(_this.html());
                        html += '<li name="'+ num +'"><a href="#'+ num +'">'+ nodetext +'</a></li>';
                        num++;
                    }else if(_this.get(0).tagName == opts.levelTwo.toUpperCase() && _this.closest('.vm-blog-content').length > 0){
                        _this.attr('id',num);
                        var nodetext = that.handleTxt(_this.html());
                        html += '<li class="sub" name="'+ num +'"><a href="#'+ num +'">'+ nodetext +'</a></li>';
                        num++;
                    }
                })
                html += '</ul><a href="javascript:void(0);" class="btn-box">'
                            +'<span class="icon-minus-sign"></span>'
                        +'</a>';
                return html;   
            },
            handleTxt: function(txt){
                //正则表达式去除HTML的标签
                return txt.replace(/<\/?[^>]+>/g,"").trim();
            },
            setActive: function(){
                var $el = this.$element,
                    opts = this.settings,
                    items = opts.levelOne + ',' + opts.levelTwo,
                    $items = $(items),
                    offTop = opts.offTop,
                    top = $(document).scrollTop(),
                    currentId;
                if($(document).scrollTop()==0){
                    //初始化active
                    $el.find('li').removeClass('active').eq(0).addClass('active');
                    return;
                }
                $items.each(function(){
                    var m = $(this),
                        itemTop = m.offset().top;
                    if(top > itemTop-offTop){
                        currentId = m.attr('id');
                    }else{
                        return false;
                    }
                })
                var currentLink = $el.find('.active');
                if(currentId && currentLink.attr('name')!= currentId){
                  currentLink.removeClass('active');
                  $el.find('[name='+currentId+']').addClass('active');
                }
                
            },
            bindEvent: function(){
                var _this = this;
                $(window).scroll(function(){
                    _this.setActive()
                });
                _this.$element.on('click','.btn-box',function(){
                    if($(this).find('span').hasClass('icon-minus-sign')){
                        $(this).find('span').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                        _this.$element.find('ul').fadeOut();
                    }else{
                        $(this).find('span').removeClass('icon-plus-sign').addClass('icon-minus-sign');
                        _this.$element.find('ul').fadeIn();
                    }
                    
                })
            }

        };

        return Plugin;

    })();


    /**
     * 这里是将Plugin对象 转为jq插件的形式进行调用
     * 定义一个插件 plugin
     */
    $.fn.autoMenu = function (options) {
        return this.each(function () {
            var $el = $(this),
                menu = $el.data('autoMenu'),
                option = $.extend({}, $.fn.autoMenu.defaults, typeof options === 'object' && options);
            if (!menu) {
                //将实例化后的插件缓存在dom结构里（内存里）
                $el.data('autoMenu',new Menu(this, option));
            }

            /**
             * 如果插件的参数是一个字符串，则 调用 插件的 字符串方法。
             * 如 $('#id').plugin('doSomething') 则实际调用的是 $('#id).plugin.doSomething();
             */
            if ($.type(options) === 'string') menu[option]();
        });
    };

    /**
     * 插件的默认值
     */
    $.fn.autoMenu.defaults = {
        levelOne : 'h2', //一级标题
        levelTwo : 'h3',  //二级标题（暂不支持更多级）
        width : 200, //容器宽度
        height : 400, //容器高度
        padding: 20, //内部间距
        offTop : 100, //滚动切换导航时离顶部的距离
    };

    /**
     * 优雅处： 通过data-xxx 的方式 实例化插件。
     * 这样的话 在页面上就不需要显示调用了。
     * 可以查看bootstrap 里面的JS插件写法
     */
    $(function () {
        if($('[data-autoMenu]').length>0){
            new Menu($('[data-autoMenu]'));
            issingle = true;
        }
        
    });

})(jQuery);

var $windowWidth = $(window).width();
if($windowWidth >= 1355){
    $('.autoMenu').find('ul').fadeIn();
    $('.autoMenu').find('span').removeClass('dont icon-plus-sign').addClass('icon-minus-sign');
}

issingle = true;
if(!$('.autoMenu ul').html()){
    $('.autoMenu').remove()
}


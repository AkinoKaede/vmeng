(function() {

var boxStyle = '.highlighter-code-box {\
    background: #F1F1F1;\
    position: fixed;\
    left: 50% ;\
    top: 50% ;\
    border: 1px solid #999;\
    width: 460px;\
    height: 465px;\
    margin: -210px 0 0 -230px;\
    line-height: 25px;\
    border-radius: 3px 3px 0 0;\
    z-index:9999;\
}\
.highlighter-code-box-title{\
    height: 25px;\
    background: #444;\
    color: #fff;\
    text-align: center;\
    vertical-align: baseline;\
    font-family: Arial,Verdana;\
    font-size: 11px;\
    \
}\
.highlighter-code-box-toolbar{\
    padding: 5px 15px;\
}\
.highlighter-code-title{\
    width: 430px;\
    height: 30px;\
    font-family: "Courier New", Courier, mono;\
    font-size: 20px;\
    border: 1px solid #DFDFDF;\
    margin: 0 auto;\
    display: block;\
    resize: none;\
}\
.highlighter-code-ln{\
    width: 430px;\
    height: 30px;\
    font-family: "Courier New", Courier, mono;\
    font-size: 17px;\
    border: 1px;\
    margin: 0 auto;\
    display: block;\
    resize: none;\
}\
.highlighter-code-input{\
    width: 430px;\
    height: 310px;\
    font-family: "Courier New", Courier, mono;\
    font-size: 12px;\
    border: 1px solid #DFDFDF;\
    margin: 0 auto;\
    display: block;\
    resize: none;\
}\
.highlighter-code-box-bottombar{\
    text-align: right;\
    padding: 5px 15px;\
}\
.highlighter-code-box-bottombar input{\
    border: 1px solid #BBB;\
    margin: 0;\
    padding: 0 0 1px;\
    font-weight: bold;\
    font-size: 11px;\
    width: 94px;\
    height: 24px;\
    color: black;\
    cursor: pointer;\
    border-radius: 3px;\
    background-color: #EEE;\
    background-image: -ms-linear-gradient(bottom, #DDD, white);\
    background-image: -moz-linear-gradient(bottom, #DDD, white);\
    background-image: -o-linear-gradient(bottom, #DDD, white);\
    background-image: -webkit-gradient(linear, left bottom, left top, from(#DDD), to(white));\
    background-image: -webkit-linear-gradient(bottom, #DDD, white);\
    background-image: linear-gradient(bottom, #DDD, white);\
}\
.highlighter-code-box-bottombar input:hover{\
    border: 1px solid #555;\
}';

var boxTemplate = '\
<div class="highlighter-code-box-title">插入代码</div>\
<div class="highlighter-code-box-toolbar">\
    <label>语言: <select id="codeLanguage">\
</select>\
</label>\
<input id="codeTitle" class="highlighter-code-title" placeholder="输入萌萌哒的标题" > \
</div>\
<textarea id="codeInput" class="highlighter-code-input" ></textarea>\
<form name="codeLN" class="highlighter-code-ln">\
<label><input id="codeln" type="checkbox" value="显示行号" name="codeln" checked="checked"/>显示行号\
</label>\
</from>\
<div class="highlighter-code-box-bottombar">\
    <input id="codeCancelButton" type="button" value="取消">\
    <input id="codeInsertButton" type="button" value="插入">\
</div>';

var languages = {  //此处可根据不同高亮插件修改成不同的高亮标签
    Markup:     'markup',
    CSS:     'css',
    Clike:   'clike',
    JavaScript: 'javascript',
    PHP:     'php',
	ASPNET : 'aspnet',
 	Bash:  'bash',
 BASIC:  'basic',
	C:     'c',
	CSharp:  'csharp',
	CPP:     'cpp',
	Git:     'git',
	Go:     'go',
	HTTP:     'http',
	ini:     'ini',
	Java:     'java',
	JSON:     'json',	
    Nginx:  'nginx',
    ObjectiveC:  'objectivec',
    Perl:  'perl',
    PowerShell:  'powershell',
	Python:  'python',
	Ruby:  'ruby',
    SQL:  'sql',
    VBNet:'vbnet',	
    None:     'none'
}
var codeBox = {
    create: function() {
        var styleNode = document.createElement('style');
        styleNode.innerHTML = boxStyle;
        document.getElementsByTagName('head')[0].appendChild(styleNode);
        
        this._dom = document.createElement('div');
        this._dom.setAttribute('class' , 'highlighter-code-box');
        this._dom.innerHTML = boxTemplate;
        document.body.appendChild(this._dom);
        this._init = true;
        var that = this;
        var language = this.language = document.getElementById('codeLanguage');
        var codetitle = this.codetitle = document.getElementById('codeTitle');
        var textarea = this.textarea = document.getElementById('codeInput');      
        var codeln = this.textarea = document.getElementById('codeln');
        var cancel = document.getElementById('codeCancelButton');
        var insert = document.getElementById('codeInsertButton');
        var html = '';
        for(var i in languages){
            html += '<option value="' + languages[i] + '">' + i + '</option>';
        }
        language.innerHTML = html;
        cancel.onclick = function(){
            that.hide();
        }
        insert.onclick = function(){
        	   var title = codetitle.value;
            var text = textarea.value;
            var lan = language.value;
            var ln = codeln.checked;
            var label = language.options[language.selectedIndex].innerHTML;
            text = text.replace(/&/g, '&amp;');
            text=text.replace(/</g,'&lt;').replace(/>/g, '&gt;');
           if(!title){
           	if(ln){
           text = '<pre class="line-numbers"><code class="language-' + lan + '">' + text + '</code></pre>';
           }else{
           text = '<pre><code class="language-' + lan + '">' + text + '</code></pre>';
           }
           }else{
           	if(ln){
            text = '<pre class="line-numbers" data-label="'+ title +'"><code class="language-' + lan + '">' + text + '</code></pre>';
            }else{    	          
            text = '<pre data-label="'+ title +'"><code class="language-' + lan + '">' + text + '</code></pre>';
            	
            }
            }
            //上面这句也应该根据不同高亮插件修改不同class格式
            that._action && that._action(text);
            that.hide();
            if(localStorage){
                localStorage['lastLanguage'] = lan;
            }
        }
    },
    show: function(action) {
        if (!this._init) {
            this.create();
        }
        this.textarea.value = '';
        this._action = action;
        if(localStorage && localStorage['lastLanguage']){
            this.language.value = localStorage['lastLanguage'];
        }
        this._dom.style.display = 'block';
    },
    hide: function(){
        this._action = null;
        this._dom.style.display = 'none';
    }
};

tinymce.create('tinymce.plugins.highlight', {
    init : function(ed, url) {
        ed.addButton('highlight', {
            title : '代码高亮',
			icon : 'code',
            onclick : function() {
              codeBox.show(function(text){
                ed.selection.setContent(ed.selection.getContent()+text);
              });
            }
        });
    },
    createControl : function(n, cm) {
        return null;
    },
});
tinymce.PluginManager.add('highlight', tinymce.plugins.highlight);

})();
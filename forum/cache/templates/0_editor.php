<?php
			/*
			templatepackid: 0
			templatename: editor
			*/
			
			$this->templates['editor']="\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
    
    	<object id=\\\"wysiwyg\\\" classid=\\\"clsid:8AD9C840-044E-11D1-B3E9-00805F499D93\\\" codebase=\\\"http://java.sun.com/products/plugin/autodl/jinstall-1_4_2-windows-i586.cab#Version=1,4,2,0\\\" width=\\\"600\\\" height=\\\"450\\\">
    		<param name=\\\"code\\\" value=\\\"com.woltlab.wbb.wysiwyg.WYSIWYG.class\\\">
    		<param name=\\\"codebase\\\" value=\\\".\\\" />
    		<param name=\\\"archive\\\" value=\\\"editor.jar\\\" />
    		<param name=\\\"type\\\" value=\\\"application/x-java-applet;version=1.4.2\\\">
    		<param name=\\\"mayscript\\\" value=\\\"true\\\">
    		<param name=\\\"model\\\" value=models/hyaluronicacid.xyz>
    		<param name=\\\"bgcolor\\\" value=\\\"{\$style['tableabgcolor']}\\\" />
		<param name=\\\"css\\\" value=\\\"p { margin: 0; padding: 0; } body { background-color: {\$style['tableabgcolor']}; color: {\$style['tableafontcolor']}; font-family: {\$style['fontfamily']}; font-size: {\$style['normalfontsize']}; } a { color: {\$style['tablealinkcolor']}; text-decoration: {\$style['tablealinkdeco']}; }\\\" />
		<param name=\\\"smilies\\\" value=\\\"\$smilies\\\" />
		<param name=\\\"languages\\\" value=\\\"{\$lang->items['LANG_POSTINGS_WYSIWYG_EDITOR_VARS']}\\\" />

    		<comment>
			<embed id=\\\"embed_wysiwyg\\\" languages=\\\"{\$lang->items['LANG_POSTINGS_WYSIWYG_EDITOR_VARS']}\\\" bgcolor=\\\"{\$style['tableabgcolor']}\\\" smilies=\\\"\$smilies\\\" css=\\\"p { margin: 0; padding: 0; } body { background-color: {\$style['tableabgcolor']}; color: {\$style['tableafontcolor']}; font-family: {\$style['fontfamily']}; font-size: {\$style['normalfontsize']}; } a { color: {\$style['tablealinkcolor']}; text-decoration: {\$style['tablealinkdeco']}; }\\\" type=\\\"application/x-java-applet;version=1.4.2\\\" code=\\\"com.woltlab.wbb.wysiwyg.WYSIWYG.class\\\" codebase=\\\".\\\" archive=\\\"editor.jar\\\" width=\\\"600\\\" height=\\\"450\\\" model=\\\"models/hyaluronicacid.xyz\\\" mayscript=\\\"true\\\" pluginspage=\\\"http://java.sun.com/products/plugin/index.html#download\\\">
			</embed>
    		</comment>
	</object><br />
    
    	<input type=\\\"hidden\\\" name=\\\"message\\\" value=\\\"\$message\\\" />
    
    \") 
    : (\"
    	<textarea name=\\\"message\\\" rows=\\\"20\\\" cols=\\\"80\\\">\$message</textarea>
    \")
).\"";
			?>
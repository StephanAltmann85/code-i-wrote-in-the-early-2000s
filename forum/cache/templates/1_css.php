<?php
/*
templatepackid: 1
templatename: css
*/

$this->templates['css']="<style type=\\\"text/css\\\">
 <!--
body {
 \".((\$style['fontcolor']!=\"\") ? (\"color: {\$style['fontcolor']};\") : (\"\")).\"
 \".((\$style['pagebgcolor']!=\"\") ? (\"background-color: {\$style['pagebgcolor']};\") : (\"\")).\"
 \".((\$style['fontfamily']!=\"\") ? (\"font-family: {\$style['fontfamily']};\") : (\"\")).\"
 {\$style['bodymore']}
}

body a:link, body a:visited, body a:active {
 \".((\$style['pagelinkcolor']!=\"\") ? (\"color: {\$style['pagelinkcolor']};\") : (\"\")).\"
 \".((\$style['pagelinkdeco']!=\"\") ? (\"text-decoration: {\$style['pagelinkdeco']};\") : (\"\")).\"
 {\$style['pagelinkmore']}
}
body a:hover {
 \".((\$style['pagelinkhovercolor']!=\"\") ? (\"color: {\$style['pagelinkhovercolor']};\") : (\"\")).\"
 \".((\$style['pagelinkhoverdeco']!=\"\") ? (\"text-decoration: {\$style['pagelinkhoverdeco']};\") : (\"\")).\"
 {\$style['pagelinkhovermore']}
}

\".((\$style['logobackground']!=\"\") 
? (\"
.logobackground {
 background-image: url({\$style['logobackground']}); 
}
\") : (\"\")
).\"

\".((\$style['mainbgcolor']!=\"\") 
? (\"
.mainpage {
 background-color: {\$style['mainbgcolor']};
}
\") : (\"\")
).\"

\".((\$style['tableoutbordercolor']!=\"\") 
? (\"
.tableoutborder {
 background-color: {\$style['tableoutbordercolor']};
}
\") : (\"\")
).\"

\".((\$style['tableinbordercolor']!=\"\") 
? (\"
.tableinborder {
 background-color: {\$style['tableinbordercolor']};
}

.threadline {
 color: {\$style['tableinbordercolor']};
 background-color: {\$style['tableinbordercolor']};
 height: 1px;
 border: 0;
}
\") : (\"\")
).\"

.tabletitle {
 \".((\$style['tabletitlefontcolor']!=\"\") ? (\"color: {\$style['tabletitlefontcolor']};\") : (\"\")).\"
 \".((\$style['tabletitlebgcolor']!=\"\") ? (\"background-color: {\$style['tabletitlebgcolor']};\") : (\"\")).\"
 {\$style['tabletitlemore']}
}

\".((\$style['tabletitlefontcolor']!=\"\") ? (\"
.tabletitle_fc {
 color: {\$style['tabletitlefontcolor']};
}
\") : (\"\")).\"

.inposttable {
 \".((\$style['inposttablebgcolor']!=\"\") ? (\"background-color: {\$style['inposttablebgcolor']};\") : (\"\")).\"
 {\$style['inposttablemore']}
}

.tabletitle a:link, .tabletitle a:visited, .tabletitle a:active { 
 \".((\$style['tabletitlelinkcolor']!=\"\") ? (\"color: {\$style['tabletitlelinkcolor']};\") : (\"\")).\"
 \".((\$style['tabletitlelinkdeco']!=\"\") ? (\"text-decoration: {\$style['tabletitlelinkdeco']};\") : (\"\")).\"
 {\$style['tabletitlelinkmore']}
}
.tabletitle a:hover { 
 \".((\$style['tabletitlelinkhovercolor']!=\"\") ? (\"color: {\$style['tabletitlelinkhovercolor']};\") : (\"\")).\"
 \".((\$style['tabletitlelinkhoverdeco']!=\"\") ? (\"text-decoration: {\$style['tabletitlelinkhoverdeco']};\") : (\"\")).\"
 {\$style['tabletitlelinkhovermore']}
}

.smallfont {
 \".((\$style['smallfontsize']!=\"\") ? (\"font-size: {\$style['smallfontsize']}px;\") : (\"\")).\"
 \".((\$style['smallfontface']!=\"\") ? (\"font-family: {\$style['smallfontface']};\") : (\"\")).\"
 \".((\$style['smallfontcolor']!=\"\") ? (\"color: {\$style['smallfontcolor']};\") : (\"\")).\"
 {\$style['smallfontmore']}
}

.normalfont {
 \".((\$style['normalfontsize']!=\"\") ? (\"font-size: {\$style['normalfontsize']}px;\") : (\"\")).\"
 \".((\$style['normalfontface']!=\"\") ? (\"font-family: {\$style['normalfontface']};\") : (\"\")).\"
 \".((\$style['normalfontcolor']!=\"\") ? (\"color: {\$style['normalfontcolor']};\") : (\"\")).\"
 {\$style['normalfontmore']}
}

.tablecat {
 \".((\$style['tablecatfontcolor']!=\"\") ? (\"color: {\$style['tablecatfontcolor']};\") : (\"\")).\"
 \".((\$style['tablecatbgcolor']!=\"\") ? (\"background-color: {\$style['tablecatbgcolor']};\") : (\"\")).\"
 {\$style['tablecatmore']}
}

\".((\$style['tablecatfontcolor']!=\"\") ? (\"
.tablecat_fc {
 color: {\$style['tablecatfontcolor']};
}
\") : (\"\")).\"

.tablecat a:link, .tablecat a:visited, .tablecat a:active {
 \".((\$style['tablecatlinkcolor']!=\"\") ? (\"color: {\$style['tablecatlinkcolor']};\") : (\"\")).\"
 \".((\$style['tablecatlinkdeco']!=\"\") ? (\"text-decoration: {\$style['tablecatlinkdeco']};\") : (\"\")).\"
 {\$style['tablecatlinkmore']}
}
.tablecat a:hover { 
 \".((\$style['tablecatlinkhovercolor']!=\"\") ? (\"color: {\$style['tablecatlinkhovercolor']};\") : (\"\")).\"
 \".((\$style['tablecatlinkhoverdeco']!=\"\") ? (\"text-decoration: {\$style['tablecatlinkhoverdeco']};\") : (\"\")).\"
 {\$style['tablecatlinkhovermore']}
}

.tableb {
 \".((\$style['tablebfontcolor']!=\"\") ? (\"color: {\$style['tablebfontcolor']};\") : (\"\")).\"
 \".((\$style['tablebbgcolor']!=\"\") ? (\"background-color: {\$style['tablebbgcolor']};\") : (\"\")).\"
 {\$style['tablebmore']}
}

\".((\$style['tablebfontcolor']!=\"\") ? (\"
.tableb_fc {
 color: {\$style['tablebfontcolor']};
}
\") : (\"\")).\"

.tableb a:link, .tableb a:visited, .tableb a:active { 
 \".((\$style['tableblinkcolor']!=\"\") ? (\"color: {\$style['tableblinkcolor']};\") : (\"\")).\"
 \".((\$style['tableblinkdeco']!=\"\") ? (\"text-decoration: {\$style['tableblinkdeco']};\") : (\"\")).\"
 {\$style['tableblinkmore']}
}
.tableb a:hover { 
 \".((\$style['tableblinkhovercolor']!=\"\") ? (\"color: {\$style['tableblinkhovercolor']};\") : (\"\")).\"
 \".((\$style['tableblinkhoverdeco']!=\"\") ? (\"text-decoration: {\$style['tableblinkhoverdeco']};\") : (\"\")).\"
 {\$style['tableblinkhovermore']}
}

.tablea {
 \".((\$style['tableafontcolor']!=\"\") ? (\"color: {\$style['tableafontcolor']};\") : (\"\")).\"
 \".((\$style['tableabgcolor']!=\"\") ? (\"background-color: {\$style['tableabgcolor']};\") : (\"\")).\"
 {\$style['tableamore']}
}

\".((\$style['tableafontcolor']!=\"\") ? (\"
.tablea_fc {
 color: {\$style['tableafontcolor']};
}
\") : (\"\")).\"

.tablea a:link, .tablea a:visited, .tablea a:active {
 \".((\$style['tablealinkcolor']!=\"\") ? (\"color: {\$style['tablealinkcolor']};\") : (\"\")).\"
 \".((\$style['tablealinkdeco']!=\"\") ? (\"text-decoration: {\$style['tablealinkdeco']};\") : (\"\")).\"
 {\$style['tablealinkmore']}
}
.tablea a:hover { 
 \".((\$style['tablealinkhovercolor']!=\"\") ? (\"color: {\$style['tablealinkhovercolor']};\") : (\"\")).\"
 \".((\$style['tablealinkhoverdeco']!=\"\") ? (\"text-decoration: {\$style['tablealinkhoverdeco']};\") : (\"\")).\"
 {\$style['tablealinkhovermore']}
}

.prefix {
 \".((\$style['prefixfontcolor']!=\"\") ? (\"color: {\$style['prefixfontcolor']};\") : (\"\")).\"
 \".((\$style['prefixfontweight']!=\"\") ? (\"font-weight: {\$style['prefixfontweight']};\") : (\"\")).\"
 \".((\$style['prefixdeco']!=\"\") ? (\"text-decoration: {\$style['prefixdeco']};\") : (\"\")).\"
 {\$style['prefixmore']}
}

.time {
 \".((\$style['timefontcolor']!=\"\") ? (\"color: {\$style['timefontcolor']};\") : (\"\")).\"
 \".((\$style['timefontweight']!=\"\") ? (\"font-weight: {\$style['timefontweight']};\") : (\"\")).\"
 \".((\$style['timedeco']!=\"\") ? (\"text-decoration: {\$style['timedeco']};\") : (\"\")).\"
 {\$style['timemore']}
}

.highlight {
 \".((\$style['highlightfontcolor']!=\"\") ? (\"color: {\$style['highlightfontcolor']};\") : (\"\")).\"
 \".((\$style['highlightfontweight']!=\"\") ? (\"font-weight: {\$style['highlightfontweight']};\") : (\"\")).\"
 \".((\$style['highlightdeco']!=\"\") ? (\"text-decoration: {\$style['highlightdeco']};\") : (\"\")).\"
 {\$style['highlightmore']}
}

select {
 \".((\$style['selectfontsize']!=\"\") ? (\"font-size: {\$style['selectfontsize']};\") : (\"\")).\"
 \".((\$style['selectfontface']!=\"\") ? (\"font-family: {\$style['selectfontface']};\") : (\"\")).\"
 \".((\$style['selectfontcolor']!=\"\") ? (\"color: {\$style['selectfontcolor']};\") : (\"\")).\"
 \".((\$style['selectbgcolor']!=\"\") ? (\"background-color: {\$style['selectbgcolor']};\") : (\"\")).\"
 {\$style['selectmore']}
}

textarea {
 \".((\$style['textareafontsize']!=\"\") ? (\"font-size: {\$style['textareafontsize']};\") : (\"\")).\"
 \".((\$style['textareafontface']!=\"\") ? (\"font-family: {\$style['textareafontface']};\") : (\"\")).\"
 \".((\$style['textareafontcolor']!=\"\") ? (\"color: {\$style['textareafontcolor']};\") : (\"\")).\"
 \".((\$style['textareabgcolor']!=\"\") ? (\"background-color: {\$style['textareabgcolor']};\") : (\"\")).\"
 {\$style['textareamore']}
}

.input {
 \".((\$style['inputfontsize']!=\"\") ? (\"font-size: {\$style['inputfontsize']};\") : (\"\")).\"
 \".((\$style['inputfontface']!=\"\") ? (\"font-family: {\$style['inputfontface']};\") : (\"\")).\"
 \".((\$style['inputfontcolor']!=\"\") ? (\"color: {\$style['inputfontcolor']};\") : (\"\")).\"
 \".((\$style['inputbgcolor']!=\"\") ? (\"background-color: {\$style['inputbgcolor']};\") : (\"\")).\"
 {\$style['inputmore']}
}

.publicevent {
 \".((\$style['highlightfontcolor']!=\"\") ? (\"color: {\$style['publiceventfontcolor']};\") : (\"\")).\"
 {\$style['publiceventmore']}
}

.privateevent {
 \".((\$style['highlightfontcolor']!=\"\") ? (\"color: {\$style['privateeventfontcolor']};\") : (\"\")).\"
 {\$style['privateeventmore']}
}

.hoverMenu {
 display: none;
 position: absolute;
 z-index: 10;
 padding: 5px;
 border: 1px solid {\$style['tableinbordercolor']};
 \".((\$style['tableafontcolor']!=\"\") ? (\"color: {\$style['tableafontcolor']};\") : (\"\")).\"
 \".((\$style['tableabgcolor']!=\"\") ? (\"background-color: {\$style['tableabgcolor']};\") : (\"\")).\"
}
.hoverMenu ul {
 list-style-type: none;
 margin: 0;
 padding: 0;
 
}
.hoverMenu ul li {
 text-align: left;
 padding: 0;
}

{\$style['cssmore']}

-->
</style>";
?>
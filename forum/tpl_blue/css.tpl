<style type="text/css">
 <!--
body {
 <if($style['fontcolor']!="")><then>color: {$style['fontcolor']};</then></if>
 <if($style['pagebgcolor']!="")><then>background-color: {$style['pagebgcolor']};</then></if>
 <if($style['fontfamily']!="")><then>font-family: {$style['fontfamily']};</then></if>
 {$style['bodymore']}
}

body a:link, body a:visited, body a:active {
 <if($style['pagelinkcolor']!="")><then>color: {$style['pagelinkcolor']};</then></if>
 <if($style['pagelinkdeco']!="")><then>text-decoration: {$style['pagelinkdeco']};</then></if>
 {$style['pagelinkmore']}
}
body a:hover {
 <if($style['pagelinkhovercolor']!="")><then>color: {$style['pagelinkhovercolor']};</then></if>
 <if($style['pagelinkhoverdeco']!="")><then>text-decoration: {$style['pagelinkhoverdeco']};</then></if>
 {$style['pagelinkhovermore']}
}

<if($style['logobackground']!="")>
<then>
.logobackground {
 background-image: url({$style['logobackground']}); 
}
</then>
</if>

<if($style['mainbgcolor']!="")>
<then>
.mainpage {
 background-color: {$style['mainbgcolor']};
}
</then>
</if>

<if($style['tableoutbordercolor']!="")>
<then>
.tableoutborder {
 background-color: {$style['tableoutbordercolor']};
}
</then>
</if>

<if($style['tableinbordercolor']!="")>
<then>
.tableinborder {
 background-color: {$style['tableinbordercolor']};
}

.threadline {
 color: {$style['tableinbordercolor']};
 background-color: {$style['tableinbordercolor']};
 height: 1px;
 border: 0;
}
</then>
</if>

.tabletitle {
 <if($style['tabletitlefontcolor']!="")><then>color: {$style['tabletitlefontcolor']};</then></if>
 <if($style['tabletitlebgcolor']!="")><then>background-color: {$style['tabletitlebgcolor']};</then></if>
 {$style['tabletitlemore']}
}

<if($style['tabletitlefontcolor']!="")><then>
.tabletitle_fc {
 color: {$style['tabletitlefontcolor']};
}
</then></if>

.inposttable {
 <if($style['inposttablebgcolor']!="")><then>background-color: {$style['inposttablebgcolor']};</then></if>
 {$style['inposttablemore']}
}

.tabletitle a:link, .tabletitle a:visited, .tabletitle a:active { 
 <if($style['tabletitlelinkcolor']!="")><then>color: {$style['tabletitlelinkcolor']};</then></if>
 <if($style['tabletitlelinkdeco']!="")><then>text-decoration: {$style['tabletitlelinkdeco']};</then></if>
 {$style['tabletitlelinkmore']}
}
.tabletitle a:hover { 
 <if($style['tabletitlelinkhovercolor']!="")><then>color: {$style['tabletitlelinkhovercolor']};</then></if>
 <if($style['tabletitlelinkhoverdeco']!="")><then>text-decoration: {$style['tabletitlelinkhoverdeco']};</then></if>
 {$style['tabletitlelinkhovermore']}
}

.smallfont {
 <if($style['smallfontsize']!="")><then>font-size: {$style['smallfontsize']}px;</then></if>
 <if($style['smallfontface']!="")><then>font-family: {$style['smallfontface']};</then></if>
 <if($style['smallfontcolor']!="")><then>color: {$style['smallfontcolor']};</then></if>
 {$style['smallfontmore']}
}

.normalfont {
 <if($style['normalfontsize']!="")><then>font-size: {$style['normalfontsize']}px;</then></if>
 <if($style['normalfontface']!="")><then>font-family: {$style['normalfontface']};</then></if>
 <if($style['normalfontcolor']!="")><then>color: {$style['normalfontcolor']};</then></if>
 {$style['normalfontmore']}
}

.tablecat {
 <if($style['tablecatfontcolor']!="")><then>color: {$style['tablecatfontcolor']};</then></if>
 <if($style['tablecatbgcolor']!="")><then>background-color: {$style['tablecatbgcolor']};</then></if>
 {$style['tablecatmore']}
}

<if($style['tablecatfontcolor']!="")><then>
.tablecat_fc {
 color: {$style['tablecatfontcolor']};
}
</then></if>

.tablecat a:link, .tablecat a:visited, .tablecat a:active {
 <if($style['tablecatlinkcolor']!="")><then>color: {$style['tablecatlinkcolor']};</then></if>
 <if($style['tablecatlinkdeco']!="")><then>text-decoration: {$style['tablecatlinkdeco']};</then></if>
 {$style['tablecatlinkmore']}
}
.tablecat a:hover { 
 <if($style['tablecatlinkhovercolor']!="")><then>color: {$style['tablecatlinkhovercolor']};</then></if>
 <if($style['tablecatlinkhoverdeco']!="")><then>text-decoration: {$style['tablecatlinkhoverdeco']};</then></if>
 {$style['tablecatlinkhovermore']}
}

.tableb {
 <if($style['tablebfontcolor']!="")><then>color: {$style['tablebfontcolor']};</then></if>
 <if($style['tablebbgcolor']!="")><then>background-color: {$style['tablebbgcolor']};</then></if>
 {$style['tablebmore']}
}

<if($style['tablebfontcolor']!="")><then>
.tableb_fc {
 color: {$style['tablebfontcolor']};
}
</then></if>

.tableb a:link, .tableb a:visited, .tableb a:active { 
 <if($style['tableblinkcolor']!="")><then>color: {$style['tableblinkcolor']};</then></if>
 <if($style['tableblinkdeco']!="")><then>text-decoration: {$style['tableblinkdeco']};</then></if>
 {$style['tableblinkmore']}
}
.tableb a:hover { 
 <if($style['tableblinkhovercolor']!="")><then>color: {$style['tableblinkhovercolor']};</then></if>
 <if($style['tableblinkhoverdeco']!="")><then>text-decoration: {$style['tableblinkhoverdeco']};</then></if>
 {$style['tableblinkhovermore']}
}

.tablea {
 <if($style['tableafontcolor']!="")><then>color: {$style['tableafontcolor']};</then></if>
 <if($style['tableabgcolor']!="")><then>background-color: {$style['tableabgcolor']};</then></if>
 {$style['tableamore']}
}

<if($style['tableafontcolor']!="")><then>
.tablea_fc {
 color: {$style['tableafontcolor']};
}
</then></if>

.tablea a:link, .tablea a:visited, .tablea a:active {
 <if($style['tablealinkcolor']!="")><then>color: {$style['tablealinkcolor']};</then></if>
 <if($style['tablealinkdeco']!="")><then>text-decoration: {$style['tablealinkdeco']};</then></if>
 {$style['tablealinkmore']}
}
.tablea a:hover { 
 <if($style['tablealinkhovercolor']!="")><then>color: {$style['tablealinkhovercolor']};</then></if>
 <if($style['tablealinkhoverdeco']!="")><then>text-decoration: {$style['tablealinkhoverdeco']};</then></if>
 {$style['tablealinkhovermore']}
}

.prefix {
 <if($style['prefixfontcolor']!="")><then>color: {$style['prefixfontcolor']};</then></if>
 <if($style['prefixfontweight']!="")><then>font-weight: {$style['prefixfontweight']};</then></if>
 <if($style['prefixdeco']!="")><then>text-decoration: {$style['prefixdeco']};</then></if>
 {$style['prefixmore']}
}

.time {
 <if($style['timefontcolor']!="")><then>color: {$style['timefontcolor']};</then></if>
 <if($style['timefontweight']!="")><then>font-weight: {$style['timefontweight']};</then></if>
 <if($style['timedeco']!="")><then>text-decoration: {$style['timedeco']};</then></if>
 {$style['timemore']}
}

.highlight {
 <if($style['highlightfontcolor']!="")><then>color: {$style['highlightfontcolor']};</then></if>
 <if($style['highlightfontweight']!="")><then>font-weight: {$style['highlightfontweight']};</then></if>
 <if($style['highlightdeco']!="")><then>text-decoration: {$style['highlightdeco']};</then></if>
 {$style['highlightmore']}
}

select {
 <if($style['selectfontsize']!="")><then>font-size: {$style['selectfontsize']};</then></if>
 <if($style['selectfontface']!="")><then>font-family: {$style['selectfontface']};</then></if>
 <if($style['selectfontcolor']!="")><then>color: {$style['selectfontcolor']};</then></if>
 <if($style['selectbgcolor']!="")><then>background-color: {$style['selectbgcolor']};</then></if>
 {$style['selectmore']}
}

textarea {
 <if($style['textareafontsize']!="")><then>font-size: {$style['textareafontsize']};</then></if>
 <if($style['textareafontface']!="")><then>font-family: {$style['textareafontface']};</then></if>
 <if($style['textareafontcolor']!="")><then>color: {$style['textareafontcolor']};</then></if>
 <if($style['textareabgcolor']!="")><then>background-color: {$style['textareabgcolor']};</then></if>
 {$style['textareamore']}
}

.input {
 <if($style['inputfontsize']!="")><then>font-size: {$style['inputfontsize']};</then></if>
 <if($style['inputfontface']!="")><then>font-family: {$style['inputfontface']};</then></if>
 <if($style['inputfontcolor']!="")><then>color: {$style['inputfontcolor']};</then></if>
 <if($style['inputbgcolor']!="")><then>background-color: {$style['inputbgcolor']};</then></if>
 {$style['inputmore']}
}

.publicevent {
 <if($style['highlightfontcolor']!="")><then>color: {$style['publiceventfontcolor']};</then></if>
 {$style['publiceventmore']}
}

.privateevent {
 <if($style['highlightfontcolor']!="")><then>color: {$style['privateeventfontcolor']};</then></if>
 {$style['privateeventmore']}
}

.hoverMenu {
 display: none;
 position: absolute;
 z-index: 10;
 padding: 5px;
 border: 1px solid {$style['tableinbordercolor']};
 <if($style['tableafontcolor']!="")><then>color: {$style['tableafontcolor']};</then></if>
 <if($style['tableabgcolor']!="")><then>background-color: {$style['tableabgcolor']};</then></if>
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

{$style['cssmore']}

-->
</style>
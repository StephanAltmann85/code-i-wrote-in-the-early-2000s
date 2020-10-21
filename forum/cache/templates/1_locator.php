<?php
/*
templatepackid: 1
templatename: locator
*/

$this->templates['locator']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_LOCATOR_TITLE']}</title>
\$headinclude
<script type=\\\"text/javascript\\\">
<!--
 function Message(Message) {
  var x = window.confirm(Message);
  return x;
 }
//-->
</script>
</head>

<body>
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_LOCATOR_TITLE']}</b></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
 </table><br />

<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:{\$style['tableinwidth']}\\\" align=\\\"center\\\">
 <tr>
  <td><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tabletitle\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\">\".((\$task == \"show\") ? (\"{\$lang->items['LANG_LOCATOR_CHOOSE_STATE']}\") : (\"{\$lang->items['LANG_LOCATOR_ENTER_CHOOSE_STATE']}\")).\"</span></td>
   </tr>
   \".((\$task != \"show\") ? (\" 
   <tr>
    <td class=\\\"tableb\\\" align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_LOCATOR_ENTER_INSTRUCTION']}</span></td>   
   </tr>\") 
   : (\"
   <tr>
    <td class=\\\"tableb\\\" align=\\\"left\\\"><span class=\\\"smallfont\\\"><img src=\\\"{\$style['imagefolder']}/locator/mark.gif\\\" alt=\\\"\\\" border=\\\"\\\">&nbsp;{\$lang->items['LANG_LOCATOR_SHOW_MARK']}&nbsp;&nbsp;&nbsp;<img src=\\\"{\$style['imagefolder']}/locator/mark_own.gif\\\" alt=\\\"\\\" border=\\\"\\\">&nbsp;{\$lang->items['LANG_LOCATOR_SHOW_MARK_OWN']}</span></td>   
   </tr>
   \")).\"
   <tr>
    <td class=\\\"tablea\\\" align=\\\"center\\\">

     <IMG SRC=\\\"{\$style['imagefolder']}/locator/locator.gif\\\" WIDTH=490 HEIGHT=646 BORDER=0 USEMAP=\\\"#Deutschland_Map\\\">
     <MAP NAME=\\\"Deutschland_Map\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Mecklenburg-Vorpommern\\\" COORDS=\\\"365,61, 381,71, 394,72, 397,82, 400,88, 400,94, 411,101, 419,102, 425,135, 418,140, 415,138, 420,127, 402,123, 391,127, 378,142, 373,143, 370,146, 365,147, 359,150, 345,147, 323,140, 312,141, 298,149, 290,151, 287,158, 272,156, 256,143, 251,142, 243,135, 259,115, 249,104,
252,97, 266,86, 272,88, 276,91, 284,90, 297,73, 310,70, 346,53, 349,53, 355,47, 363,59\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=8{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[8],height=\$images_height[8]')\\\">
<AREA SHAPE=\\\"poly\\\" ALT=\\\"Schleswig-Holstein\\\" COORDS=\\\"176,21, 182,20, 190,19, 213,34, 210,47, 208,49, 220,51, 223,54, 235,55, 251,61, 260,56, 264,52, 260,47, 265,44, 273,49, 272,53, 264,62, 261,74, 250,87, 256,92, 250,105, 256,112, 259,117, 254,124, 237,139, 221,126, 221,110, 196,123, 180,104, 172,98, 160,94, 160,85, 164,84,
158,77, 157,69, 156,65, 146,63, 146,60, 148,58, 164,48, 147,21, 149,14\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=15{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[15],height=\$images_height[15]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Hessen\\\" COORDS=\\\"199,286, 196,293, 194,302, 195,306, 203,307, 203,302, 212,303, 217,311, 226,322, 226,330, 223,333, 217,335, 217,347, 214,362, 220,363, 215,380, 203,386, 202,391, 193,397, 186,408, 178,404, 175,404, 164,409, 171,435, 170,440, 166,456, 159,462, 155,462, 155,456, 148,450, 145,446, 141,454,
131,442, 133,432, 124,413, 102,412, 103,407, 112,395, 117,389, 112,376, 115,370, 120,369, 125,345, 133,342, 140,328, 144,325, 149,324, 150,312, 142,311, 154,302, 161,299, 161,293, 169,294, 173,297, 183,285, 190,281\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=7{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[7],height=\$images_height[7]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Rheinland-Pfalz\\\" COORDS=\\\"105,340, 113,354, 120,364, 117,371, 113,372, 115,384, 116,393, 105,405, 102,411, 109,416, 125,413, 131,422, 132,439, 135,475, 132,480, 125,498, 113,495, 85,487, 80,481, 74,480, 75,476, 77,465, 74,461, 71,450, 54,445, 35,451, 25,447, 33,429, 18,419, 14,399, 25,387, 45,385,
49,380, 50,374, 55,373, 63,366, 80,358, 97,347, 104,338\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=11{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[11],height=\$images_height[11]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Saarland\\\" COORDS=\\\"74,458, 77,465, 77,473, 74,479, 77,483, 71,485, 58,480, 50,479, 42,480, 34,466, 28,456, 24,455, 28,450, 50,447, 64,446, 75,455\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=12{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[12],height=\$images_height[12]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Bremen\\\" COORDS=\\\"148,123, 146,132, 139,124, 142,120\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=5{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[5],height=\$images_height[5]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Bremen\\\" COORDS=\\\"164,161, 161,171, 147,163, 145,153\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=5{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[5],height=\$images_height[5]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Niedersachsen\\\" COORDS=\\\"162,102, 180,103, 205,133, 215,134, 219,135, 239,139, 251,142, 263,144, 274,157, 283,163, 291,167, 288,172, 276,179, 261,180, 252,186, 257,196, 261,205, 264,217, 267,222, 268,231, 263,242, 262,246, 244,251, 244,264, 248,274, 247,286, 234,289, 213,302, 202,303, 200,309, 194,303,
196,297, 198,287, 194,283, 184,277, 184,263, 172,245, 167,240, 165,238, 165,232, 167,224, 170,217, 169,212, 157,221, 150,217, 147,209, 136,215, 130,217, 138,228, 135,242, 124,245, 109,244, 114,238, 110,234, 109,221, 100,218, 94,214, 91,222, 74,230, 65,228, 66,217, 63,214, 49,210, 56,197, 68,195, 73,176, 76,163, 74,144, 66,142,
70,128, 73,125, 75,118, 86,114, 117,114, 124,128, 119,132, 130,135, 129,128, 130,120, 147,127, 142,121, 139,114, 147,98\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=9{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[9],height=\$images_height[9]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Baden-Württemberg\\\" COORDS=\\\"198,436, 200,439, 208,441, 213,456, 224,458, 230,483, 233,492, 243,503, 238,524, 233,524, 233,536, 226,540, 218,549, 224,563, 226,579, 221,604, 213,605, 202,611, 194,611, 187,606, 177,601, 174,601, 173,606, 164,602, 158,607, 153,603, 150,602, 145,596, 134,601, 135,607,
138,610, 131,614, 118,612, 104,613, 99,614, 91,614, 88,612, 83,602, 96,551, 103,525, 127,492, 133,479, 133,476, 136,461, 136,449, 143,453, 146,446, 153,455, 156,460, 156,464, 169,454, 174,450, 186,438, 182,434\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=1{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[1],height=\$images_height[1]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Sachsen-Anhalt\\\" COORDS=\\\"304,171, 308,176, 325,181, 329,209, 332,242, 341,247, 359,251, 375,262, 373,274, 349,279, 332,284, 327,289, 330,321, 332,325, 331,333, 318,330, 286,313, 289,306, 282,299, 264,294, 256,280, 249,277, 245,263, 249,247, 263,244, 265,235, 268,231, 267,222, 262,209, 259,199, 251,186,
256,181, 263,178, 287,173, 292,166\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=14{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[14],height=\$images_height[14]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Berlin\\\" COORDS=\\\"390,193, 391,196, 396,203, 402,212, 395,215, 368,209, 373,195, 381,192\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=3{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[3],height=\$images_height[3]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Brandenburg\\\" COORDS=\\\"411,128, 420,128, 419,140, 429,135, 424,161, 418,167, 422,176, 444,197, 442,206, 445,219, 451,223, 453,234, 449,253, 450,258, 457,274, 450,277, 422,287, 417,293, 395,294, 385,292, 380,295, 375,278, 371,274, 376,268, 371,257, 346,250, 330,241, 328,231, 326,207, 323,206, 321,179,
304,174, 284,163, 276,161, 279,159, 290,153, 294,148, 304,147, 319,139, 332,144, 349,150, 366,146, 375,141, 384,139, 393,124, 398,121, 402,122, 407,126\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=4{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[4],height=\$images_height[4]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Hamburg\\\" COORDS=\\\"224,121, 224,127, 229,136, 219,137, 202,132, 200,120, 207,117, 222,111\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=6{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[6],height=\$images_height[6]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Sachsen\\\" COORDS=\\\"375,278, 378,289, 382,295, 390,291, 403,296, 422,288, 428,280, 443,278, 461,281, 469,285, 472,309, 463,337, 455,332, 454,329, 451,329, 450,322, 435,324, 441,332, 394,358, 391,358, 383,367, 374,373, 369,376, 360,375, 344,384, 339,395, 337,397, 329,386, 320,381, 317,375, 316,370, 316,367,
321,363, 325,365, 334,355, 338,342, 343,339, 352,334, 337,323, 328,318, 326,292, 331,284, 369,276\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=13{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[13],height=\$images_height[13]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Thüringen\\\" COORDS=\\\"261,283, 268,298, 287,303, 290,309, 289,314, 295,323, 304,325, 319,331, 333,330, 335,322, 345,326, 353,336, 343,341, 332,351, 333,360, 322,365, 318,364, 315,370, 318,374, 312,380, 292,378, 288,371, 283,378, 280,390, 277,388, 273,385, 257,384, 255,388, 259,394, 249,396, 244,385,
235,377, 221,370, 214,362, 213,364, 210,359, 218,344, 218,341, 217,340, 220,333, 227,332, 224,325, 224,317, 212,303, 218,299, 233,288, 240,285, 248,284, 255,280\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=16{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[16],height=\$images_height[16]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Nordrhein-Westfalen\\\" COORDS=\\\"150,213, 153,220, 164,217, 165,213, 171,214, 168,224, 163,230, 167,236, 167,240, 174,246, 177,254, 185,271, 181,291, 169,297, 165,292, 160,297, 159,302, 144,308, 144,313, 151,314, 148,325, 139,327, 137,337, 129,345, 120,352, 119,359, 110,349, 109,346, 104,340, 102,338, 92,354,
80,360, 76,364, 63,367, 55,372, 52,376, 48,376, 46,385, 26,381, 24,373, 18,368, 19,364, 21,362, 10,345, 13,338, 5,325, 16,318, 19,303, 22,299, 20,287, 11,266, 12,262, 21,258, 39,259, 53,254, 50,249, 48,245, 68,231, 85,226, 93,216, 98,215, 106,222, 112,223, 114,237, 112,243, 112,248, 137,235, 135,223, 131,215, 138,212\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=10{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[10],height=\$images_height[10]')\\\">
     <AREA SHAPE=\\\"poly\\\" ALT=\\\"Bayern\\\" COORDS=\\\"234,376, 259,394, 258,390, 255,385, 267,384, 278,388, 282,391, 287,371, 291,374, 298,381, 320,381, 327,386, 332,395, 339,405, 352,421, 348,428, 346,434, 354,443, 365,461, 372,464, 380,466, 395,481, 409,492, 425,507, 421,528, 417,527, 407,527, 402,545, 391,550, 383,554, 370,567, 381,578,
383,588, 383,595, 390,601, 389,605, 386,615, 378,613, 374,605, 367,600, 356,603, 350,600, 341,604, 337,607, 307,615, 297,619, 288,624, 274,624, 264,618, 248,616, 244,617, 244,628, 232,637, 231,632, 227,629, 225,624, 207,609, 212,605, 226,601, 221,555, 220,544, 226,539, 236,533, 236,522, 244,521, 242,512, 238,496, 230,487,
230,483, 226,482, 220,455, 213,455, 210,450, 207,440, 198,436, 195,434, 182,437, 186,441, 183,444, 174,450, 168,448, 170,440, 167,428, 171,405, 175,404, 185,407, 192,406, 193,397, 203,386, 206,381, 215,379, 225,370\\\" HREF=\\\"#\\\" onclick=\\\"window.open('locator.php?action=\$task&id=2{\$SID_ARG_2ND_UN}', 'moo', 'toolbar=no,scrollbars=no,resizable=yes,width=\$images_width[2],height=\$images_height[2]')\\\">
     </MAP>

    </td>
   </tr>  
   <tr class=\\\"tabletitle\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\">\".((\$got_entry) ? (\"<a href=\\\"locator.php?action=delete{\$SID_ARG_2ND}\\\" onClick=\\\"return Message('{\$lang->items['LANG_LOCATOR_DELETE_MESSAGE']}')\\\">{\$lang->items['LANG_LOCATOR_DELETE']}</a>\") : (\"\".((\$task == \"show\") ? (\"<a href=\\\"locator.php?action=enter_step1{\$SID_ARG_2ND_UN}\\\">{\$lang->items['LANG_LOCATOR_ENTER']}</a>\") : (\"&nbsp;\")).\"\")).\"</span></td>
   </tr>
   </table>

  </td>
 </tr>
</table>

<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"left\\\" valign=\\\"top\\\">\$boardjump</td>
  <td align=\\\"right\\\" valign=\\\"top\\\">&nbsp;</td>
 </tr>
</table>

\$footer

</body>
</html>";
?>
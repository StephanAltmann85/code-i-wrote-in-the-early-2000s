<select name="sortfield">
                <option value="prefix" $f_select[prefix]>{$lang->items['LANG_BOARD_SORTFIELD_PREFIX']}</option>
                <option value="topic" $f_select[topic]>{$lang->items['LANG_BOARD_SORTFIELD_TOPIC']}</option>
                <option value="starttime" $f_select[starttime]>{$lang->items['LANG_BOARD_SORTFIELD_STARTTIME']}</option>
                <option value="replycount" $f_select[replycount]>{$lang->items['LANG_BOARD_SORTFIELD_REPLYCOUNT']}</option>
                <option value="starter" $f_select[starter]>{$lang->items['LANG_BOARD_SORTFIELD_STARTER']}</option>
                <option value="views" $f_select[views]>{$lang->items['LANG_BOARD_SORTFIELD_VIEWS']}</option>
                <if($board['allowratings']==1)><then><option value="vote" $f_select[vote]>{$lang->items['LANG_BOARD_SORTFIELD_VOTE']}</option></then></if>
                <option value="lastposttime" $f_select[lastposttime]>{$lang->items['LANG_BOARD_SORTFIELD_LASTPOSTTIME']}</option>
                <option value="lastposter" $f_select[lastposter]>{$lang->items['LANG_BOARD_SORTFIELD_LASTPOSTER']}</option>
        </select>
<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once(dirname(__FILE__).'/inc_menu.php');

function tpl_content() { global $page;
?>

<?php echo getlocal("page_search.intro") ?>
<br />
<br />

<form name="searchForm" method="get" action="<?php echo MIBEW_WEB_ROOT ?>/operator/history.php">
	<div class="mform"><div class="formtop"><div class="formtopi"></div></div><div class="forminner">
	
	<div class="fieldForm">
		<div class="field">
			<label for="q" class="flabel"><?php echo getlocal("page_analysis.full.text.search") ?></label>
			<div class="fvaluenodesc">
				<div id="searchtext">
					<input id="q" type="text" name="q" size="60" value="<?php echo form_value($page, 'q') ?>" class="formauth"/>
				</div>
				<div class="searchctrl">
					<label for="type"><?php echo getlocal("page_search.type.title") ?></label>
					<select id="type" name="type" onchange="if (this.value == 'all' || this.value == 'message') {document.getElementById('inSystemMessages').style.display='inline'} else {document.getElementById('inSystemMessages').style.display='none'}; ">
						<option value="all" <?php echo (form_value($page, 'type') == 'all')?'selected="selected"':'' ?>><?php echo getlocal("page_search.type.all") ?></option>
						<option value="message" <?php echo (form_value($page, 'type') == 'message')?'selected="selected"':'' ?>><?php echo getlocal("page_search.type.message") ?></option>
						<option value="operator" <?php echo (form_value($page, 'type') == 'operator')?'selected="selected"':'' ?>><?php echo getlocal("page_search.type.operator") ?></option>
						<option value="visitor" <?php echo (form_value($page, 'type') == 'visitor')?'selected="selected"':'' ?>><?php echo getlocal("page_search.type.visitor") ?></option>
					</select>
				</div>
				<div id="searchbutton">
					<input type="image" name="search" src='<?php echo MIBEW_WEB_ROOT . getlocal("image.button.search") ?>' alt='<?php echo getlocal("button.search") ?>'/>
				</div><br clear="all"/>
				<div class="searchctrl" id="inSystemMessages"<?php echo ((form_value($page, 'type') != 'all' && form_value($page, 'type') != 'message')?' style="display: none;"':'')?>>
					<input id="insystemmessagesfield" type="checkbox" name="insystemmessages" <?php echo (form_value($page, 'insystemmessages')?'checked="checked"':'') ?>/> <label for="insystemmessagesfield"><?php echo getlocal("page_search.search.type.in_system_messages") ?></label>
				</div>
			</div>
			<br clear="all"/>
		</div>
	</div>
	
	</div><div class="formbottom"><div class="formbottomi"></div></div></div>
</form>
<br/>


<?php if( $page['pagination'] ) { ?>

<table class="list">
<thead>
<tr class="header">
<th>
	<?php echo getlocal("page.analysis.search.head_name") ?>
</th><th>
	<?php echo getlocal("page.analysis.search.head_host") ?>
</th><th>
	<?php echo getlocal("page.analysis.search.head_operator") ?>
</th><th>
	<?php echo getlocal("page.analysis.search.head_messages") ?>
</th><th>
	<?php echo getlocal("page.analysis.search.head_time") ?>
</th></tr>
</thead>
<tbody>
<?php 
if( $page['pagination.items'] ) {
	foreach( $page['pagination.items'] as $chatthread ) { ?>
	<tr>
		<td>
			<a href="<?php echo MIBEW_WEB_ROOT ?>/operator/threadprocessor.php?threadid=<?php echo $chatthread->id ?>" target="_blank" onclick="this.newWindow = window.open('<?php echo MIBEW_WEB_ROOT ?>/operator/threadprocessor.php?threadid=<?php echo $chatthread->id ?>', '', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=720,height=520,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><?php echo topage(htmlspecialchars($chatthread->userName)) ?></a>
		</td>
		<td>
			<?php echo get_user_addr(topage($chatthread->remote)) ?>
		</td>
		<td>
			<?php if( $chatthread->agentName ) {
				echo topage(htmlspecialchars($chatthread->agentName));
			} else if($chatthread->groupId && $chatthread->groupId != 0 && isset($page['groupName'][$chatthread->groupId])) {
				echo "- ".topage(htmlspecialchars($page['groupName'][$chatthread->groupId]))." -";
			}
			?>
		</td>
		<td>
			<?php echo topage(htmlspecialchars($chatthread->messageCount)) ?>
		</td>
		<td>
			<?php echo date_diff_to_text($chatthread->modified-$chatthread->created) ?>, <?php echo date_to_text($chatthread->created) ?>
		</td>
	</tr>
<?php
	} 
} else {
?>
	<tr>
	<td colspan="5">
		<?php echo getlocal("tag.pagination.no_items") ?>
	</td>
	</tr>
<?php 
} 
?>
</tbody>
</table>
<?php
	if( $page['pagination.items'] ) { 
		echo "<br/>";
		echo generate_pagination($page['pagination']);
	}
} 
?>

<?php 
} /* content */

require_once(dirname(__FILE__).'/inc_main.php');
?>
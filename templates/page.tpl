{if $published}
	{if $clientonly}
		{if $loggedin}
			{if $showdate}<span style="float:right; color:gray;">تاريخ انتشار: {$pagedate}</span>{/if}
			{if $showviews}<span style="float:left; color:gray;">تعداد بازديد: {$pageviews}</span>{/if}
			{if $showdate or $showviews}<div style="clear:both;"></div><hr/>{/if}
			{$pagecontent|html_entity_decode}
			<br/>
			{if $sharekeys}
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-504c86fb1db7c09a"></script>
				<!-- AddThis Button END -->
			{/if}
		{else}
			براي مشاهده صفحه لطفا وارد شويد.
		{/if}
	{else}
		{if $showdate}<span style="float:right; color:gray;">تاريخ انتشار: {$pagedate}</span>{/if}
		{if $showviews}<span style="float:left; color:gray;">تعداد بازديد: {$pageviews}</span>{/if}
		{if $showdate or $showviews}<div style="clear:both;"></div><hr/>{/if}
		{$pagecontent|html_entity_decode}
		{if $sharekeys}
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-504c86fb1db7c09a"></script>
			<!-- AddThis Button END -->
		{/if}
	{/if}
{else}
	صفحه مورد نظر موجود نمي باشد.
{/if}
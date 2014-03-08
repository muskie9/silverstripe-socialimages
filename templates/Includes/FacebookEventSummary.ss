<li>ID: {$ID}<br />
	$Name<br />
	<img src="$Picture" class="scale-with-grid" />
	<br />
	$StartTime.Nice<% if $EndTime %> - $EndTime.Nice<% end_if %><br />
	@{$Location}
</li>
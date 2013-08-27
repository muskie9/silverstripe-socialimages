<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
		<% if FacebookObjects %>
		<ul>
			<% if Top.DataType = Events %>
			<% loop FacebookObjects %>
			<% include FacebookEventSummary %>
			<% end_loop %>
			<% else %>
			<% loop FacebookObjects %>
			<% include FacebookAlbumSummary %>
			<% end_loop %>
			<% end_if %>
		</ul>
		<% end_if %>
	</article>
</div>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
		<% if $FacebookObjects %>
		<ul>
			<% loop $FacebookObjects %>
			<li><img src="$SmallImage" class="scale-with-grid" /><% if $Caption %><br /><em>$Caption</em><% end_if %></li>
			<% end_loop %>
		</ul>
		<% end_if %>
	</article>
</div>
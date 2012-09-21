$ ->
	# Toggle pictures
	$('#picturesTitle').click ->
		$('#picturesTitle .toggle').toggle()
		$('#pictures').toggle()
		return false

	# Toggle videos
	$('#videoTitle').click ->
		$('#videoTitle .toggle').toggle()
		$('#videos').toggle()
		return false

	# Toggle audio
	$('#audioTitle').click ->
		$('#audioTitle .toggle').toggle()
		$('#audios').toggle()
		return false

	# Filter groups act as radio buttons
	$('.filter-group a').click ->
		$(this).addClass('active')
		$(this).siblings().removeClass('active')

	# Searching and filtering
	filterByGender = (children, gender) ->
		for child in children
			$(child).hide() unless $(child).data('gender') is gender

	filterByAge = (children, minAge, maxAge) ->
		for child in children
			$(child).hide() unless minAge <= $(child).data('age') <= maxAge

	filterByName = (children, name) ->
		for child in children
			childName = $.trim($(child).text().toUpperCase())
			$(child).hide() unless childName.indexOf(name) isnt -1

	filterChildren = ->
		children = $('#children li')
		children.show()

		# Filter by gender
		targetGender = $('#gender-filters .active').data('gender')
		filterByGender(children, targetGender) if targetGender
		# Filter by age
		targetAgeRange = $('#age-filters .active').data('age')
		[minAge, maxAge] = targetAgeRange.split('-') if targetAgeRange
		filterByAge(children, minAge, maxAge) if minAge and maxAge
		# Filter by name
		targetName = $.trim($('#search').val().toUpperCase())
		filterByName(children, targetName) if targetName

	# For performance, wait until user is done typing to filter
	delay = (callback, time) ->
		timer = 0;
		return  ->
			clearTimeout(timer)
			timer = setTimeout(callback, time)

	# Bind searching and filtering to UI
	$('#search').bind('change keyup', delay(filterChildren, 200))
	$('.filter-group a').click(filterChildren)

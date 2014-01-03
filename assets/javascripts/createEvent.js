function validateForm(fCreateEvent) 
{

	var sTitle = fCreateEvent.title.value;
	var sDescription = fCreateEvent.description.value;
	var sAddress = fCreateEvent.address.value;
	var sStart = fCreateEvent.eventstart.value;
	var sStartTime = fCreateEvent.eventstarttime.value;
	var sEnd = fCreateEvent.eventend.value;
	var sEndTime = fCreateEvent.eventendtime.value;
	var sCycle = fCreateEvent.cycle.value;
	var sCount = fCreateEvent.count.value;
	var sInterests = fCreateEvent.tagids.value;


	var reText = /^[\w\s]+$/;
	var reTagIds = /^[0-9,]+$/;
	var reDates = /^(?:(?:(?:0?[13578]|1[02])(\/|-|\.)31)\1|(?:(?:0?[1,3-9]|1[0-2])(\/|-|\.)(?:29|30)\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:0?2(\/|-|\.)29\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:(?:0?[1-9])|(?:1[0-2]))(\/|-|\.)(?:0?[1-9]|1\d|2[0-8])\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
	var reTimes = /^([0-9]|0[0-9]|1[0-2]):[0-5][0-9]$/
	var reCount = /^[0-9]{1,2}$/;

	var sErrors = "";
	if (!reText.test(sTitle))
	{
		sErrors += "Invalid Title\n";
	}

	if (!reText.test(sDescription))
	{
		sErrors += "Invalid Description\n";
	}

	if (!reText.test(sAddress))
	{
		sErrors += "Invalid Address\n";
	}

	if (!reDates.test(sStart))
	{
		sErrors += "Invalid Start Date\n";
	}
	
	if (!reTimes.test(sStartTime))
	{
		sErrors += "Invalid Start Time\n";
	}

	if (!reDates.test(sEnd))
	{
		sErrors += "Invalid End Date\n";
	}


	if (!reTimes.test(sEndTime))
	{
		sErrors += "Invalid End Time\n";
	}

	if (sCycle !== "0" && !reCount.test(sCount))
	{
		sErrors += "Invalid Count\n";
	}

	if (!reTagIds.test(sInterests))
	{
		sErrors += "Invalid Interests\n";
	}

	if (sErrors === "")
	{
		return true;
	}
	else
	{
		alert(sErrors);
		return false;
	}
}
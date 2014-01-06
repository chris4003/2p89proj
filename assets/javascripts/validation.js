function validateCreateEvent(fCreateEvent) 
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
	var reTimes1 = /^([0-9]|0[0-9]|1[0-2]):[0-5][0-9]:[0-5][0-9]$/
	var reTimes2 = /^([0-9]|0[0-9]|1[0-2]):[0-5][0-9]$/
	var reTimes3 = /^([0-9]|0[0-9]|1[0-2])$/
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
	
	if (!reTimes1.test(sStartTime) && !reTimes2.test(sStartTime) && !reTimes3.test(sStartTime))
	{
		sErrors += "Invalid Start Time\n";
	}

	if (!reDates.test(sEnd))
	{
		sErrors += "Invalid End Date\n";
	}

	if (!reTimes1.test(sEndTime) && !reTimes2.test(sEndTime) && !reTimes3.test(sEndTime))
	{
		sErrors += "Invalid End Time\n";
	}

	if (sStart !== "" && sEnd !== "")
	{
		if (sStart > sEnd || (sStart == sEnd && sStartTime > sEndTime))
		{
			sErrors += "Start Date cannot be later than End Date\n";		
		}
	}



	if (sCycle !== "0" && !reCount.test(sCount))
	{
		sErrors += "Invalid Count\n";
	}

	if (!reTagIds.test(sInterests))
	{
		sErrors += "Invalid Tags\n";
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


function validateEditEvent(fEditEvent) 
{

	var sTitle = fEditEvent.title.value;
	var sDescription = fEditEvent.description.value;
	var sAddress = fEditEvent.address.value;
	var sStart = fEditEvent.eventstart.value;
	var sStartTime = fEditEvent.eventstarttime.value;
	var sEnd = fEditEvent.eventend.value;
	var sEndTime = fEditEvent.eventendtime.value;
	var sInterests = fEditEvent.tagids.value;


	var reText = /^[\w\s]+$/;
	var reTagIds = /^[0-9,]+$/;
	var reDates = /^(?:(?:(?:0?[13578]|1[02])(\/|-|\.)31)\1|(?:(?:0?[1,3-9]|1[0-2])(\/|-|\.)(?:29|30)\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:0?2(\/|-|\.)29\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:(?:0?[1-9])|(?:1[0-2]))(\/|-|\.)(?:0?[1-9]|1\d|2[0-8])\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
	var reTimes1 = /^([0-9]|0[0-9]|1[0-2]):[0-5][0-9]:[0-5][0-9]$/
	var reTimes2 = /^([0-9]|0[0-9]|1[0-2]):[0-5][0-9]$/
	var reTimes3 = /^([0-9]|0[0-9]|1[0-2])$/
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
	
	if (!reTimes1.test(sStartTime) && !reTimes2.test(sStartTime) && !reTimes3.test(sStartTime))
	{
		sErrors += "Invalid Start Time\n";
	}

	if (!reDates.test(sEnd))
	{
		sErrors += "Invalid End Date\n";
	}

	if (!reTimes1.test(sEndTime) && !reTimes2.test(sEndTime) && !reTimes3.test(sEndTime))
	{
		sErrors += "Invalid End Time\n";
	}

	if (sStart !== "" && sEnd !== "")
	{
		if (sStart > sEnd || (sStart == sEnd && sStartTime > sEndTime))
		{
			sErrors += "Start Date cannot be later than End Date\n";		
		}
	}

	if (!reTagIds.test(sInterests))
	{
		sErrors += "Invalid Tags\n";
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


function validateContact(fContactUs) 
{
	
	var sName = fContactUs.name.value;
	var sSubject = fContactUs.subject.value;
	var sEmail = fContactUs.email.value;
	var sMessage = fContactUs.message.value;

	var reText = /^[\w\s]+$/;
	var sErrors = "";

	if (!reText.test(sName))
	{
		sErrors += "Invalid Name\n";
	}
	if (!reText.test(sSubject))
	{
		sErrors += "Invalid Subject\n";
	}
	if (!reText.test(sEmail))
	{
		sErrors += "Invalid Email\n";
	}
	if (!reText.test(sMessage))
	{
		sErrors += "Invalid Message\n";
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


function validateUser(fNewUser) 
{
	
	var sUserName = fNewUser.username.value;
	var sRealName = fNewUser.realname.value;
	var sEmail = fNewUser.email.value;
	var sPassword = fNewUser.password.value;
	var sPasscheck = fNewUser.passcheck.value;

	var reText = /^[\w\s]+$/;
	var reTextNoSpace = /^[\w]+$/;
	var reEmail = /^[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}$/;

	var sErrors = "";

	if (!reTextNoSpace.test(sUserName))
	{
		sErrors += "Invalid User Name\n";
	}
	if (!reText.test(sRealName))
	{
		sErrors += "Invalid Real Name\n";
	}
	if (!reEmail.test(sEmail))
	{
		sErrors += "Invalid Email\n";
	}
	if (!reTextNoSpace.test(sPassword))
	{
		sErrors += "Invalid Password\n";
	}
	if (!reTextNoSpace.test(sPasscheck))
	{
		sErrors += "Invalid Password check\n";
	}

	if (sPassword !== sPasscheck)
	{
		sErrors += "Password and password check do not match\n";
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

/*'not used
function validateSearch(fSearchEvent) 
{
	
	var sTitle = fSearchEvent.title.value;
	var sDescription = fSearchEvent.description.value;
	var sCity = fSearchEvent.city.value;
	var sStartTime = fSearchEvent.eventstart.value;
	var sEndTime = fSearchEvent.eventend.value;
	var sInterests = fSearchEvent.tagids.value;

	var reText = /^[\w\s]*$/;
	var reDate = new RegExp("^(([0]?[1-9]|1[0-2])/([0-2]?[0-9]|3[0-1])/[1-2]\d{3}) (20|21|22|23|[0-1]?\d{1}):([0-5]?\d{1})$");
    
	var sErrors = "";
	if (!reText.test(sTitle))
	{
		sErrors += "Invalid Title\n";
	}
	if (!reText.test(sDescription))
	{
		sErrors += "Invalid Description\n";
	}
	if (!reText.test(sCity))
	{
		sErrors += "Invalid City\n";
	}
	
	if (!reDate.test(sStartTime) && sStartTime !== "")
	{
		sErrors += "Invalid Start Time\n";
	}
	if (!reDate.test(sEndTime) && sEndTime !== "")
	{
		sErrors += "Invalid End Time\n";
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
*/

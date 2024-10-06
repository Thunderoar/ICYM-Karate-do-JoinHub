
<ul id="main-menu" class="" >
			
    <li id="dash"><a href="index.php"><i class="entypo-gauge"></i><span>Dashboard</span></a></li>
	
	<li id="paymnt"><a href="payments.php"><i class="entypo-star"></i><span>Payments</span></a></li>


	<li id="health_status"><a href="new_health_status.php"><i class="entypo-user-add"></i><span>Health Status</span></a> 	

		<li class="" id="planhassubopen"><a href="#" onclick="memberExpand(2)"><i class="entypo-quote"></i><span>Planning</span></a>

		<ul id="planExpand">
			<li class="active">
				<a href="new_plan.php"><span>New Plan</span></a></li>

			<li><a href="view_plan.php"><span>Edit Plan</span></a></li>
		</ul>
		<ul id="overviewExpand">
			<li class="active">
				<a href="over_members_month.php"><span>Members per Month</span></a>
			</li>

			<li>
				<a href="over_members_year.php"><span>Members per Year</span></a>
			</li>

			<li>
				<a href="revenue_month.php"><span>Income per Month</span></a>
			</li>			

		</ul>

	<li class="" id="routinehassubopen"><a href="#" onclick="memberExpand(4)"><i class="entypo-alert"></i><span>Sports Routine</span></a>

		<ul id="routineExpand">
			<li class="active">
				<a href="addroutine.php"><span>Add Sports Routine</span></a>
			</li>

			<li>
				<a href="editroutine.php"><span>Edit Sports Routine</span></a>
			</li>

			<li>
				<a href="viewroutine.php"><span>View Sports Routine</span></a>
			</li>

		</ul>

	</li>

	<li id="adminprofile"><a href="more-userprofile.php"><i class="entypo-folder"></i><span>Profile</span></a></li>

	<li><a href="logout.php"><i class="entypo-logout"></i><span>Logout</span></a></li>

</ul>	

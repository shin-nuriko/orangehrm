<div id="complete-details">
	<div class="detail-block">
		<div id="profile-pic">
		  <div class="imageHolder">
		    <img alt="Employee Photo" src="<?php echo url_for("pim/viewPhoto?empNumber=". $empNumber); ?>" border="0" id="empPic" 
		     width="200" height="200"/>
		  </div> 
		</div> 
		<div id="job-details">
			<h1><?php echo $fullName; ?></h1>
			<ol>
				<?php foreach ($job_details as $key => $value) { ?>
					<li><div class="label"><?php echo $key; ?></div>
					    <div class="detail"><?php echo $value; ?></div></li>
				<?php }?>
			</ol>
		</div>
	</div>
	<div id="personal-details">
		<ol>
			<?php foreach ($personal_details as $key => $value) { ?>
				<li><div class="label"><?php echo $key; ?></div>
					<div class="detail"><?php echo $value; ?></div></li>
			<?php }?>
		</ol>
	</div>
	<div id="contact-details">
		<h1>Contact Information</h1>
		<ol>
			<?php foreach ($contact_details as $key => $value) { ?>
				<li><div class="label"><?php echo $key; ?></div>
				<div class="detail"><?php echo $value; ?></div></li>
			<?php }?>
		</ol>
	</div>
	<div id="education-details">
		<h1>Educational Background</h1>
		<ol>
			<?php foreach ($education_details as $education) { ?>
				<li>
					<div class="label"><?php echo $education['Level']; ?></div>
					<div class="detail">
						<div class="item"><?php echo $education['Institute'];?></div>
						<div class="item"><?php echo $education['Degree'];?></div>
						<div class="item"><?php echo $education['Start Year'];?> - <?php echo $education['End Year']?></div>
					</div>
				</li>
			<?php }?>
		</ol>
	</div>
	<div id="emergency-contact-details">
		<h1>Emergency Contact Information</h1>
		<table>
			<tr>
				<td>Name</td>
				<td>Relationship</td>
				<td>Home Telephone</td>
				<td>Mobile</td>
				<td>Work Telephone</td>
			</tr>
			<?php foreach ($emergency_details as $contact) { ?>
			<tr>
				<td><?php echo $contact['Name']?></td>
				<td><?php echo $contact['Relationship']?></td>
				<td><?php echo $contact['Home Telephone']?></td>
				<td><?php echo $contact['Mobile']?></td>
				<td><?php echo $contact['Work Telephone']?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
 
 <style>
ol {
	list-style-type: none;
	padding: 0;
}
li {
	padding: 5px;
	display: -webkit-box;
}

#complete-details,
#personal_details {
	display: block;
}

#profile-pic {
	position:relative;
	float:left; 
}

.detail-block {
    display: block;
    margin: 10px;
    font-size: 13px;
}

div#profile-pic {
	max-width: 200px;
}

div#job-details {
    position: relative;
    left: 10px;
}
div#education-details {
    position: relative;
    top: 30px;
    float: none;
}

div#job-details li {
    display: -webkit-box;
    padding: 5px;
}

div#contact-details {
    margin: 55px 10px;
}
div#personal-details {
	float: left;
    margin: 7px;
    border: 1px black solid;
    padding-right: 20px;
}
div#emergency-contact-details {
    margin-top: 50px;
}

div.label {
    font-weight: bold;
    font-size: 12px;
    font-family: serif;
    color: #727272;
    min-width: 100px;
}

div.detail {
	font-size: 14px;
	font-family: sans-serif;
}

h1 {
    font-size: 15px;
    font-weight: bold;
    vertical-align: middle;
    font-family: sans-serif;
    margin: 5px;
}

table, tr, td {
    font-size: 13px;
    border-style: solid;
    border-width: 1px;
    margin: 0px;
    border-spacing: 0px;
    border-color: #aaa;
    padding: 5px;
}
table {
	width:100%;
}
</style>

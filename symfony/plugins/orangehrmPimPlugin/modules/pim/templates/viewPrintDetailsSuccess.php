<?php 
use_stylesheet(plugin_web_path('orangehrmPimPlugin', 'css/viewPrintDetailsSuccess.css'));
?>
<div id="complete-details" style="width:1000px;display:block;position:relative;">
	<div id="profile-pic">
	  <div class="imageHolder">
	    <img alt="Employee Photo" src="<?php echo url_for("pim/viewPhoto?empNumber=". $empNumber); ?>" border="0" id="empPic" 
	     width="200" height="200"/>
	  </div> 
	</div> 
	<div id="job-details">
	</br><?php echo $fullName; ?></br>
		<ol>
			<?php foreach ($job_details as $key => $value) { ?>
				<li style="display:flex;position:relative;"><div class="label" style="width:150px;"><?php echo $key; ?></div>
				&nbsp;	<div class="detail"  style="font-weight:bold"><?php echo $value; ?></div></li>
			<?php }?>
		</ol>
	</div>
</br>
	<div id="personal-details">
		<ol>
			<?php foreach ($personal_details as $key => $value) { ?>
				<li style="display:flex;position:relative;"><div class="label" style="width:150px;"><?php echo $key; ?></div>
				&nbsp;	<div class="detail"  style="font-weight:bold"><?php echo $value; ?></div></li>
			<?php }?>
		</ol>
	</div>
</br>
	<div id="contact-details">
		<ol>
			<?php foreach ($contact_details as $key => $value) { ?>
				<li style="display:flex;position:relative;"><div class="label" style="width:150px;"><?php echo $key; ?></div>
				&nbsp;	<div class="detail"  style="font-weight:bold"><?php echo $value; ?></div></li>
			<?php }?>
		</ol>
	</div>
</br>
	<div id="education-details">
		<ol>
			<?php foreach ($education_details as $education) { ?>
				<li style="display:flex;position:relative;">
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
</br>
	<div id="emergency-contact-details">
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
 

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
</div>
 

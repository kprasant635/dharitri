<h5 style="color: red;text-align: center;text-decoration: underline;">Remaining Time for Write Report : <?php
 if(isset($remainingTime)) {
 	echo $remainingTime;
 }else
 {
 	echo "NA";
 }
 if(ESCALATION_ALLOW_TIME)
 {
 	echo " Minutes";
 }
 else
 {
 	echo " Days";
 }
?></h5>
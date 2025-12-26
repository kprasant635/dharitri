<label class="control-label" >
  ৯) 
  <?php
  if($lm_details['premium_new_yn'] == 1) {
    echo $conversion_premium_area->ass_name . ' মাটি হয়নে ? - হয়';
  }
  else {
    if (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'o')) {
      echo "উক্ত মাটি গাওঁৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'i')) {
      echo "অবেদিত মাটি নগৰ/চহৰৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'r')) {
      echo "অবেদিত মাটি ৰাজহ নগৰ মাটি হয়নে - হয়";
    } elseif ($lm_details['dist_frm_town'] == '3') {
        echo "অবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'd')) {
        echo "অবেদিত মাটি জিলা সদৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া, পলাশবাৰী নগৰ আৰু পৌৰ নগৰ/নিগম মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'i')) {
      echo "অবেদিত মাটি জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'm')) {
      echo "অবেদিত মাটি পৌৰ নগৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm')) {
      echo "অবেদিত মাটি পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'g')) {
      echo "অবেদিত মাটি গুৱাহাটী মহানগৰী মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '15') && ($lm_details['inside_outside_town'] == 'g')) {
      echo "অবেদিত মাটি গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '15') && ($lm_details['inside_outside_town'] != 'g')) {
        echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা সদৰ, উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে - হয়";
    } elseif (($lm_details['dist_frm_town'] == '10') && ($lm_details['inside_outside_town'] == 'i')) {
      echo "অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
    }
  }
  
  
  ?>
</label>
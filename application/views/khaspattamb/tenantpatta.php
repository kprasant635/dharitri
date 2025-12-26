<center id='show-Img'>
    <img id="loading-image" style="" width="100px" src= "<?php echo base_url(); ?>application/views/images/load.gif" alt="Loading..." />
    <h2 style="color:#000   " >Please Wait ! </h2>
    <h5 style="color: #000   ">Don't Refresh the page.... Redirecting ....</h5>
    <div class="progress">
      <div class="progress-bar progress-bar-striped bg-info col-lg-6" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</center>
<form id='autosubmit' name='autosubmit' action="<?php echo base_url()?>index.php/SettlementMbCo/autosubmit" method="post" enctype='multipart/form-data'>
<span id='uni_text' style="display:none"> <!-- style="display:none" -->
<p style="text-align: center;">উপায়ুক্তৰ চূড়ান্ত হুকুম </p>

<p style="text-align: center;">জাননী নং- <?=$case_no?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; তাৰিখ-<?=date('d/m/Y')?></p>

<p>&nbsp;</p>

<p>অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী নিয়ম, ১৯৭২ৰ ১৮ নং নিয়ম অনুসৰি জাৰি কৰাএই জাননীৰ জৰিয়তে প্ৰত্যায়িত কৰা হ'ল যে, অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী আইন  ৰ অধীনত ৰায়ত শ্ৰী য়ে <?=$applicant['applicant_name']?> পট্টাদাৰ শ্ৰী <?=$owner['applicant_name']?> ৰ <?=$mouName?> মৌজাৰ, <?=$lotName ?> নম্বৰ লাটৰ, <?=$villName?> গাঁৱৰ, <?=$dag['patta_no']?> নং পট্টাৰ, <?=$dag['dag_no']?> দাগৰ, মুঠ <?=$dag['s_dag_area_b']?> বিঘা <?=$dag['s_dag_area_k']?> কঠা <?=$dag['s_dag_area_lc']?> লেচা জমিত মালিকীস্বত্ব লাভ কৰিছে। সেই অনুসৰি নথি সংশোধনীৰ বাবে হুকুম দিয়া হ&#39;ল।</p>

<p style="text-align: right;">উপায়ুক্ত</p>
<?php
$data = explode(",", $qrcode);
$data = $data[1];
echo '<img class="img-fluid col-sm-1" src="data:image/png;base64,' . $data . '" />';
?>
</span>

<div id='khaspatta' style="display:none">
<h4 style="text-align: center;">PERIODIC KHHIRAJ PATTA</h4>
<h4 style="text-align: center;"> মিয়াদি খেৰাজী পট্টা নং (PERIODIC PATTA NO.) </h4>

<p style="text-align: center;">&nbsp;</p>

<p style="text-align: center;">জিলা :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; মৌজা&nbsp; :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;গাওঁ :&nbsp;</p>

<p><span style="color: rgb(32, 33, 36); font-family: consolas, &quot;lucida console&quot;, &quot;courier new&quot;, monospace; font-size: 12px; white-space: pre-wrap; background-color: rgb(255, 255, 255);">১. </span>মই ওপৰত লিখা জিলাৰ ডেপুটি কমিচনাৰে ইয়াৰ দ্বাৰা প্ৰচাৰ কৰো যে অসমৰ ভূমি আৰু ৰাজহ বিধিৰ ব্যস্থা আৰু সময়ে সময়ে কৰা তাৰ নিয়মৰ বশৱৰ্ত্তী হৈ প্ৰাদেশিক গভৰ্ণমেন্টৰ হকে এই পট্টাৰ সিপিঠিৰ তপচিলত লিখা মাটিখিনি ২০০&nbsp;&nbsp;চনৰ ১ এপ্ৰিলৰ পৰা ২০০&nbsp;&nbsp;চনৰ ৩১ মাৰ্চ তাৰিখলৈকে&nbsp;&nbsp;&nbsp;&nbsp; বছৰৰ কাৰণে তলত লিখা ৰাজহ আৰু স্থানীয় কৰত আপুনি শ্ৰী ..................&nbsp;আপোনাৰ উত্তৰাধিকাৰী প্ৰতিনিধি আৰু স্থলভিষিক্ত বিলাকে তলত লিখা কিস্তিমতে নিয়মিত সময়ত সম্পূৰ্ণৰূপে আদায় কৰিব।&nbsp;</p>

<p>&nbsp;</p>

<table border="1" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td rowspan="2" style="width:127px;">&nbsp;</td>
            <td rowspan="2" style="width:127px;">যি তাৰিখে দিব লাগে</td>
            <td colspan="2" style="width:254px;text-align: center;">দিবলগীয়া টকা</td>
            <td rowspan="3" style="width:127px;text-align: center;">মুঠ</td>
        </tr>
        <tr>
            <td style="width: 254px;  text-align: center;">ৰাজহ</td>
            <td style="width: 254px;  text-align: center;">স্থানীয় কৰ</td>
        </tr>
        <tr>
            <td rowspan="3" style="width:127px;">
            <ol>
                <li>প্ৰথম কিস্তিৰ ধন</li>
                <li>দ্বিতীয় কিস্তিৰ ধন</li>
            </ol>
            </td>
            <td rowspan="2" style="width:127px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:127px;">&nbsp;</td>
            <td style="width:127px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:127px;">&nbsp;</td>
            <td style="width:127px;">&nbsp;</td>
            <td style="width:127px;">&nbsp;</td>
            <td style="width:127px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:127px;">&nbsp;</td>
            <td style="width: 127px; text-align: center;">মুঠ</td>
            <td style="width:127px;">&nbsp;</td>
            <td style="width:127px;">&nbsp;</td>
        </tr>
    </tbody>
</table>

<p>২. প্ৰাদেশিক গৱৰ্ণমেন্টে সম্প্ৰতি ধাৰ্য্য কৰা নিৰিখ মতে এই পট্টাত স্থানীয় কৰ লগোৱা হৈছে। সময়ে সময়ে এই নিৰিখ প্ৰাদেশিক গৱৰ্ণমেন্টে আইন অনুসাৰে পৰিৱৰ্ত্তন কৰিব পাৰে।</p>

<p>৩. এই পট্টাৰ মাটি কেৱল খেতি সম্পৰ্কীয় কামৰ বাবেহে ব্যৱহাৰ কৰিব এনে ভাবি ইয়াত লিখা ৰাজহ আৰু স্থানীয় কৰ ধাৰ্য কৰা হৈছে। যদি এই মাটি বা তাৰ কোনো অংশ খেতি সম্পৰ্কীয় কামত বাজে অইন কোনো কামত ব্যৱহাৰ কৰিছে বুলি প্ৰাদেশিক গৱৰ্ণমেন্টে বিবেচনা কৰে তেনেহ&rsquo;লে তৎক্ষণাত সেই মাটিৰ ৰাজহ আৰু স্থানীয় কৰ নকৈ ধাৰ্য্য কৰিব পাৰিব আৰু আপুনি আপোনাৰ উত্তৰাধিকাৰী, প্ৰতিনিধি আৰু স্থলভিষিক্ত বিলাকে সেই মাটিৰ নিমিত্তে এতিয়াই নিৰ্দিষ্ট কৰি দিয়া পিছত নকৈ লগোৱা নিৰিখ মতে ৰাজহ আৰু স্থানীয় কৰ দিবৰ নিমিত্তে দায়ী থাকিব।</p>

<p>৪. উক্ত মাটিৰ সীমাইদি বা ওপৰেদি বৈ যোৱা নৈ আৰু জান বিলাকত য&rsquo;ত বছৰৰ কোনো সময়ত নাও চলাব পাৰি বা কাঠ উটাই নিব পাৰি সেই বিলাকত চলাচল কৰিবৰ নিমিত্তে সৰ্বসাধাৰণৰ স্বত্ব থাকিব আৰু সেই বিলাক নৈ বা জানৰ দুয়ো কাষে</p>

<p>২০ ফুট বহল এডোখৰ মাটি সৰ্বসাধাৰণৰ নাও টানিবৰ বা বান্ধিবৰ নিমিত্তে বস্তু-বেহানি তোলাপাৰা কৰিবৰ নিমিত্তে আৰু পানীত চলাচল কৰোতে কাঠ উটাই আনোতে আৰু মাছ মাৰোতে যিবিলাক কৰিবৰ আৱশ্যক হয়, সেইবিলাকৰ নিমিত্তে ব্যৱহাৰ কৰিব পাৰিব।</p>

<p>৫. আলি মেৰামত কৰিবৰ নিমিত্তে প্ৰাদেশিক গৱৰ্ণমেন্টে বা গৱৰ্ণমেন্টেৰ কাৰ্যকাৰক সকলো কোনো লোকচান নিদিয়াকৈ প্ৰাদেশিক আৰু স্থানীয় আলিৰ কাষৰ পৰা ৩৫ ফুটৰ ভিতৰতে মাটি কটাই আনিবৰ স্বত্ব বাহাল থাকিব। আৰু সেই মাটি বা তাৰ কোনো অংশত তাত থকা শস্য লাগনী গছ বা ঘৰৰ মূল্যত বাজে আন কোনো লোকচানি নিদিয়াকৈ লব পৰিব।</p>

<p>৬. যদি আপুনি আচল খেতিয়ক হয়, তেন্তে মিয়াদি পট্টাৰ আটাইখিনি মাটি বা তাৰ ভিতৰত কোনো দাগ বা দাগৰ অংশ ডেপুটি কমিচনাৰ চাহাবৰ মঞ্জুৰী হুকুম আগেয়ে লৈহে আচল খেতিয়ক নহয় এনে কোনো মানুহক হস্তান্তৰ কৰিব পাৰিব।</p>

<p>৭. যদি আপুনি এই পট্টাত ভুক্ত মাটিৰ কোনো এটা দাগ বা আটাইখিনি মাটি ইস্তফা দিব খোজে, তেনেহ&rsquo;লে ইস্তফা দিবৰ নিমিত্তে যি তাৰিখ নিৰ্দ্ধাৰিত কৰা হয় সেই তাৰিখ বা তাৰ আগেয়ে আপুনি ইস্তফা দিব খোজা কথা লিখি জাননী দিব।</p>

<p>৮. আপোনাৰ পট্টাৰ সমূদায় বা তাৰ কোনো দাগ মাটি ইস্তফা দিলে তাত লগোৱা ৰাজহ আৰু সোধাব নালাগে আৰু পট্টাৰ মুঠ ৰাজহৰ বা ইস্তফা দিয়া দাগত লগোৱা ৰাজহ বাদ যাব।</p>

<p>৯. ওপৰত উল্লেখ কৰা নিয়ম বিলাকৰ কোনো নিয়ম ভংগ কৰিলে এই পট্টা ৰদ হ&rsquo;ব পাৰিব।</p>

<p>১০. নতুনকৈ নিৰ্দ্ধাৰিত কৰা ৰাজহ পুনৰ ২০০&nbsp;&nbsp;চনৰ ৩১ মাৰ্চ তাৰিখে পৰিৱৰ্ত্তন হ&rsquo;ব পাৰিব।&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>

<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; তপচিল</p>

<table border="1" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width:136px;">দাগৰ ক্ৰমিক নম্বৰ</td>
            <td style="width:136px;">প্ৰত্যেক দাগৰ শ্ৰেণী</td>
            <td style="width:160px;">বিঘামতে প্ৰত্যেক দাগৰ মাটিৰ পৰিমাণ</td>
            <td style="width:113px;">প্ৰত্যেক দাগৰ লগোৱা ৰাজহ</td>
            <td style="width:136px;">মন্তব্য</td>
        </tr>
        <tr>
            <td style="width:136px;">&nbsp;</td>
            <td style="width:136px;">&nbsp;</td>
            <td style="width:160px;">&nbsp;</td>
            <td style="width:113px;">&nbsp;</td>
            <td style="width:136px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="width:433px;">মুঠ</td>
            <td style="width:113px;">&nbsp;</td>
            <td style="width:136px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="width:433px;">স্থানীয় কৰ যোগদিয়া</td>
            <td style="width:113px;">&nbsp;</td>
            <td style="width:136px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="width:433px;">সৰ্বমুঠ</td>
            <td style="width:113px;">&nbsp;</td>
            <td style="width:136px;">&nbsp;</td>
        </tr>
    </tbody>
</table>
<p style="text-align: right;">উপায়ুক্ত</p>
</div>

<textarea style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>
<textarea style="display:none" id="htmlstring_text1" name="htmlstring_text_patta" cols="30" rows="10"></textarea>
<input type="hidden" name="case_no" value="<?=$case_no?>">
</form>
<script type='text/javascript'>
var auto_refresh = setInterval(function() { submitform(); }, 2000);
function submitform()
{
  var htmlString =$( "#uni_text" ).html();
  var htmlString1 =$( "#khaspatta" ).html();
  var htmlString = b64EncodeUnicode(htmlString);
  var htmlString1 = b64EncodeUnicode(htmlString1);
  $("#htmlstring_text").text(htmlString);
  $("#htmlstring_text1").text(htmlString1);
  document.getElementById("autosubmit").submit();
  $('#show-Img').show();
}
function b64EncodeUnicode(str) {    
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
        }));
}
</script>
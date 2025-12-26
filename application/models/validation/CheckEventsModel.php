<?php
    class CheckEventsModel extends CI_Model {
        
        public function __construct()
        {
            $this->load->model('PetitionBasic_Model');
        }

        public function checkConversionEvent($case_no) {
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
            $events = $this->allConversionEvents();
            //imp
            $status = $caseInfo->status;
            $operation = $caseInfo->operation;
            $lm_note_yn = $caseInfo->lm_note_yn;
            $sk_comment = $caseInfo->sk_comment;
            $astt_comment = $caseInfo->astt_comment;
            $bo_note_yn = $caseInfo->bo_note_yn;
            $dept_note_yn = $caseInfo->dept_note_yn;
            $not_fresh = $caseInfo->not_fresh;
            $notice_generated_yn = $caseInfo->notice_generated_yn;
            $proceeding_yn = $caseInfo->proceeding_yn;
            $co_order_conv_premium = $caseInfo->co_order_conv_premium;
            $co_order_conv_notice = $caseInfo->co_order_conv_notice;
            //not so imp
            $service_status = $caseInfo->service_status;
            $co_chitha_corrected_yn = $caseInfo->co_chitha_corrected_yn;
            $pay_notice_gen_yn = $caseInfo->pay_notice_gen_yn;
            $trans_code = $caseInfo->trans_code;
            $mut_type = $caseInfo->mut_type;
            $add_off_desig = $caseInfo->add_off_desig;

            $result = 'event does not exist';
            
            foreach ($events as $event) {
                
                if(
                    $event['status'] == $status && 
                    $event['operation'] == $operation && 
                    $event['lm_note_yn'] == $lm_note_yn && 
                    $event['sk_comment'] == $sk_comment && 
                    $event['astt_comment'] == $astt_comment && 
                    (in_array($bo_note_yn, $event['bo_note_yn'])) && 
                    (in_array($dept_note_yn, $event['dept_note_yn'])) && 
                    $event['not_fresh'] == $not_fresh && 
                    ($event['notice_generated_yn'] == $notice_generated_yn || in_array($notice_generated_yn, $event['notice_generated_yn'])) && 
                    ($event['proceeding_yn'] == $proceeding_yn || in_array($proceeding_yn, $event['proceeding_yn'])) && 
                    ($event['co_order_conv_premium'] == $co_order_conv_premium || in_array($co_order_conv_premium, $event['co_order_conv_premium'])) && 
                    ($event['co_order_conv_notice'] == $co_order_conv_notice || in_array($co_order_conv_notice, $event['co_order_conv_notice'])) && 
                    $event['service_status'] == $service_status && 
                    $event['co_chitha_corrected_yn'] == $co_chitha_corrected_yn && 
                    ($event['pay_notice_gen_yn'] == $pay_notice_gen_yn || in_array($pay_notice_gen_yn, $event['pay_notice_gen_yn'])) && 
                    ($event['trans_code'] == $trans_code || in_array($trans_code, $event['trans_code'])) && 
                    $event['mut_type'] == $mut_type &&
                    ($event['add_off_desig'] == $add_off_desig || in_array($add_off_desig, $event['add_off_desig']))
                ) {

                    
                        $result = $event['event_name'];
                        break;
                    
                    
                }
            }
            return $result;
        }


        public function allConversionEvents() {
            return [
                ['event_name'=>CONV_LM_FIRST, 'status'=>'P', 'lm_note_yn'=>null, 'sk_comment'=>null, 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_LM_RVRT_CO_SECOND, 'status'=>'P', 'lm_note_yn'=>null, 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>[null, 'Y'], 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=> CONV_AST_FIRST, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_AST_SECOND, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>['P', null], 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>'Y', 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_AST_PREMIUM_NOTICE, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>'Y', 'co_order_conv_notice'=>'Y', 'pay_notice_gen_yn'=>[null, 'Y'], 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_AST_CONFIRM_PREMIUM, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>'Y', 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>'Y', 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'], 
                ['event_name'=>CONV_CO_FIRST, 'status'=>null, 'lm_note_yn'=>null, 'sk_comment'=>null, 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>null, 'notice_generated_yn'=>null, 'proceeding_yn'=>null, 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_CO_SECOND, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null, 'Y'], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>[null, 'Y'], 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_CO_CHITHAUPD, 'status'=>'W', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null, 'Y'], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>'P', 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_CO_CHITHAUPD_COEND, 'status'=>'W', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>'P', 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>'Y', 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_CO_REVERT, 'status'=>'R', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y', null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>['1', null], 'co_order_conv_premium'=>[null, 'P'], 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_SK_FIRST, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>null, 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>[null, 'Y'], 'trans_code'=>['F', 'P'], 'add_off_desig'=>'CO', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_ADC_FIRST, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'ADC', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_ADC_SECOND, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'ADC', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_ADC_FINALORD, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>'P', 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'ADC', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_DC_FIRST, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'DC', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_DC_SECOND, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null, 'Y'], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'DC', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_DC_FINALORD, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null, 'Y'], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>'P', 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'DC', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_DC_DEPT_REPORT, 'status'=>'W', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>'1', 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>'DPT', 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_BO_FIRST, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>[null], 'dept_note_yn'=>[null], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>null, 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>['DC', 'ADC'], 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_BO_SECOND, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null, 'Y'], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>'Y', 'co_order_conv_notice'=>'Y', 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>['ADC', 'DC'], 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01'],
                ['event_name'=>CONV_BO_CONFPREM, 'status'=>'P', 'lm_note_yn'=>'Y', 'sk_comment'=>'Y', 'bo_note_yn'=>['Y'], 'dept_note_yn'=>[null, 'Y'], 'not_fresh'=>'Y', 'notice_generated_yn'=>'Y', 'proceeding_yn'=>null, 'co_order_conv_premium'=>'Y', 'co_order_conv_notice'=>null, 'pay_notice_gen_yn'=>null, 'trans_code'=>['F', 'P'], 'add_off_desig'=>['ADC', 'DC'], 'operation'=>'E', 'astt_comment'=>null, 'service_status'=>null, 'co_chitha_corrected_yn'=>null, 'mut_type'=>'01']
            ];
        }
    }

?>
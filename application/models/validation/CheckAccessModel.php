<?php
    class CheckAccessModel extends CI_Model {
        
        public function __construct()
        {
            
        }

//--------------------------Main Function---------------------------------------
        public function checkLMAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_NAME_CORRECT)
            {
                return $this->nameCorrectionLMCheck($case_no, $event);
            }
            else if($service_code==SERVICE_NAME_CANCEL)
            {
                return $this->nameCancellationLMCheck($case_no, $event);
            }
            else if($service_code==100)
            {
                return $this->ccsLMCheck($case_no, $event);
            }
            else if($service_code==101)
            {
                return $this->rtpsLMCheck($case_no, $event);
            }
            else if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionLMCheck($case_no, $event);
            }
            else {
                return false;
            }
        }

        public function checkCOAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_NAME_CORRECT)
            {
                return $this->nameCorrectionCOCheck($case_no, $event);
            }
            else if($service_code==SERVICE_NAME_CANCEL)
            {
                return $this->nameCancellationCOCheck($case_no, $event);
            }
            else if($service_code==100)
            {
                return $this->ccsCOCheck($case_no, $event);
            }
            else if($service_code == 102) {
                return $this->rtpsCOCheck($case_no, $event);
            }
            else if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionCOCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

        public function checkSKAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_NAME_CORRECT)
            {
                return $this->nameCorrectionSKCheck($case_no, $event);
            }
            else if($service_code==SERVICE_NAME_CANCEL)
            {
                return $this->nameCancellationSKCheck($case_no, $event);
            }
            else if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionSKCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

        public function checkASTAccess($service_code, $case_no, $event) {
            if($service_code==101)
            {
                return $this->rtpsASTCheck($case_no, $event);
            }
            else if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionASTCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

        public function checkDEOAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionDEOCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

        public function checkDAAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionDACheck($case_no, $event);
            }

            else{
                return false;
            }
        }

        public function checkADCAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionADCCheck($case_no, $event);
            }
            else if($service_code==SERVICE_NAME_CORRECT)
            {
                return $this->nameCorrectionADCCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

        public function checkDCAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionDCCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

        public function checkBOAccess($service_code, $case_no, $event) {
            if($service_code==SERVICE_CONVERSION)
            {
                return $this->conversionBOCheck($case_no, $event);
            }
            else{
                return false;
            }
        }

//--------------------------End of Main Function-------------------------

//--------------------------Custom Functions-----------------------------

        private function conversionLMCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                //LM_FIRST
                if(
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == null && $sk_comment == null && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') ||
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == null && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO')) {
                    $authorize = true;
                }
            }
            else{
                if($event == CONV_LM_FIRST) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == null && $sk_comment == null && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ($proceeding_yn == null || $proceeding_yn == '1') && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_LM_RVRT_CO_SECOND) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == null && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                // else if($event == CONV_LM_RVRT_DCEND) {
                //     if($status == 'P' && $operation == 'E' && $lm_note_yn == null && $sk_comment == null && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                //         $authorize = true;
                //     }
                // }
            }
            return $authorize;
        }

        private function conversionASTCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                //AST_FIRST
                if(
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') || 
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == 'Y' && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') || 
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == 'Y' && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') ||
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && ($co_order_conv_premium == 'P' || $co_order_conv_premium == null) && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == 'Y' && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO')) {
                        $authorize = true;
                }
            }
            else{
                if($event == CONV_AST_FIRST) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_AST_PREMIUM_NOTICE) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == 'Y' && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_AST_CONFIRM_PREMIUM) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == 'Y' && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_AST_SECOND) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && ($co_order_conv_premium == 'P' || $co_order_conv_premium == null) && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == 'Y' && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                // else if($event == CONV_AST_REVERT_DCEND) {
                //     if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                //         $authorize = true;
                //     }
                // }
            }
            return $authorize;
        }

        private function conversionCOCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                //CO_FIRST, CO_SECOND, CO_REVERT, CO_UPDATE_CHITHA
                if(
                    ($status == null && $operation == 'E' && $lm_note_yn == null && $sk_comment == null && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == null && $notice_generated_yn == null && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') || 
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && ($bo_note_yn == null || $bo_note_yn == 'Y') && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') || 
                    ($status == 'W' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') ||
                    ($status == 'W' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == 'Y' && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') ||
                    ($status == 'R' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && ($bo_note_yn == 'Y' || $bo_note_yn == null) && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ($proceeding_yn == '1' || $proceeding_yn == null) && ($co_order_conv_premium == null || $co_order_conv_premium == 'P') && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO')) {
                        $authorize = true;
                }
            }
            else{
                if($event == CONV_CO_FIRST) {
                    if($status == null && $operation == 'E' && $lm_note_yn == null && $sk_comment == null && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == null && $notice_generated_yn == null && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_CO_SECOND) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && ($bo_note_yn == null || $bo_note_yn == 'Y') && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_CO_CHITHAUPD) {
                    if($status == 'W' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_CO_CHITHAUPD_COEND) {
                    if($status == 'W' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == 'Y' && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_CO_REVERT) {
                    if($status == 'R' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && ($bo_note_yn == 'Y' || $bo_note_yn == null) && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ($proceeding_yn == '1' || $proceeding_yn == null) && ($co_order_conv_premium == null || $co_order_conv_premium == 'P') && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function conversionSKCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                //SK_FIRST
                if(
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == null && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO')) {
                    $authorize = true;
                }
            }
            else{
                if($event == CONV_SK_FIRST) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == null && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ($proceeding_yn == null || $proceeding_yn == '1') && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && ($pay_notice_gen_yn == null || $pay_notice_gen_yn == 'Y') && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO') {
                        $authorize = true;
                    }
                }
                // else if($event == CONV_SK_REVERT_DCEND) {
                //     if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == null && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'CO'){
                //         $authorize = true;
                //     }
                // }
            }
            return $authorize;
        }

        private function conversionDEOCheck($case_no, $event) {

        }

        private function conversionDACheck($case_no, $event) {

        }

        private function conversionADCCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                //ADC_FIRST, ADC_SECOND, ADC_FINAL_ORDER
                if(
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ($proceeding_yn == '1' || $proceeding_yn == null) && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'ADC') || 
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'ADC') ||
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'ADC')) {
                    $authorize = true;
                }
            }
            else{
                if($event == CONV_ADC_FIRST) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ($proceeding_yn == '1' || $proceeding_yn == null) && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'ADC') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_ADC_SECOND) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'ADC') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_ADC_FINALORD) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'ADC') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function conversionDCCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                if(($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') ||
                ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') ||
                ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') ||
                ($status == 'W' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DPT') ||
                ($status == 'R' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC')) {
                    $authorize = true;
                }
            }
            else {
                if($event == CONV_DC_FIRST) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_DC_SECOND) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_DC_FINALORD) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == 'P' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_DC_DEPT_REPORT) {
                    if($status == 'W' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DPT') {
                        $authorize = true;
                    }
                }
                else if($event == CONV_DC_DEPT_REVERT) {
                    if($status == 'R' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == '1' && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && $add_off_desig == 'DC') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function conversionBOCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
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
            // echo '<pre>';
            // var_dump($caseInfo);
            // die();
            if($event == null) {
                //BO_FIRST, BO_SECOND, BO_CONFIRM_PREMIUM
                if(
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ( $proceeding_yn == null || $proceeding_yn == '1') && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && ($add_off_desig == 'ADC' || $add_off_desig == 'DC')) ||
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == 'Y' && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && ($add_off_desig == 'ADC' || $add_off_desig == 'DC')) ||
                    ($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && ($add_off_desig == 'ADC' || $add_off_desig == 'DC'))
                    ) {
                    $authorize = true;
                }
            }
            else {
                if($event == CONV_BO_FIRST) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == null && $dept_note_yn == null && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && ( $proceeding_yn == null || $proceeding_yn == '1') && $co_order_conv_premium == null && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && ($add_off_desig == 'ADC' || $add_off_desig == 'DC')) {
                        $authorize = true;
                    }
                }
                else if($event == CONV_BO_SECOND) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == 'Y' && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && ($add_off_desig == 'ADC' || $add_off_desig == 'DC')) {
                        $authorize = true;
                    }
                }
                else if($event == CONV_BO_CONFPREM) {
                    if($status == 'P' && $operation == 'E' && $lm_note_yn == 'Y' && $sk_comment == 'Y' && $astt_comment == null && $bo_note_yn == 'Y' && ($dept_note_yn == null || $dept_note_yn == 'Y') && $not_fresh == 'Y' && $notice_generated_yn == 'Y' && $proceeding_yn == null && $co_order_conv_premium == 'Y' && $co_order_conv_notice == null && $service_status == null && $co_chitha_corrected_yn == null && $pay_notice_gen_yn == null && ($trans_code == 'F' || $trans_code == 'P') && $mut_type == '01' && ($add_off_desig == 'ADC' || $add_off_desig == 'DC')) {
                        $authorize = true;
                    }
                }

            }
            return $authorize;
        }

        private function nameCorrectionLMCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '18' or 'L'
            $operation = $caseInfo->operation;//operation = 's' or 'a'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn =  NULL
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = NULL

            if($event == null) {
                if(($status == '18' && $lm_note_yn == null && $sk_note_yn == null) || ($status == 'L' && $lm_note_yn == null && $sk_note_yn == null) || ($status == '18' && $lm_note_yn == null && $sk_note_yn == null)) {
                    $authorize = true;
                }
            }
            else {
                if($event == NAME_CORR_LM_FIRST) {
                    if($status == '18' && $operation == 's' && $lm_note_yn == null && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
                else if($event == NAME_CORR_LM_REVERT) {
                    if($status == 'L' && $operation == 's' && $lm_note_yn == null && $sk_note_yn == null){
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function nameCancellationLMCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '18' or 'L'
            $operation = $caseInfo->operation;//operation = 'E' or 's'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn =  NULL
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = NULL

            if($event == null) {
                if(($status == '18' && $operation == 'E' && $lm_note_yn == null && $sk_note_yn == null) || ($status == 'L' && $operation == 's' && $lm_note_yn == null && $sk_note_yn == null)) {
                    $authorize = true;
                }
            }
            else {
                if($event == NAME_CANC_LM_FIRST) {
                    if($status == '18' && $operation == 'E' && $lm_note_yn == null && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
                else if($event == NAME_CANC_LM_REVERT) {
                    if($status == 'L' && $operation == 's' && $lm_note_yn == null && $sk_note_yn == null){
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function ccsLMCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->CitizenCentric_Model->certInfo($case_no);
            $receipt_gen_yn = $caseInfo->receipt_gen_yn;
            $lm_checked_yn = $caseInfo->lm_checked_yn;
            $co_checked_yn = $caseInfo->co_checked_yn;
            $status = $caseInfo->status;

            if($event == null) {
                if($receipt_gen_yn=='Y' && $lm_checked_yn==null && $co_checked_yn==null && $status=='M') {
                    $authorize = true;
                }
            }
            else {
                if($event == CCS_LM_FIRST) {
                    if($receipt_gen_yn=='Y' && $lm_checked_yn==null && $co_checked_yn==null && $status=='M') {
                        $authorize = true;
                    }
                }
                else if($event == CCS_LM_REVERT) {
                    if($receipt_gen_yn=='Y' && $lm_checked_yn==null && $co_checked_yn==null && $status=='M') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function rtpsLMCheck($case_no, $event) {
            $app_no = $case_no;
            $authorize = false;
            // $appInfo = $this->checkApiAuth("serviceResponse?application_no=", $app_no)->application;
            
            if($event == null) {
                $authorize = true;
                // if($appInfo->pending_with_officer == 'LM') {
                //     $authorize = true;
                // }
            }
            else{
                $authorize = true;
                // if($appInfo->pending_with_officer == 'LM') {
                //     $authorize = true;
                // }
            }
            return $authorize;
        }

        private function rtpsASTCheck($case_no, $event) {
            $app_no = $case_no;
            $authorize = false;
            $appInfo = $this->checkApiAuth("serviceResponse?application_no=", $app_no)->application;
            // echo '<pre>';
            // var_dump($appInfo);
            // die();
            if($event == null) {
                if($appInfo->pending_with_officer == 'AST') {
                    $authorize = true;
                }
            }
            else{
                if($appInfo->pending_with_officer == 'AST') {
                    $authorize = true;
                }
            }
            return $authorize;
        }

        private function nameCorrectionCOCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '1' or '02'
            $operation = $caseInfo->operation;//operation = 's'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn = 'Y' or NULL
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = 'Y' or NULL

            if($event == null) {
                if(($status == '1' && $lm_note_yn == null && $sk_note_yn == null) || ($status == '02' && $lm_note_yn == 'Y' && $sk_note_yn == 'Y')) {
                    $authorize = true;
                }
            }
            else {
                if($event == NAME_CORR_CO_FIRST) {
                    if($status == '1' && $operation == 's' && $lm_note_yn == null && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
                else if($event == NAME_CORR_CO_SECOND) {
                    if($status == '02' && $operation == 's' && $lm_note_yn == 'Y' && $sk_note_yn == 'Y') {
                        $authorize = true;
                    }
                }

                else if($event == NAME_CORR_CO_REVERT) {
                    if(($status == '1' || $status == 'C') && ($operation == 's' || $operation=='a') && $lm_note_yn == 'Y' && $sk_note_yn == 'Y') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function nameCancellationCOCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '01' or '02'
            $operation = $caseInfo->operation;//operation = 'E' or 's'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn = NULL or 'Y'
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = NULL or 'Y'

            if($event == null) {
                if((($status == '1' || $status == '01') && $operation == 'E' && $lm_note_yn == null && $sk_note_yn == null) || ($status == '02' && $operation == 's' && $lm_note_yn == 'Y' && $sk_note_yn == 'Y')) {
                    $authorize = true;
                }
            }
            else {
                if($event == NAME_CANC_CO_FIRST) {
                    if(($status == '1' || $status == '01') && $operation == 'E' && $lm_note_yn == null && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
                else if($event == NAME_CANC_CO_SECOND) {
                    if($status == '02' && $operation == 's' && $lm_note_yn == 'Y' && $sk_note_yn == 'Y') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function ccsCOCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->CitizenCentric_Model->certInfo($case_no);
            $receipt_gen_yn = $caseInfo->receipt_gen_yn;
            $lm_checked_yn = $caseInfo->lm_checked_yn;
            $co_checked_yn = $caseInfo->co_checked_yn;
            $status = $caseInfo->status;
            if($event == null) {
                if($receipt_gen_yn=='Y' && $lm_checked_yn=='Y' && $co_checked_yn==null && $status=='C') {
                    $authorize = true;
                }
            }
            else {
                if($event == CCS_CO_FIRST) {
                    if($receipt_gen_yn=='Y' && $lm_checked_yn=='Y' && $co_checked_yn==null && $status=='C') {
                        $authorize = true;
                    }
                }
                else if($event == CCS_CO_SECOND) {
                    if($receipt_gen_yn=='Y' && $lm_checked_yn=='Y' && $co_checked_yn==null && $status=='C') {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function nameCorrectionSKCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '02'
            $operation = $caseInfo->operation;//operation = 'l'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn = 'Y'
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = NULL

            if($event==null) {
                if($status == '02' && $lm_note_yn == 'Y' && $sk_note_yn == null) {
                    $authorize = true;
                }
            }
            else{
                if($event == NAME_CORR_SK_FIRST) {
                    if($status == '02' && $operation == 'l' && $lm_note_yn == 'Y' && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
                else if($event == NAME_CORR_SK_SECOND) {
                    if($status == '02' && $operation == 'l' && $lm_note_yn == 'Y' && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

        private function nameCancellationSKCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '02'
            $operation = $caseInfo->operation;//operation = 'l'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn = 'Y'
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = NULL

            if($event==null) {
                if($status == '02' && $operation == 'l' && $lm_note_yn == 'Y' && $sk_note_yn == null) {
                    $authorize = true;
                }
            }
            else{
                if($event == NAME_CANC_SK_FIRST) {
                    if($status == '02' && $operation == 'l' && $lm_note_yn == 'Y' && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
                else if($event == NAME_CANC_SK_SECOND) {
                    if($status == '02' && $operation == 'l' && $lm_note_yn == 'Y' && $sk_note_yn == null) {
                        $authorize = true;
                    }
                }
            }
            return $authorize;
        }

//--------------------------End of Custom Functions-------------------------

        //RTPS API Auth
        private function checkApiAuth($url, $ref_no) {
            $url = RTPS_API_LINK. $url . $ref_no ;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonOut = json_decode($output);
    
            if(trim($output)=="" || empty($output) || $output==null) {
                return false;
            }
            else{
                return json_decode($output);
            }
        }

        private function nameCorrectionADCCheck($case_no, $event) {
            $authorize = false;
            $caseInfo = $this->NameCorrectionModelV2->caseInfoForAuthorization($case_no);
            $status = $caseInfo->status;//status = '1' or '02'
            $operation = $caseInfo->operation;//operation = 's'
            $lm_note_yn = $caseInfo->lm_note_yn;//lm_note_yn = 'Y' or NULL
            $sk_note_yn = $caseInfo->sk_note_yn;//sk_note_yn = 'Y' or NULL

            

            if($event == null) {
                if(($status == '1' && $operation == 's' && $lm_note_yn == null && $sk_note_yn == null) || ($status == '02' && $operation == 's' && $lm_note_yn == 'Y' && $sk_note_yn == 'Y')) {
                    $authorize = true;
                }
            }
            else {
                if($event == NAME_CORR_CO_REVERT) {
                    if($status == 'A' && $lm_note_yn == 'Y' && $sk_note_yn == 'Y') {
                        $authorize = true;
                    }
                }

            }
            return $authorize;
        }

        //newly added
        private function rtpsCOCheck($case_no, $event) {
            $app_no = $case_no;
            $authorize = false;
            $appInfo = $this->checkApiAuthMb3($app_no)->application;
            
            if($event == null) {
                if($appInfo->pending_with_officer == 'CO' || $appInfo->pending_with_officer == 'AST' || $appInfo->pending_with_officer == 'LM') {
                    $authorize = true;
                }
            }
            else {
                if($appInfo->pending_with_officer == 'CO' || $appInfo->pending_with_officer == 'AST' || $appInfo->pending_with_officer == 'LM') {
                    $authorize = true;
                }
            }
            return $authorize;
        }

        private function checkApiAuthMb3($ref_no) {
            $url = API_LINK_MB3."getAppDetails";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'application_no=' . $ref_no);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
             if(trim($output)=="" || empty($output) || $output==null) {
                return false;
            }
            else{
                return json_decode($output);
            }
        }

    }

?>
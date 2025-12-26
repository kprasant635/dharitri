<?php
    class FormValidationModel extends CI_Model {
        public function __construct()
        {
            $this->load->library('form_validation');
        }
    //------------------------------Main Function--------------------------------------//
        public function formValidationForPost($post, $arr) {//$arr = rules[], $post = $_POST
            if(empty($arr)) {
                return $this->errorResponse('No data sent for form validation');
            }
            $keyValueFormat = $this->checkKeyValueFormat($arr);//checks whether $arr is in key value pair
            if(!$keyValueFormat) {
                return $this->errorResponse('Input Array not in key value format');
            }
            $refinedArray = $this->refineArray($arr); //eliminates any empty string, extra separators and null values
            $errorMessageArray = $this->formValidate($post, $refinedArray);//outputs empty array if no error
            if(empty($errorMessageArray)) {
                return $this->successResponse('Form Validated');
            }
            else{
                return $this->errorResponse('Form not Validated', $errorMessageArray);
            }
        }
    //-----------------------------End of Main Function--------------------------------//

        private function getRules() {
            return ['digit', 'time', 'date', 'datetime', 'char', '2_digit_decimal', '3_digit_decimal', '4_digit_decimal', 'katha', 'lessa', 'mobile_number', 'application_no', 'case_no', '7_digit_check'];
        }

        private function getConditionalRules() {
            return ['required_on_condition'];
        }

        private function formValidate($post, $arr) {
            $errorMessageOuter = [];
            foreach ($arr as $key => $value) {
                $rules = explode('|', $value);
                $name = $rules[0];
                for($i=1; $i<count($rules); $i++) {
                    if($rules[$i] == 'required') {
                        //required block
                        if(isset($post[$key]) && $post[$key] != '' && $post[$key] != null) {
                            // if(!is_array($post[$key])) {
                            //     $this->form_validation->set_rules($key, $name, $rules[$i]);
                            // }
                            if(is_array($post[$key])){
                                $arrayFlattened = array_flatten($post[$key]);
                                $allow = $this->checkArrayValues($arrayFlattened);
                                if(!$allow) {
                                    $errorMessageOuter[] = $name .' is a required parameter';
                                }
                            }
                        }
                        else{
                            $errorMessageOuter[] = $name .' is a required parameter';
                        }
                    }
                    else {
                        if(in_array($rules[$i], $this->getRules())) {
                            //postParamFormValidation
                            if(isset($post[$key]) && $post[$key] != '' && $post[$key] != null) {
                                if(!is_array($post[$key])) {
                                    $postParamValidation = $this->postParamFormValidation($post[$key], $rules[$i], $name);
                                    if($postParamValidation['status'] == 'n') {
                                        $errorMessageOuter[] = $postParamValidation['message'];
                                    }
                                }
                                else{
                                    $arrayFlattened = array_flatten($post[$key]);
                                    $allow = $this->checkPostValues($arrayFlattened, $rules[$i], $name);
                                    if(!$allow) {
                                        $errorMessageOuter[] = $name .' is not a '. $rules[$i];
                                    }
                                }
                            }
                        }
                        else {
                            //conditional rules
                            $validData = $this->checkIfConditionalRuleIsValid($rules[$i]);
                            if(empty($validData)) {
                                $errorMessageOuter[] = $rules[$i] .' is not a valid conditional statement for '. $name;
                            }
                            else{
                                $rule = $validData['rule'];
                                $conditionSegments = $validData['conditionSegments'];

                                $checkedCondition = $this->{$rule}($conditionSegments, $post, $name, $key);
                                if($checkedCondition['status'] == 'n') {
                                    $errorMessageOuter[] = $checkedCondition['msg'];
                                }
                            }
                        }
                    }
                }
            }
            // if($this->form_validation->run() == false) {
            //     $errorMessageOuter[] = preg_replace('/\s+/', ' ', strip_tags(validation_errors()));
            // }
            return $errorMessageOuter;
        }

        private function checkIfConditionalRuleIsValid($rule) {
            $validData = [];
            $ruleArray = explode('(', $rule);
            if(count($ruleArray)>1) {
                if(method_exists('FormValidationModel', $ruleArray[0])) {
                    $conditionArgumentArray = explode(',', str_replace(')', '', $ruleArray[1]));
                    if($ruleArray[0] == 'required_on_condition') {
                        if(count($conditionArgumentArray) == 3) {
                            $conditionSegments = implode(',', $conditionArgumentArray);
                            $validData = [
                                'rule' => $ruleArray[0],
                                'conditionSegments' => $conditionSegments
                            ];
                        }
                    }
                    else if($ruleArray[0] == 'required_as_option') {
                        if(count($conditionArgumentArray) >0) {
                            $conditionSegments = implode(',', $conditionArgumentArray);
                            $validData = [
                                'rule' => $ruleArray[0],
                                'conditionSegments' => $conditionSegments
                            ];
                        }
                    }
                }
            }
            return $validData;
        }

        private function required_as_option($conditionSegments, $post, $name, $key) {
            $checkRequiredArray = [
                'status' => 'y',
                'errorType' => 2,
                'msg' => ''
            ];
            $conditionSegmentsArray = explode(',', $conditionSegments);
            $parameter = $conditionSegmentsArray[0];
            if(isset($conditionSegmentsArray[1]) && $conditionSegmentsArray[1]!='') {
                $condition2Segments = str_replace(']', '', str_replace('[', '', $conditionSegmentsArray[1]));
                $condition2SegmentsArray = explode('&&', $condition2Segments);
                $main = [];
                foreach ($condition2SegmentsArray as $condition2SegmentsValue) {
                    $mainElement['key'] = explode('=>', $condition2SegmentsValue)[0];
                    $mainElement['value'] = explode('=>', $condition2SegmentsValue)[1];
                    $main[] = $mainElement;
                }
                $condArr = [];
                foreach($main as $row) {
                    if(isset($post[$row['key']]) && $post[$row['key']] == $row['value']) {
                        $condArr[] = 1;
                    }
                    else{
                        $condArr[] = 0;
                    }
                }
            }
            if(isset($conditionSegmentsArray[1]) && $conditionSegmentsArray[1]!='') {
                if(in_array(1, $condArr)) {
                    if(!isset($post[$parameter]) || $post[$parameter] == '' || $post[$parameter] == null) {
                        if(!isset($post[$key]) || $post[$key] == '' || $post[$key] == null) {
                            $checkRequiredArray = [
                                'status' => 'n',
                                'errorType' => 1,
                                'msg' => $name .' is a required parameter'
                            ];
                        }
                    }
                }
            }
            else {
                if(!isset($post[$parameter]) || $post[$parameter] == '' || $post[$parameter] == null) {
                    if(!isset($post[$key]) || $post[$key] == '' || $post[$key] == null) {
                        $checkRequiredArray = [
                            'status' => 'n',
                            'errorType' => 1,
                            'msg' => $name .' is a required parameter'
                        ];
                    }
                }
            }

            return $checkRequiredArray;
        }

        private function required_on_condition($conditionSegments, $post, $name, $key) {
            $checkRequiredArray = [
                'status' => 'y',
                'errorType' => 2,
                'msg' => ''
            ];

            $conditionSegmentsArray = explode(',', $conditionSegments);

            // $parameter = $post[$conditionSegmentsArray[0]];
            $condition = $conditionSegmentsArray[1];
            $valueSegment = str_replace(']', '', str_replace('[', '', $conditionSegmentsArray[2]));
            $valueArr = explode('&&', $valueSegment);

            $condition2 = [];
            foreach ($valueArr as $value) {
                if(isset($post[$conditionSegmentsArray[0]])) {
                    if($post[$conditionSegmentsArray[0]] == $value) {
                        $condition2[] = 1;
                    }
                    else{
                        $condition2[] = 0;
                    }
                }
            }

            if($condition == 'equals') {
                if(in_array(1, $condition2)) {
                    if(!isset($post[$key]) || $post[$key] == '' || $post[$key] == null) {
                        $checkRequiredArray = [
                            'status' => 'n',
                            'errorType' => 1,
                            'msg' => $name .' is a required parameter'
                        ];
                    }
                }
            }
            else if($condition == 'notEquals') {
                if(!empty($condition2) && !in_array(1, $condition2)) {
                    if(!isset($post[$key]) || $post[$key] == '' || $post[$key] == null) {
                        $checkRequiredArray = [
                            'status' => 'n',
                            'errorType' => 1,
                            'msg' => $name .' is a required parameter'
                        ];
                    }
                }
            }
            else{
                $checkRequiredArray = [
                    'status' => 'n',
                    'errorType' => 1,
                    'msg' => 'Error in Conditional Statement for '. $name
                ];
            }
            return $checkRequiredArray;
        }

        private function checkPostValues($postArray, $rule, $name) {
            $allow = true;
            foreach ($postArray as $key => $value) {
                $postParamValidation = $this->postParamFormValidation($value, $rule, $name);
                if($postParamValidation['status'] == 'n') {
                    $allow = false;
                    break;
                }
            }
            return $allow;
        }

        private function checkArrayValues($valueArray) {
            $allow = true;
            foreach ($valueArray as $key => $value) {
                if($value == '' || $value == null || $value == ' ') {
                    $allow = false;
                    break;
                }
            }
            return $allow;
        }

        private function refineArray($arr) {
            $finalArray = [];
            foreach ($arr as $key => $value) {
                $value = trim(preg_replace('/\s+/', '', $value));
                $rules = explode('|', $value);
                $finalRulesArray = [];
                foreach ($rules as $rule) {
                    if($rule != '' && $rule != null && $rule != ' ') {
                        $finalRulesArray[] = $rule;
                    }
                }
                $finalRules = implode('|', $finalRulesArray);
                $finalArray[$key] = $finalRules;
            }
            return $finalArray;
        }

        private function checkKeyValueFormat($arr) {
            $arrKeys = array_keys($arr);
            $arrValues = array_values($arr);
            $response = false;
            if(!empty($arrKeys) && !empty($arrValues) && count($arrKeys) == count($arrValues)) {
                $response = true;
            }
            return $response;
        }


        private function errorResponse($msg, $data = null) {
            $message = '';
            if($data != null) {
                foreach ($data as $dataVal) {
                    if(!is_array($dataVal)) {
                        $message .= ' '. $dataVal;
                    }
                }
                $msg = trim($message);
            }
            return [
                'responseType'=>1,
                'status'=>'n',
                'message'=>$msg,
                'data'=>$data
            ];
        }

        private function successResponse($msg) {
            return [
                'responseType'=>2,
                'status'=>'y',
                'message'=>$msg
            ];
        }

        private function postParamFormValidation($post, $rule, $name) {
            $result = [
                'status'=>'y',
                'message'=>''
            ];
            if($rule == 'digit') {
                if(!preg_match('/^[0-9]*$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not a digit'
                    ];
                }
            }
            else if($rule == 'time') {
                if(!preg_match('/^[0-9]{2}:[0-9]{2}$/', $post) && !preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not in time format'
                    ];
                }
            }
            else if($rule == 'date') {
                if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $post) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $post) && !preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $post) && !preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not in date format'
                    ];
                }
            }
            else if($rule == 'datetime') {
                if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post) && !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}$/', $post) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}\s[0-9]{2}:[0-9]{2}$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not in datetime format'
                    ];
                }
            }
            else if($rule == 'char') {
                if(!preg_match('/^.$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not in single character format'
                    ];
                }
            }
            else if($rule == '2_digit_decimal') {
                if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?)?$/', $post)) {
                    $result = [
                      'status'=>'n',
                      'message'=>'The '. $name .' does not conform to the required 2 decimal digit number'
                    ];
                }
            }
            else if($rule == '3_digit_decimal') {
                if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?)?$/', $post)) {
                    $result = [
                      'status'=>'n',
                      'message'=>'The '. $name .' does not conform to the required 3 decimal digit number'
                    ];
                }
            }
            else if($rule == '4_digit_decimal') {
                if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?[0-9]?)?$/', $post)) {
                    $result = [
                      'status'=>'n',
                      'message'=>'The '. $name .' does not conform to the required 4 decimal digit number'
                    ];
                }
            }
            else if($rule == 'katha') {
                if(!preg_match('/^[0-9]*$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>$name .' must be a digit'
                    ];
                }
                else{
                    if($post>=5) {
                        $result = [
                            'status'=>'n',
                            'message'=>$name .' should not be greater than or equal to 5'
                        ];
                    }
                }
            }
            else if($rule == 'lessa') {
                // if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?[0-9]?)?$/', $post)) {
                if(!preg_match('/^[0-9]+(\.[0-9]+)?$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>$name .' is not in the lessa format'
                    ];
                }
                else{
                    if($post>=20) {
                        $result = [
                            'status'=>'n',
                            'message'=>$name .' should not be greater than or equal to 20'
                        ];
                    }
                }
            }
            else if($rule == 'application_no') {
                $response = applicationNumberValidation($post);
                if(!empty($response)) {
                    $result = [
                        'status'=>'n',
                        'message'=>$name .' has illegal character.'
                    ];
                }
            }
            else if($rule == 'case_no') {
                $response = caseNumberValidation($post);
                if(!empty($response)) {
                    $result = [
                        'status'=>'n',
                        'message'=>$name .' has illegal character.'
                    ];
                }
            }
            else if($rule == 'mobile_number') {
                if(!preg_match('/^[0-9]*$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not a digit'
                    ];
                }
                else{
                    if(strlen($post) != 10) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The '. $name .' is not a 10 digit phone number'
                        ];
                    }
                }
            }
            else if($rule == '7_digit_check') {
                if(!preg_match('/^[0-9]*$/', $post)) {
                    $result = [
                        'status'=>'n',
                        'message'=>'The '. $name .' is not a digit'
                    ];
                }
                else{
                    if(strlen($post) != 7) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The '. $name .' is not a 7 digit number'
                        ];
                    }
                }
            }
            else{

                $result = [
                    'status'=>'n',
                    'message'=>'Rule does not match.'
                ];
            }

            return $result;
        }
    }





?>
<?php

require_once "controller/MyController.php";
require_once "model/User.php";
require_once "model/Template.php";

class ControllerOperation extends MyController
{
    public function index(): void {}

    public function details(): void
    {
        if (isset($_GET['param1'])) {
            $user = $this->get_user_or_redirect();
            $op = Operation::get_operation_by_id($_GET['param1']);
            $list = $op->get_participants();
            $amounts = [];
            foreach ($list as $participant) {
                $amounts[$participant->id] = $op->get_user_amount($participant->id);
            }
            $prev = $op->get_previous();
            $next = $op->get_next();
            (new View("operation"))->show(["user" => $user,
                                            "operation" => $op,
                                            "list" => $list,
                                            "next" => $next,
                                            "previous" => $prev,
                                            "amounts" => $amounts]);
        }
        else {
            Tools::abort("Invalid or missing argument");
        }
    }

    public function add_operation() : void {
        $tricount = Tricount::get_tricount_by_id($_GET['param1']);
        $subscriptors = [];
        $operation = '';
        $subscriptors = $tricount->get_subscriptors_with_creator();
        $templates = Template::get_templates($tricount->id);
        $errors = [];
        $test = '';
        if(isset($_POST['title']) && isset($_POST['amount']) && isset($_POST['operation_date']) && isset($_POST['paid_by'])) {
            $title = $_POST['title'];
            $amount = floatval($_POST['amount']);
            $operation_date = $_POST['operation_date'];
            $created_at = Date("Y-m-d H:i:s");
            $initiator = $_POST['paid_by'];
            $list = self::get_weight($_POST, $tricount);
            $errors = array_merge($errors, self::is_valid_fields($amount, $initiator, $title, $operation_date));
            if(count($errors) == 0){
                $operation = new Operation($title, $tricount, $amount, $operation_date, User::get_user_by_id($initiator), $created_at);
                $errors = $operation->validate_operations();
                if (count($errors) == 0) {
                    $operation->persist_operation();
                    $operation->persist_repartition($operation, $list);
                    $this->redirect('tricount', 'operations', $tricount->id);
                }
            }
        }
        (new View("add_operation"))->show(['tricount'=>$tricount, 'operation'=>$operation, 'subscriptors'=>$subscriptors,
                                            'templates'=>$templates, 'errors'=>$errors]);
    }

    private function is_valid_fields($amount, $initiator, $title, $operation_date) : array {
        $errors = [];
        if(empty($title)){
            $errors ['empty_title'] = "Title is required";
        }
        if(empty($amount)) {
            $errors['empty_amount'] = "Amount is required";
        }
        if(empty($initiator)) {
            $errors['empty_initiator'] = "You must choose an initiator";
        }
        if(empty($operation_date)){
            $errors['empty_date'] = "Date of your operation is required";
        }
        return $errors;
    }

    public function edit_operation() : void {
        $subscriptors = [];
        $templates = '';
        $operation = '';
        $errors = [];
        if(isset($_GET['param1'])){
            $operation = Operation::get_operation_by_id($_GET['param1']);
            $tricount = $operation->tricount;
            $subscriptors = $tricount->get_subscriptors_with_creator();
            $templates = Template::get_templates($tricount->id);
            if(isset($_POST['title']) && isset($_POST['amount']) && isset($_POST['operation_date'])) {
                $operation->title = $_POST['title'];
                $operation->amount = $_POST['amount'];
                $operation->initiator = User::get_user_by_id($_POST['paid_by']);
                $operation->operation_date = $_POST['operation_date'];
                $errors = array_merge($errors, $operation->validate_operations());
                if(count($errors) == 0){
                    $operation->persist_operation();
                    $this->redirect('tricount', 'operations', $tricount->id);
                }
            }
        }
        (new View('edit_operation'))->show(['operation'=>$operation, 'errors'=>$errors,
                                            'subscriptors'=>$subscriptors, 'templates'=>$templates]);
    }

    private function get_whom(array $array, Tricount $tricount) : array
    {   
        $list = $tricount->get_subscriptors_with_creator();
        $result = [];
        foreach($list as $sub) {
            if(array_key_exists($sub->id, $array)){
                $result[] = $sub;
            }
        }
        return $result;
    }

    private function get_weight(array $array, Tricount $tricount) {
        $list = self::get_whom($array, $tricount);
        $result = [];
        foreach($list as $sub) {
/*            if(array_key_exists($sub->full_name, $array)){
                foreach($array as $value => $weight)
                    $result[$sub->full_name] = $weight;
            }*/
            $result[$sub->id] = $array['weight_'.$sub->id];

        }
        return $result;
    }

    public function delete_operation() : void {
        $operation = Operation::get_operation_by_id($_GET['param1']);
        (new View('delete_operation'))->show(['operation'=>$operation]);
    }

    public function confirm_delete_operation() : void {
        $operation = Operation::get_operation_by_id($_GET['param1']);
        $operation->delete_operation_cascade();
        $this->redirect('tricount', 'operations', $operation->tricount->id);
    }
}
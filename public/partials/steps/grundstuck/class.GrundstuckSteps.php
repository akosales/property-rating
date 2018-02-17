<?php

require_once PRT_DIR_HOME . 'vendor/autoload.php';
use Respect\Validation\Validator as v;

class GrundstuckSteps implements Steps {

    private $response = null;

    private function getStepByFile($file) {
        ob_start();
        require $file;
        return ob_get_clean();
    }

    private function prepareResponse() {
        if(empty($this->response)) {
            $dir = plugin_dir_path(__FILE__);
            $files = glob($dir . '/step-*.php');

            foreach ($files as $file) {
                $this->response[] = $this->getStepByFile($file);
            }
        }
    }

    public function getResponse() {
        $this->prepareResponse();
        return $this->response;
    }

    public function validateData() {
		if (!v::intVal()->notEmpty()->validate($_POST['grundflache'])) throw new Exception("Grundfläche wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['erschlossen'])) throw new Exception("Erschlossen-Wert wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['bebauung'])) throw new Exception("Bebaung wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['zuschnitt'])) throw new Exception("Zuschnitt wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['address'])) throw new Exception("Adresse wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['salutation'])) throw new Exception("Anrede wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['firstname'])) throw new Exception("Vorname wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['lastname'])) throw new Exception("Nachname wurde nicht gesetzt");
		if (!v::phone()->validate($_POST['phone'])) throw new Exception("Telefonnummer ist ungültig");
        if (!v::email()->validate($_POST['email'])) throw new Exception("Email ist ungültig");
        
        return true;
    }

    public function collectData() {
        return [
            "type" => "grundstuck",
            "realEstateTypeId" => 1,
            "footprint" => intval($_POST['grundflache']),
            "living_space" => null,
            "floor" => null,
            "rooms" => null,
            "construction_year" => null,
            "opened_up" => $_POST['erschlossen'],
            "building" => $_POST['bebauung'],
            "cut" => $_POST['zuschnitt'],
            "address" => $_POST['address'],
            "salutation" => $_POST['salutation'],
            "firstname" => $_POST['firstname'],
            "lastname" => $_POST['lastname'],
            "phone" => $_POST['phone'],
            "email" => $_POST['email']
        ];
    }

}
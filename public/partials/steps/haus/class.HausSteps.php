<?php

require_once PRT_DIR_HOME . 'vendor/autoload.php';
use Respect\Validation\Validator as v;

class HausSteps implements Steps {

    private $response = null;

    public function getStepByFile($file) {
        ob_start();
        require $file;
        return ob_get_clean();
    }

    public function prepareResponse() {
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
		if (!v::intVal()->notEmpty()->validate($_POST['wohnflache'])) throw new Exception("Wohnfläche wurde nicht gesetzt");
		if (!v::intVal()->notEmpty()->validate($_POST['etage'])) throw new Exception("Etage wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['zimmer'])) throw new Exception("Zimmer wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['baujahr'])) throw new Exception("Baujahr wurde nicht gesetzt");
        if (!v::stringType()->notEmpty()->validate($_POST['address'])) throw new Exception("Adresse wurde nicht gesetzt");
        if (!v::stringType()->notEmpty()->validate($_POST['salutation'])) throw new Exception("Anrede wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['firstname'])) throw new Exception("Vorname wurde nicht gesetzt");
		if (!v::stringType()->notEmpty()->validate($_POST['lastname'])) throw new Exception("Nachname wurde nicht gesetzt");
		if (!v::phone()->validate($_POST['phone'])) throw new Exception("Telefonnummer ist ungültig");
        if (!v::email()->validate($_POST['email'])) throw new Exception("Email ist ungültig");
    }

    public function collectData() {
        return [
            "type" => "haus",
            "realEstateTypeId" => 1,
            "footprint" => intval($_POST['grundflache']),
            "living_space" => intval($_POST['wohnflache']),
            "floor" => $_POST['etage'],
            "rooms" => $_POST['zimmer'],
            "construction_year" => $_POST['baujahr'],
            "opened_up" => null,
            "building" => null,
            "cut" => null,
            "address" => $_POST['address'],
            "salutation" => $_POST['salutation'],
            "firstname" => $_POST['firstname'],
            "lastname" => $_POST['lastname'],
            "phone" => $_POST['phone'],
            "email" => $_POST['email']
        ];
    }

}
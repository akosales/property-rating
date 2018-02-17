<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.makler-anfragen.immo
 * @since      1.0.0
 *
 * @package    Prt
 * @subpackage prt/public/partials
 */

//HELPER functions
function inlineSVG($svg_file_string) {
    $svg = file_get_contents($svg_file_string);
    $dom = new DOMDocument();
    $dom->loadHTML($svg);
    foreach($dom->getElementsByTagName('svg') as $element) {
        $element->setAttribute('class','svg-icon');  
    }
    $dom->saveHTML();
    $svg = $dom->saveHTML();
    $svg = str_replace("<?xml version=\"1.0\"?>\n", '', $svg);
    echo $svg;
}

?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?= $this->settings->get_option('google-api-key', 'prt_settings_general'); ?>&libraries=places&sensor=false"></script>

<div id="prt-root" class="full-width">

    <div class="overlay"></div>

    <div class="dialog">
        <div class="dialog-header">
            
        </div>
        <div class="dialog-body">
            <div class="dialog-emoji"></div> 
            <div class="text"></div>
        </div>
    </div>

    <div class="loader">
        <img src="<?= plugin_dir_url(__DIR__) . 'img/loader.svg' ?>" alt="loader" />
    </div>

    <div class="privacy">
        <div class="text"><?= $this->settings->get_option('privacy-policy', 'prt_settings_general', '') ?></div>
    </div>

    <div class="progress-bar">
        <div style="width:0%" class="progress"></div>
    </div>

    <br/>

    <div class="steps">
        <div class="root step">
            <h2>Welche Immobilie möchten Sie <span>verkaufen?</span></h2>
            <section>
                <div class="options data" data-key="type" data-has-input="false">
                    <div class="option-box" data-value="wohnung">
                        <?php @inlineSVG(plugin_dir_path(__DIR__) . 'img/wohnung.svg') ?>
                        Wohnung
                    </div>
                    <div class="option-box" data-value="haus">
                        <?php @inlineSVG(plugin_dir_path(__DIR__) . 'img/haus.svg') ?>
                        Haus
                    </div>
                    <div class="option-box" data-value="grundstuck">
                        <?php @inlineSVG(plugin_dir_path(__DIR__) . 'img/grundstuck.svg') ?>
                        Grundstück
                    </div>
                </div>
            </section>
            <button type="button" class="button load next">Weiter</button>
        </div>
        <div class="step">
            <h2>In welcher Region befindet sich die Wohnung?</h2>
            <section>
                <input required="required" type="text" name="address" class="adress-input" placeholder="Straße Nummer, PLZ, Stadt" />
            </section>
            <button type="button" class="button prev">Zurück</button>
            <button type="button" class="button next validateAddress">Weiter</button>
        </div>
        <div class="step">
            <h2>Fordern Sie jetzt Ihr Angebot von <?= $this->settings->get_option('company-name', 'prt_settings_general', '') ?> an.</h2>
            <section>
                <div class="left-content">
                    <select class="salutation" required="required" name="salutation">
                        <option value="Frau">Frau</option>
                        <option value="Herr">Herr</option>
                    </select>
                    <input type="text" name="firstname" class="form-input" placeholder="Vorname *" required="required" />
                    <input type="text" name="lastname"  class="form-input" placeholder="Nachname *" required="required" />
                    <input type="text" name="phone"     class="form-input" placeholder="Telefonnummer *" required="required" />
                    <input type="email" name="email"     class="form-input" placeholder="Ihre E-Mail-Adresse *" required="required" />
                    <div class="privacy-read-text"><input type="checkbox" class="privacy-read" name="privacy-read" required="required" /> Ich habe die Hinweise zum <a href="#" class="openPrivacy">Datenschutz</a> gelesen und akzeptiere diese.</div>
                </div>
                <div class="right-content">
                    <div class="benefits">
                    <?= $this->settings->get_option('advantages', 'prt_settings_general', '') ?>
                    </div>
                </div>
            </section>
            <button type="button" class="button prev">Zurück</button>
            <button type="button" class="button finish">Absenden</button>
        </div>
        <div class="step">
            <h2></h2>
            <section>
                <div class="result">
                    <h2>Ermittelter Wert <span class="prt-resultAbsolute"></span></h2>
                    <div class="results">
                        <div class="marktwert">Ermittelter durchschnittlicher Marktwert</div> <strong><span class="prt-resultAbsolute"></span></strong>
                        <br />
                        <div class="wohnflaeche">Durchschnittlicher Wert pro m² Wohnfläche</div><strong><span class="prt-resultPerSqm"></span></strong>
                        <br />
                        <div class="res-wertspanne">Resultierende Wertspanne</div> <strong><span class="prt-lowAbsolute"></span> - <span class="prt-highAbsolute"></span></strong>
                        <br />
                        <div class="erm-wertspanne">Ermittelte Wertspanne pro m²</div> <strong><span class="prt-lowPerSqm"></span> - <span class="prt-highPerSqm"></span></strong>
                        <br />
                    </div>
                </div>
                <div class="no_rate">
                    <span style="font-size:42px">☺️</span>
                    <h2>Danke für Ihr Vertrauen!</h2>
                    <h3>Wir melden uns so bald wie möglich</h3>
                </div>
            </section>
            <button type="button" class="button prev">Zurück</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    var input = document.getElementsByClassName('adress-input');
    var autocomplete = []; 
    for(var i=0;i<input.length;i++) {
        autocomplete[i] = new google.maps.places.Autocomplete(input[i]);
    }
</script>
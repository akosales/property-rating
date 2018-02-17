<?php
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
<div class="step">
    <h2>Wie viele Etagen hat das Haus?</span></h2>
    <section>
        <div class="options data" data-key="etage" data-has-input="false">
            <div class="option-box" data-value="1">
                <?php @inlineSVG(PRT_DIR_HOME_URL. 'public/img/floor-1.svg') ?>
                1
            </div>
            <div class="option-box" data-value="2">
                <?php @inlineSVG(PRT_DIR_HOME_URL. 'public/img/floor-2.svg') ?>
                2
            </div>
            <div class="option-box" data-value="3">
                <?php @inlineSVG(PRT_DIR_HOME_URL. 'public/img/floor-3.svg') ?>
                Mehr als 2
            </div>
        </div>
    </section>
    <button type="button" class="button prev">Zurück</button>
    <button type="button" class="button next">Weiter</button>
</div>
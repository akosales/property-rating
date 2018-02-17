<?php

class Prt_Styler {

    public function __consturct() {}

    public function generateCss($sourceFile, $generatedFile, $toBeReplaced) {        
        file_put_contents($generatedFile, strtr(file_get_contents($sourceFile), $toBeReplaced));
    }

}
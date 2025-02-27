<?php

// Dynamically add stylesheet links to a page
function link_stylesheet($stylesheetArray) {
    if (!$stylesheetArray) {
        return;
    }

    $time = time(); // Force browser to reload css instead of loading old css from cache
    
    if (is_array($stylesheetArray)) {
        foreach ($stylesheetArray as $stylesheet) {
            echo "<link rel='stylesheet' href='$stylesheet?v=$time' />";
        }
    } 
}

// Dynamically embed scripts into a page
function link_script($scriptArray) {
    if (!$scriptArray) {
        return;
    }
    
    if (is_array($scriptArray)) {
        foreach ($scriptArray as $script) {
            echo "<script src='$script'></script>";
        }
    }
}
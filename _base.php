<?php

function link_stylesheet($stylesheetArray) {
    if (!$stylesheetArray) {
        return;
    }
    
    if (is_array($stylesheetArray)) {
        foreach ($stylesheetArray as $stylesheet) {
            return "<link rel='stylesheet' href='$stylesheet' />";
        }
    } 
}

function link_script($scriptArray) {
    if (!$scriptArray) {
        return;
    }
    
    if (is_array($scriptArray)) {
        foreach ($scriptArray as $script) {
            return "<script src='$script'></script>";
        }
    }
}
<?php

function link_stylesheet($stylesheets) {
    if (!$stylesheets) {
        return;
    }
    
    if (is_array($stylesheets)) {
        foreach ($stylesheets as $stylesheet) {
            echo "<link rel='stylesheet' href='$stylesheet' />";
        }
    } else {
        echo "<link rel='stylesheet' href='$stylesheets' />";
    }
}
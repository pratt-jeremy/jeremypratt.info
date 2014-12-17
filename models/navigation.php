<?php

function GetPrimaryNavigationItems()
{
    $nav = array(
        'home' => 'Home',
        'about' => 'About',
        'work'  => 'Work',
        'music' => 'Music',
        'contact' => 'Contact'
    );
    
    if (CheckSession())
    {
        $nav['menu'] = 'Menu';
        $nav['logout'] = 'Log Out';
    }
    else
    {
        $nav['login'] = 'Log In';
    }
    
    return $nav;
}

function GetFooterItems() {
    $footer = array(
     'siteplan' => 'Site Plan',
     'teaching-presentation' => 'Teaching Presentation'
     
    );
}

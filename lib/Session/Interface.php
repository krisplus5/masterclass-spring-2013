<?php

interface Session_Interface {
        
    public function __construct();
    
    public function __get($name);
    
    public function __set($name, $value);
    
    public function authenticate();
    
    public function unauthenticate();
    
    public function isAuthenticated();
    
    public function regenerate();

    public function destroy();
    
}
<?php

abstract class BaseController {
    
    protected $model;
    protected $view;
    
    public function __construct($model) {
        $this->model = $model;
        $this->view = new View(); // Assumer qu'il y a une classe View pour afficher la vue
    }
    
    // Méthodes abstraites à implémenter dans les classes concrètes
    abstract public function index();
    abstract public function create();
    abstract public function edit($id);
    abstract public function delete($id);
    abstract public function show($id);
    
    // Méthode d'erreur par défaut
    public function error($message) {
        echo "Erreur: " . $message;
    }
}

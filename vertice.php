<?php
    class Vertice{
        private $id;
        private $visitado;
        private $siguiente;
        
        public function __construct($id) {
            $this->id = $id;
            $this->siguiente = null;
            $this->visitado = false;
        }
        
        public function getId() {
            return $this->id;
        }

        public function getVisitado() {
            return $this->visitado;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function setVisitado($visitado){
            $this->visitado = $visitado;
        }
        
        public function getSiguiente() {
            return $this->siguiente;
        }

        public function setSiguiente($siguiente) {
            $this->siguiente = $siguiente;
        }
    }
?>
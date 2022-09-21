<?php
    include ('./Vertice.php');
    
    class Grafo {
        private $matriz;
        private $vector;
        private $dirigido;
        
        public function __construct($dir = true) {
            $this->matriz = null;
            $this->vector = null;
            $this->dirigido = $dir;
        }
        
        public function agregarVertice($info) {
            $vertice = new Vertice($info);
            
            if(!isset($this->vector[$vertice->getId()])) {
                $this->matriz[$vertice->getId()] = null;
                $this->vector[$vertice->getId()] = $vertice;
            } else {
                return false;
            }
            
            return true;
        }
        
        public function getVertice($id) {
            return $this->vector[$id];
        }
        
        public function agregarArista($verticeA, $verticeB, $peso = null) {
            if(isset($this->vector[$verticeA]) && isset($this->vector[$verticeB])) {
                $this->matriz[$verticeA][$verticeB] = $peso;
            } else {
                return false;
            }
            
            return true;
        }
        
        public function getAdyacentes($id) {
            return $this->matriz[$id];
        }
        
        public function getMatriz() {
            return $this->matriz;
        }
        
        public function getVector() {
            return $this->vector;
        }
        
        public function gradoSalida($id) {
            $contador = 0;
            
            if ($this->matriz[$id] != null) {
                foreach ($this->matriz[$id] as $keyVector => $valor) {
                    $contador ++;
                }
            }
            
            return $contador;
        }
        
        public function gradoEntrada($id) {
            $gradoEntrada = 0;
            
            if ($this->matriz != null) {
                foreach ($this->matriz as $valor1 => $adyacente) {
                    if ($adyacente != null) {
                        foreach ($adyacente as $valor2 => $pe) {
                            if ($valor2 == $id) {
                                $gradoEntrada ++;
                            }
                        }
                    }
                }
            }
            
            return $gradoEntrada;
        }
        
        public function grado($id) {
            return $this->gradoSalida($id) + $this->gradoEntrada($id);
        }
        
        public function eliminarArista($verticeA, $verticeB) {
            if (isset($this->matriz[$verticeA][$verticeB])) {
                unset($this->matriz[$verticeA][$verticeB]);
            } else {
                return false;
            }
            
            return true;
        }
        
        public function eliminarVertice($id) {
            if (isset($this->vector[$id])) {
                foreach ($this->matriz as $valor1 => $adyacentes) {
                    if ($adyacentes != null) {
                        foreach ($adyacentes as $valor2 => $indice) {
                            if ($valor2 == $id) {
                                unset($this->matriz[$valor1][$valor2]);
                            }
                        }
                    }
                }
                
                unset($this->matriz[$id]);
                unset($this->vector[$id]);
            } else {
                return false;
            }
            
            return true;
        }
    }
    ?>
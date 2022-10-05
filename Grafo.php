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
            if (isset($this->vector[$id])) {
                return $this->matriz[$id];
            }
            
            return false;
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
        
        public function caminoMasCorto($verticeA, $verticeB){
            $pesos = array();
            $etiquetas = array();
            
            if (isset($this->vector[$verticeA]) && isset($this->vector[$verticeB])) {
                foreach (array_keys($this->matriz) as $distancia) $pesos[$distancia] = 99999;

                    $pesos [$verticeA] = 0;

                    while (!empty($pesos)) {
                        $minimo = array_search(min($pesos), $pesos);
                        if ($minimo == $verticeB) break;

                        foreach ($this->matriz[$minimo] as $vertice => $distancia) if (!empty($pesos[$vertice]) && $pesos[$minimo] + $distancia < $pesos[$vertice]) {
                            $pesos[$vertice] = $pesos[$minimo] + $distancia;
                            $etiquetas[$vertice] = array($minimo, $pesos[$vertice]);
                        }

                        unset($pesos[$minimo]);
                    }

                    $camino = array();
                    $posicion = $verticeB;

                    while ($posicion != $verticeA) {
                        $camino[] = $posicion;
                        $posicion = $etiquetas[$posicion][0];
                    }

                    $camino[] = $verticeA;
                    $camino = array_reverse($camino);

                    return $camino;
            }
            
            return false;
        }
        
        public function recorridoProfundidad($idVertice) {
            $pila = array();
            $recorrido = array();
            
            if (isset($this->vector[$idVertice])) {
                $valor = $this->getVertice($idVertice);
                array_push($pila, $valor);
                
                while (!empty($pila)) {
                    $nodoVisitado = array_pop($pila);
                    
                    if (($nodoVisitado->getVisitado()) == false) {
                        $nodoVisitado->setVisitado(true);
                        $recorrido[] = $nodoVisitado->getId();
                        
                        if ($this->getAdyacentes($nodoVisitado->getId()) != null) {
                            foreach ($this->getAdyacentes($nodoVisitado->getId()) as $keyVector => $valorVector) {
                                $auxiliar = $this->getVertice($keyVector);
                                $pila[$auxiliar->getId()] = $auxiliar;
                            }
                        }
                    }
                }
                foreach ($this->vector as $vertice) {
                    $vertice->setVisitado(false);
                }

                return $recorrido;
            }
            
            return false;
        }
        
        public function recorridoAnchura($idVertice) {
            $cola = array();
            $recorrido = array();
            
            if (isset($this->vector[$idVertice])) {
                $valor = $this->getVertice($idVertice);
                array_push($cola, $valor);
                
                while (!empty($cola)) {
                    $nodoVisitado = array_shift($cola);
                    
                    if (($nodoVisitado->getVisitado()) == false) {
                        $nodoVisitado->setVisitado(true);
                        $recorrido[] = $nodoVisitado->getId();
                        
                        if ($this->getAdyacentes($nodoVisitado->getId()) != null) {
                            foreach ($this->getAdyacentes($nodoVisitado->getId()) as $keyVector => $valorVector) {
                                $auxiliar = $this->getVertice($keyVector);
                                $cola[$auxiliar->getId()] = $auxiliar;
                            }
                        }
                    }
                }
                foreach ($this->vector as $vertice) {
                    $vertice->setVisitado(false);
                }

                return $recorrido;
            }
            
            return false;
        }
    }
    ?>
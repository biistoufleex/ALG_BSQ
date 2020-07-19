<?php

// recupere contenue de mon fichier
$files = file_get_contents($argv[1]);
// var_dump($files);

// stock et suprime premiere ligne
$map = explode("\n", $files);
$hauteurMap = array_shift($map);

// creation du tableau a deux dimension
for ($i=0; $i < $hauteurMap; $i++) { 
    $map[$i] = str_split($map[$i]);
}
// garde la map de base pour placer les X
$defaultMap = $map;
$largeurMap = count($map[0]);

for ($i =0; $i < $hauteurMap; $i++) {
    for ($j=0; $j < $largeurMap; $j++) { 
        if ($map[$i][$j] == ".") {
            $map[$i][$j] = 1;
        } else {
            $map[$i][$j] = 0;
        }
    }
}  
// print_r($map);
// print_r($defaultMap);

function prepareMap($map, $hauteurMap, $largeurMap){
    for ($i =0; $i < $hauteurMap; $i++) {
        for ($j=0; $j < $largeurMap; $j++) { 
            // si la case est un obstacle -> 0
            if ($map[$i][$j] == 0) {
                // echo "0 ";
            }
            // si la case est au bord de la map -> 1
            elseif ($i == 0 || $j == 0) {
                // echo "1 ";
                $map[$i][$j] = 1;
            } 
            // sinon valeur min +1 
            else {
                // echo min($map[$i-1][$j], $map[$i][$j-1], $map[$i-1][$j-1])+1 . ' ';
                $map[$i][$j] = min($map[$i-1][$j], $map[$i][$j-1], $map[$i-1][$j-1])+1;
            }
        }
        // echo "\n";
    }
    return $map;    
}

function posOfBigestSquare($map, $hauteurMap, $largeurMap) {
    $max = 0;
    $position = [];
    for ($i =0; $i < $hauteurMap; $i++) {
        for ($j=0; $j < $largeurMap; $j++) { 
            if ($map[$i][$j] > $max) {
                $max = $map[$i][$j];
                $position["ligne"] = $i;
                $position["colone"] = $j;
                $position["taille"] = $map[$i][$j];
            }
        }
    }
    return $position;
}

function addXtoMap($map, $position) {
    $ligne = $position['ligne'];
    $colone = $position['colone'];
    for ($i=0; $i < $position['taille'] ; $i++) { 
        for ($j=0; $j < $position['taille']; $j++) { 
            $map[$ligne][$colone] = "x";
            $colone--;
        }
        $ligne--;
        $colone = $position['colone'];
    }
    return $map;
}

// affiche la map en carre plus propre
function showClearMap($map, $hauteurMap, $largeurMap) {
    for ($i =0; $i < $hauteurMap; $i++) {
        for ($j=0; $j < $largeurMap; $j++) { 
            echo $map[$i][$j];
        }
        echo "\n";
    }
}
$map = prepareMap($map, $hauteurMap, $largeurMap);
// print_r($map);
$position = posOfBigestSquare($map, $hauteurMap, $largeurMap);
// print_r($position);
$map = addXtoMap($defaultMap, $position);
// print_r($map);
// showClearMap($defaultMap, $hauteurMap, $largeurMap);
showClearMap($map, $hauteurMap, $largeurMap);


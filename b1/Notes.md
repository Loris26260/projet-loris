Notes
<?php
    // commentaire 

    /**
     * commentaire multi lignes 
     */

     $texte = 'bonjour' ;
     $nombre = 42;
     // les structures de controle
     if ($nombre > 42)
    {
        echo 'le nombre est supérieur a 42' ;
    }elseif ($nombre == 42) {
        echo 'le nombre est 42';
    }else{
        echo 'le nombre est inferieur a 42';
    }

    //Les boucles 
    for ($i =0; $i<10; $i++) {
        #code...
        echo $i . ' ';
    }

    // Les fonctions
    function addition ($a , $b){
        return $a + $b;
    }

    echo '<br>';
    echo addition(45 , 10);
?>

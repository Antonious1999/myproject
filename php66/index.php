<?php 

$username = "Pierre" ;
// concatenation => . 
/*
    multi_comment
*/
/*
    Ternary if
    =============
    condition ? true : false
*/
echo $username=="AMIT" ? "hello Admin <br>" : "Hello ". $username ."<br>" ;

// if($username == "AMIT"){
//     echo "hello Admin" ;
// }else{
//     echo "Hello ". $username ;

// }

// $infos = ["pierre" , "123"  , "pierre@info.com"];

// echo $infos[0] . "<br>";
// echo $infos[1] . "<br>";
// echo $infos[2] . "<br>";
// echo $infos[3] . "<br>";  

// echo count($infos)  ;
// for($index = 0 ; $index < count($infos) ; $index++){
//     echo $infos[$index] ."<br>";
// }

//associative array
$informations =[
    "username" => "pierre", 
    'password' => "123" , 
    'email'  => "pierre@info.com" 
];

// echo $informations["username" ];

foreach($informations as $information){
        echo $information . "<br>";
}

$x = 6 ; 
while($x < 5){
    echo $x . "<br>"; 
    $x++ ;
}

// do{
//     echo $x . "<br>"; 
//     $x++ ;
// }while($x < 5)


function sayHello($username){
    //block scope
    return "hello "  .$username."<br>";
}
//global scope 
echo sayHello("AMIT");
?>

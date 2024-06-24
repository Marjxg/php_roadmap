<?php
    // one-line comment
    #  one-line comment
    /*  Multi-line
        comment */

        // Data types
    /*var_dump(TRUE);
    var_dump(7.5);
    var_dump("hello");
    var_dump(-13);*/

        // Variables
    $variable="hello world!";
    $_variable="case sensitive and loosely typed";
    $UpperCamelCase="First letter is capitalized";
    $lowerCamelCase="First letter is not capitalized";
    $UPPERCASE="Used for constants";
    $Snake_case="Uses underscores";

    echo $variable;
    echo '<br>';
    $variable = 10;
    echo $variable;
    echo '<br>';

        // Constants
    define("Old_constant", 3.1416);
    const New_constant = 3.1416;
    echo Old_constant;
    echo '<br>';
    echo New_constant;
    echo '<br>';

        //Arrays
    define("Colors", array(
        "blue",
        "red",
        "yellow",
        "orange",
        "purple",
        "green"
    ));
    echo Colors[0];
    echo '<br>';

    $students1=array("Carlos", "Jose", "Vanessa", "Katy");
    $students2=["Carlos", "Jose", "Vanessa", "Katy"];
    echo $students1[3];
    echo '<br>';
    echo $students2[0];
    echo '<br>';

    $principal=[
        "name"=>"Julian",
        "last_name"=>"Smith",
        "age"=>25
    ];
    echo $principal["age"]; 
    echo '<br>';  
    
    $teacher=[
        "name"=>"Emily",
        "last_name"=>"Smith",
        "age"=>31,
        "courses"=>["PHP","Python","CSS"]
    ];
    echo $teacher["courses"][1]; 
    echo '<br>';

        // Function count
    echo count($teacher);
    echo '<br>';
    echo count($teacher, COUNT_RECURSIVE);
    echo '<br>';

        //Concatenation
    $name="Marjorie";
    $country="Guatemala";
    $togheter = "I'm ".$name." and I'm from ".$country;
    echo $togheter;
    echo '<br>';
    echo "I'm $name and I'm from $country";
    echo '<br>';

        // Operators
    // Arithmetic
    // + - * / % **

    //Assignment
    // = += -= *= /= %= .=
    // Where .= means concatenate and assign

    //Comparison
    // == === !=  <> !== > < >= <= <=>
    // Where === means identical
    // Where <> means not equal, same as !=
    // Where !== means not identical
    // Where <=> means spaceship (-1,0,1)

    //Logical
    // and or xor && || !

    //Increment-Decrement
    //++$x $x++ --$x $x--
    //Pre -> does it and then returns it
    //Post -> return and then does it

        //Referencing
    $text="Marjorie Reyes";
    $no_reference=$text;
    $reference=&$text;
    echo $reference;
    echo '<br>';
    $text = "Gissell Franco";
    echo $reference;
    echo '<br>';

        // Conditionals
    $comparison = 5;
    if ($comparison > 3) {
        if($comparison < 5):
            echo "I'm in the if statement";
        else:
            echo "I'm in the else statement";    
            echo '<br>';
        endif;
    } elseif ($comparison > 6) {
        echo "I'm in the if else statement";
    } else {
        echo "I'm in the else statement";
    }

        // Short hand if
    $a = 5;
    if ($a < 10) $b = "Hello";    
    echo $b;
    echo '<br>';

        // Short hand if else
    $a = 13;
    $a < 10 ? $b="Hello" : $b="Good Bye";        
    echo $b;
    echo '<br>';

        // Switch statement
    $fruit="strawberry";

    switch($fruit){
        case "banana":
            echo "It's a banana";
            echo '<br>';
            break;
        case "apple":
            echo "It's an apple";
            echo '<br>';
            break;
        case "strawberry":
            echo "It's and strawberry";
            echo '<br>';
            break;
        default:
            echo "It's not a fruit";
    }

        // Match statement
    $a = 15;
    $x = 5;
    $y = 10;
    $z = 15;
    $result = match($a) {
        $x => "a it's equal to x",
        $y => "a it's equal to y",
        $z => "a it's equal to z",
        default => "a it's not equal to none of them"
    };
    echo $result;
    echo '<br>';

    $age = 18;
    $result = match(true){
        $age >= 60 => "third age",
        $age >= 30 => "Adult",
        $age >= 18 => "Young adult",
        default => "You are a child"
    };
    echo $result;
    echo '<br>';

        // Loops

    // While
    $counter=1;
    while($counter <= 20){
        echo $counter;
        if ($counter < 20) echo ',';
        $counter++;
    }
    echo '<br>';

    // Do - while
    $counter = 12;
    $table = 7;
    do{
        echo $table."x".$counter." = ".$table*$counter."<br>";
        $counter--;
    }while($counter>=1);

    // For 
    for($i=1; $i<=20; $i++){
        $i < 20 ? $msg = $i.',' : $msg = $i."<br>";
        echo $msg;
    }

    // For - each
    foreach($students1 as $s){
        echo $s;
    }
    echo "<br>";
    foreach($principal as $key => $value){
        echo $key.":".$value."<br>";
    }
?>
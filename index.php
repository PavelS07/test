<?php

function normalize($input)
{
// ...
    $pattern1 = '/\/\.\//';
    $pattern2 = '/(\/\w+\/)(\.\.\/*)/';
    while(preg_match($pattern1, $input) || preg_match($pattern2, $input)) {
        $input = preg_replace($pattern1, '/', $input);
        $input = preg_replace($pattern2, '/', $input);
    }

    return '/'.trim($input,'/'); // тут можно найти вхождение substr, но торопился оставлю так

}

$input1 = "/var/./lib/../test";
$input2 = "/var/lib/../../test";
$input3 = "/var/lib1/lib2/lib3/././././././lib4/../../../..";

$output1 = normalize($input1);
$output2 = normalize($input2);
$output3 = normalize($input3);

echo $output1 . "\n"; // expected output: /var/test
echo $output2 . "\n"; // expected output: /test
echo $output3 . "\n"; // expected output: /var
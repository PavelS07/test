function normalize($input)
{
// ...
    $pattern = '/(\/\.\/)|(\/\w+\/)(\.\.\/*)/'; //объединил условием 'или' две регулярки

    // 1 способ цикл, выполняется за время 3.6577639579773 на 1000000 итерациях

//    while(preg_match($pattern, $input)) $input = preg_replace($pattern, '/', $input);
//
//    return '/'.trim($input,'/'); // тут можно найти вхождение substr, но торопился оставлю так

    // 2 способ рекурсия, выполняется за время 3.9290769100189 на 1000000 итерациях

//    if(preg_match($pattern, $input)) $input = preg_replace($pattern, '/', $input);
//    else return '/'.trim($input,'/');
//
//    $input = normalize($input);
//    return $input;

    // 3 способ регулярка для ./, выполняется за время 2.8136131763458 на 1000000 итерациях
//    $input = preg_replace('/(\/)(\.\/)+/', '\1', $input);
//    while (preg_match('/(\/\w+\/)(\.\.\/*)/', $input)) $input = preg_replace('/(\/\w+\/)(\.\.\/*)/', '/', $input);
//
//    return '/' . trim($input, '/');
//
    // 4 способ stack выполняется за время 1.8260325193405 на 1000000 итерациях (цикл for вместо foreach замедляет работу, проверил)

    $elements = explode('/', $input);
    $stack = [];

    foreach ($elements as $element) {
        if ($element == '.') continue;
        else if ($element == '..') {
            array_pop($stack);
        } else {
            array_push($stack, $element);
        }
    }

    return implode('/', $stack);
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

<?php

$file = fopen("LIST OF CRIMES ELIGIBLE FOR EXPUNGEMENT.txt","r");
while ($line =  fgets($file)) {

$parts=[]; 

preg_match('/(.*)\s(\d{3}\.*\d{0,3})/',$line, $parts);
if (count($parts)==3){
printf("%-8.8s %s\n",$parts[2],$parts[1]);
} else {
print "ERROR:|$line";
}
};
fclose($file);
